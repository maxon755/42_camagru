<?php

namespace app\base;

use app\components\CaseTranslator;

class Model extends Application
{
    private $tableName;
    protected $db;

    public function __construct()
    {
        $this->tableName = $this->computeTableName();
        $this->db = DataBase::getInstance($this->tableName);
    }

    public static function getClassName()
    {
        return __CLASS__;
    }

    private function computeTableName()
    {
        $tableName = static::getClassName();
        $re = '/(?<=\\\\)(?<className>\w+)$/';
        preg_match($re, $tableName, $matches);
        $tableName = $matches['className'];
        $tableName = CaseTranslator::toCap($tableName);

        return $tableName;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function encryptValue($value)
    {
        return md5($value);
    }
}
