<?php

namespace app\base;

use app\components\CaseTranslator;

class DataBaseModel extends Application
{
    private $tableName;
    protected $db;

    public function __construct()
    {
        $this->tableName = $this->computeTableName();
        $this->db = DataBase::getInstance($this->tableName);
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return static::class;
    }

    /**
     * @return string
     */
    private function computeTableName(): string
    {
        $tableName = $this->getClassName();
        $re = '/(?<=\\\\)(?<className>\w+)$/';
        preg_match($re, $tableName, $matches);
        $tableName = $matches['className'];
        $tableName = CaseTranslator::toSnake($tableName);

        return $tableName;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function rowExists(array $data): bool
    {
        return  $this->db->rowExists($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function getRowWhere(array $data): array
    {
        $result = $this->db->selectAllWhere($data);

        return !empty($result) ? $result[0] : $result ;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getRowsWhere(array $data): array
    {
        return $this->db->selectAllWhere($data)[0];
    }

    /**
     * @param $columnName
     * @param $data
     * @return mixed
     */
    public function getValue($columnName, $data)
    {
        $result = $this->db->selectAllWhere($data);

        return !empty($result) ? $result[0][$columnName] : $result;
    }

    public function prepareWhereData($data, string $operator = null)
    {
        $shouldSeparate = count($data) - 1;
        $operator = $operator ?: 'AND';
        $res = '';
        foreach ($data as $key => $value) {
            $res .= $key . ' = '. $value;
            if ($shouldSeparate--) {
                $res .= ' ' . $operator . ' ';
            }
        }

        return $res;
    }
}
