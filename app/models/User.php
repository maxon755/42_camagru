<?php

namespace app\models;

use app\base\Model;
use app\components\inputForm\AvailabilityChecker;

class User extends Model implements AvailabilityChecker
{

    public static function getClassName()
    {
        return __CLASS__;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isInputAvailable(array $data): bool
    {
        return  !$this->db->rowExists($data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insertToDb(array $data): bool
    {
        return $this->db->insertIfNotExists([
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password'      => $this->encryptPassword($data['password']),
            'first-name'    => $data['first-name'],
            'last-name'     => $data['last-name']
        ]);
    }

}
