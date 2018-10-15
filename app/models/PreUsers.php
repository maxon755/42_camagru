<?php
/**
 * Created by PhpStorm.
 * User: maks
 * Date: 25.08.18
 * Time: 13:45
 */

namespace app\models;


use app\base\Model;
use app\components\Debug;

class PreUsers extends Model
{
    public static function getClassName()
    {
        return __CLASS__;
    }

    public function insert($userInput)
    {
        $userInput['password'] = $this->encryptPassword($userInput['password']);

        $userInput['vcode'] = $this->encryptValue($userInput['email']);

        Debug::debugArray($userInput, "", true);

        $this->sendVerificationEmail($userInput);

//        if ($this->db->insert($userInput))
//        {
//            $this->sendVerificationEmail($userInput);
//        }


    }

    private function sendVerificationEmail($userInput)
    {

        $to      = $userInput['email'];
        $subject = 'Account confirmation';
        $message = $_SERVER['SERVER_NAME'] . '/sign-up/confirm/'
                    . $userInput['vcode'] . "\r\n" . time();

        $headers =  'From: maksim.gayduk@gmail.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $message, $headers))
        {
            echo "works";
        }


    }
}
