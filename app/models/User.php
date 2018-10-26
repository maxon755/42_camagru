<?php

namespace app\models;

use app\base\Model;

class User extends Model
{

    public static function getClassName()
    {
        return __CLASS__;
    }

    public function checkAvailability(array $data): bool
    {
        return  $this->db->rowExists($data);
    }

}
