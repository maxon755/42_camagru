<?php
/**
 * Created by PhpStorm.
 * User: maks
 * Date: 11.08.18
 * Time: 14:42
 */

namespace app\models;

use \app\base\ActiveRecord;

class Users extends ActiveRecord
{
    public static function getClassName()
    {
        return __CLASS__;
    }

}
