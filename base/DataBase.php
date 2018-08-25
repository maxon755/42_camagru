<?php

namespace app\base;


class DataBase extends Application
{
    private $pdo;
    private $tableName;

    private static $dbInstance;

    private function __construct()
    {
        $this->getConnection();
    }

    public static function getInstance($tableName)
    {
        if (!self::$dbInstance)
            self::$dbInstance = new self();

        self::$dbInstance->setTableName($tableName);
        return self::$dbInstance;
    }

    private function getConnection()
    {
        $params = self::$config['db'];

        $host       = $params['host'];
        $dbname     = $params['dbname'];
        $user       = $params['user'];
        $password   = $params['password'];
        $charset    = $params['charset'];

        $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
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

    public function insert($data)
    {
        $insertData = $this->prepareInsertData($data);
        $columns    = $insertData['columns'];
        $holders    = $insertData['holders'];
        $values     = $insertData['values'];

        $query = "INSERT INTO $this->tableName ($columns) VALUES ($holders);";
        $stm = $this->pdo->prepare($query);
        $res = $stm->execute($values);

        return $res;
    }

    private function prepareInsertData($data)
    {
        $keys = $this->arrayCamelToSnake(array_keys($data));
        $insertData['columns'] = implode(', ', $keys);
        $insertData['holders'] = str_repeat('?, ', count($data) - 1) . '?';
        $insertData['values']  = array_values($data);

        return $insertData;
    }
}
