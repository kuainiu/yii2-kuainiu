<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 21/12/2016
 * Time: 3:23 PM
 */

namespace fond;

class Module extends \yii\base\Module
{
    public $tableMap = [
        'user_table'            =>  '{{%user}}',
        'username_field'        =>  'username',
        'email_field'           =>  'email',
        'password_hash_field'   =>  'password_hash',
        'fullname_field'        =>  'fullname',
        'avatar_field'          =>  'avatar',
        'position_field'        =>  'position',
    ];

    public function init()
    {
        parent::init();
    }
}