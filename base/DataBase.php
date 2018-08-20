<?php

namespace app\base;


class DataBase extends Application
{
    private $pdo;

    private $tableName;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;

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

    public function selectAll()
    {
        $query = "SELECT * FROM $this->tableName";
        $stm = $this->pdo->prepare($query);
        $stm->execute();
        $dbData = $stm->fetchAll();
        return $dbData;
    }


    public function selectAllWhere($colunmName, $value)
    {
        $query = "SELECT * FROM $this->tableName WHERE $colunmName = ?";
        $stm = $this->pdo->prepare($query);
        $stm->execute(array($value));
        $dbData = $stm->fetchAll();
        return $dbData;
    }
}
