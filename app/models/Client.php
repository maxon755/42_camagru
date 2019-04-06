<?php

namespace app\models;

use app\base\DataBaseModel;
use app\widgets\inputForm\AvailabilityChecker;
use app\widgets\inputForm\CredentialsChecker;

class Client extends DataBaseModel implements AvailabilityChecker, CredentialsChecker
{
    /**
     * @param array $where
     * @return bool
     */
    public function isInputAvailable(array $where): bool
    {
        $currentUserId = self::$auth->getUserId();
        $userId = $this->getValue('user_id', $where);

        return !isset($userId) || (isset($userId) && $userId === $currentUserId);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insertToDb(array $data): bool
    {
        return $this->db->insertIfNotExists([
            'username'          => $data['username'],
            'email'             => $data['email'],
            'password'          => $this->encryptPassword($data['password']),
            'first-name'        => $data['first-name'],
            'last-name'         => $data['last-name'],
            'activation-code'   => uniqid(rand(0,999))
        ]);
    }

    /**
     * @param string $email
     * @return string
     */
    public function getActivationCode(string $email): string
    {
        $data = $this->db->selectWhere(['email' => $email]);
        return $data[0]['activation_code'];
    }

    /**
     * @param string $activationCode
     * @return bool
     */
    public function activateAccount(string $activationCode): bool
    {
        return $this->db->update([
            'is_active'         => 'true',
            'activation_date'   => 'NOW()',
        ], [
            'activationCode' => $activationCode,
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function checkCredentials(array $data): bool
    {
        $row = $this->db->selectWhere([
            'username'  => $data['username'],
            'is_active' => true,
        ]);
        if (empty($row)) {
            return false;
        }
        return password_verify($data['password'], $row[0]['password']);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserData(int $userId): array
    {
        return $this->db->selectWhere([
            'user_id' => $userId,
        ])[0];
    }

    /**
     * @param int $userId
     * @param array $userInput
     * @return bool
     */
    public function updateGeneralUserData(int $userId, array $userInput): bool
    {
        return $this->db->update($userInput, [
            'user_id' => $userId,
        ]);
    }

    /**
     * @param int $userId
     * @param string $password
     * @return bool
     */
    public function updateUserPassword(int $userId, string $password): bool
    {
        return $this->db->update([
            'password' => $this->encryptPassword($password)
        ], [
            'user_id' => $userId,
        ]);
    }
}
