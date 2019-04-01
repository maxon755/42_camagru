<?php

namespace app\base;

use app\components\CaseTranslator;

class DataBase extends Application
{
    private $pdo;
    private $tableName;

    private static $dbInstance;

    /**
     * DataBase constructor.
     * @param array|null $config
     */
    private function __construct(array $config=null)
    {
        $this->getConnection($config);
    }

    /**
     * @param string|null $tableName
     * @param array|null $config
     * @return DataBase
     */
    public static function getInstance(string $tableName=null, array $config=null): DataBase
    {
        if (!self::$dbInstance)
            self::$dbInstance = new self($config);

        if ($tableName !== null) {
            self::$dbInstance->useTable($tableName);
        }
        return self::$dbInstance;
    }

    /**
     * @param array|null $config
     */
    private function getConnection(array $config=null): void
    {
        $config = $config ? $config : self::$config['db'];

        $driver     = $config['driver'];
        $host       = $config['host'];
        $dbname     = $config['dbname'];
        $user       = $config['user'];
        $password   = $config['password'];

        $dsn = "{$driver}:host={$host};dbname={$dbname};user={$user};password={$password}";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new \PDO($dsn, $user, $password, $options);
    }

    /**
     * @param string $tableName
     * @return DataBase
     */
    public function useTable(string $tableName): DataBase
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->tableName;";
        return $this->executeQuery($query);
    }

    /**
     * @param array $where
     * @param string|null $operator
     * @return array
     */
    public function selectWhere(array $where, array $columns = [], string $operator = null): array
    {
        $columns = empty($columns) ? ['*'] : $columns;
        $columnsString = implode(', ', $columns);
        $where = CaseTranslator::keysTo('snake', $where);
        $whereString =  $this->prepareWhereData($where, $operator);
        $query = "SELECT ${columnsString} FROM $this->tableName WHERE ${whereString};";

        return $this->executeQuery($query, $where);
    }

    public function select(
        string $sql,
        array $where = [],
        array $groupBy = [],
        array $orderBy = [],
        int $offset = null,
        int $limit = null
    ): array {
        if (!empty($where)) {
            $where = CaseTranslator::keysTo('snake', $where);
            $whereString = "\nWHERE " . $this->prepareWhereData($where);
            $sql .= $whereString;
        }

        if (!empty($groupBy)) {
            $groupByString = "\nGROUP BY " . implode(', ', $groupBy);
            $sql .= $groupByString;
        }

        if (!empty($orderBy)) {
            $orderBy = CaseTranslator::keysTo('snake', $orderBy);
            $orderByString = "\nORDER BY " . $this->prepareOrderByData($orderBy);
            $sql .= $orderByString;
        }

        if ($offset) {
            $sql = $sql . ' ' . "OFFSET $offset";
        }
        if ($limit) {
            $sql = $sql . ' ' . "LIMIT $limit";
        }

        return $this->executeQuery($sql, $where);
    }

    /**
     * @param array $data
     * @param string|null $operator
     * @return string
     */
    private function prepareWhereData(array $data, string $operator = null): string
    {
        $shouldSeparate = count($data) - 1;
        $operator = $operator ?: 'AND';
        $res = '';
        foreach (array_keys($data) as $key) {
            $res .= $key . ' = :'. $key;
            if ($shouldSeparate--) {
                $res .= ' ' . $operator . ' ';
            }
        }

        return $res;
    }

    /**
     * @param array $data
     *
     * $data = [
     *      'column1' => 'DESC',
     *      'column2' => 'ASC',
     * ]
     *
     * @return string
     */
    public function prepareOrderByData(array $data): string
    {
        $shouldSeparate = count($data) - 1;
        $operator = ',';
        $res = '';
        foreach ($data as $key => $value) {
            $res .= $key . ' ' . $value;
            if ($shouldSeparate--) {
                $res .= ' ' . $operator . ' ';
            }
        }

        return $res;
    }

    /**
     * @param array $data
     * @param null|string $returning
     * @return bool|array
     */
    public function insert(array $data, ?string $returning = null)
    {
        $data = CaseTranslator::keysTo('snake', $data);
        $insertData = $this->prepareInsertData($data);
        $columns    = $insertData['columns'];
        $holders    = $insertData['holders'];

        $query = "INSERT INTO $this->tableName ($columns) VALUES ($holders)";

        if ($returning) {
            $query .= " RETURNING $returning";
        }

        $result = $this->executeQuery($query, $data, $returning);

        return $returning ? $result[0][$returning] : $result;
    }

    /**`
     * @param array $data
     * @return array
     */
    private function prepareInsertData(array $data): array
    {
        $keys = array_keys($data);
        $insertData['columns'] = implode(', ', $keys);
        $insertData['holders'] = ':' . implode(', :', $keys);

        return $insertData;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insertIfNotExists(array $data, $whereData = []): bool
    {
        $value = reset($data);
        $column = key($data);

        $whereData = !empty($whereData) ? $whereData : [$column => $value];

        if (!$this->rowExists($whereData)) {
            return $this->insert($data);
        }
        return false;
    }

    /**
     * @param array $setData
     * @param array $whereData
     * @param string|null $operator
     * @return bool
     */
    public function update(array $setData, array $whereData, string $operator = null): bool
    {
        $setData = CaseTranslator::keysTo('snake', $setData);
        $setData = $this->prepareData($setData);
        $whereData = CaseTranslator::keysTo('snake', $whereData);
        $setString = $this->prepareSetData($setData);
        $whereString = $this->prepareWhereData($whereData, $operator);
        $query = "UPDATE $this->tableName SET ${setString} WHERE ${whereString}";

        return $this->executeQuery($query, array_merge($setData, $whereData), false);
    }

    /**
     * @param array $whereData
     * @param string|null $operator
     * @return bool
     */
    public function delete(array $whereData, string $operator = null): bool
    {
        $whereData = CaseTranslator::keysTo('snake', $whereData);
        $whereString = $this->prepareWhereData($whereData, $operator);
        $query = "DELETE FROM $this->tableName WHERE ${whereString}";

        return $this->executeQuery($query, array_merge($whereData), false);
    }

    /**
     * @param array $whereData
     * @param string|null $operator
     * @return int
     */
    public function count(array $whereData, string $operator = null): int
    {
        $whereData = CaseTranslator::keysTo('snake', $whereData);
        $whereString = $this->prepareWhereData($whereData, $operator);
        $query = "SELECT count(*) from $this->tableName WHERE ${whereString}";

        return $this->executeQuery($query, array_merge($whereData))[0]['count'];
    }

    /**
     * @param array $setData
     * @return string
     */
    private function prepareSetData(array $setData) {
        $shouldSeparate = count($setData) - 1;
        $setString = '';
        foreach ($setData as $column => $value) {
            $setString .= $column . ' = :' . $column;
            if ($shouldSeparate--) {
                $setString .= ', ';
            }
        }

        return $setString;
    }

    /**
     * @param array $data
     * @param string $operator
     * @return bool
     */
    public function rowExists(array $data, string $operator = null): bool
    {
        return (bool)$this->count($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareData(array $data): array
    {
        return array_map(function ($value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            return $value;
        }, $data);
    }

    /**
     * @param string $query
     * @param array|null $data
     * @param bool $fetch
     * @return array|bool
     */
    public function executeQuery(string $query, array $data = null, $fetch = true)
    {
        $stm = $this->pdo->prepare($query);
        $dbResult = $stm->execute($data);
        return $fetch ? $stm->fetchAll() : $dbResult;
    }

}
