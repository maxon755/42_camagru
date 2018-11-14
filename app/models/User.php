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
        return $this->db->insertIfNotExists(array_filter([
            'username'          => $data['username'],
            'email'             => $data['email'],
            'password'          => $data['password']
                ? $this->encryptPassword($data['password'])
                : null,
            'first-name'        => $data['first-name'],
            'last-name'         => $data['last-name'],
            'activation-code'   => uniqid(rand(0,999))
        ]));
    }

    public function getActivationCode($email): string
    {
        $data = $this->db->selectAllWhere(['email' => $email]);
        return $data[0]['activation_code'];
    }
}
