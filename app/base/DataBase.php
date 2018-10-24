<?php

namespace app\base;


class DataBase extends Application
{
    private $pdo;
    private $tableName;

    private static $dbInstance;

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

        self::$dbInstance->setTableName($tableName);
        return self::$dbInstance;
    }

    private function getConnection(array $config=null): void
    {
        $config = $config ? $config : self::$config['db'];

        $driver     = $config['driver'];
        $host       = $config['host'];
        $dbname     = $config['dbname'];
        $user       = $config['user'];
        $password   = $config['password'];

        $dsn = "{$driver}:host={$host};dbname={$dbname};user={$user};password={$password}";
        echo $dsn . PHP_EOL;
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new \PDO($dsn, $user, $password, $options);
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function selectAll()
    {
        $query = "SELECT * FROM $this->tableName;";
        $stm = $this->pdo->prepare($query);
        $stm->execute();
        $dbData = $stm->fetchAll();
        return $dbData;
    }

    public function selectAllWhere($colunmName, $value)
    {
        $query = "SELECT * FROM $this->tableName WHERE $colunmName = ?;";
        $stm = $this->pdo->prepare($query);
        $stm->execute(array($value));
        $dbData = $stm->fetchAll();
        return $dbData;
    }

    public function countWhere($colunmName, $value)
    {
        return !count($this->selectAllWhere($colunmName, $value));
    }

    public function insert($data)
    {
        $insertData = $this->prepareInsertData($data);
        $columns    = $insertData['columns'];
        $holders    = $insertData['holders'];
        $values     = $insertData['values'];

        $query = "INSERT INTO $this->tableName ($columns) VALUES ($holders);";
        $stm = $this->pdo->prepare($query);

        return $stm->execute($values);
    }

    private function prepareInsertData($data)
    {
        $keys = $this->arrayCamelToSnake(array_keys($data));
        $insertData['columns'] = implode(', ', $keys);
        $insertData['holders'] = str_repeat('?, ', count($data) - 1) . '?';
        $insertData['values']  = array_values($data);

        return $insertData;
    }

    public function executeQuery(string $query): array
    {
        $stm = $this->pdo->prepare($query);
        print_r($stm);
        $stm->execute();
        $dbData = $stm->fetchAll();
        return $dbData;
    }

}
