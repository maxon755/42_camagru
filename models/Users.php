<?php

namespace app\models;

use app\base\Model;

class Users extends Model
{

    public static function getClassName()
    {
        return __CLASS__;
    }

    public function checkAvailability($column, $value)
    {
        return  $count = $this->db->countWhere($column, $value);
    }

}
