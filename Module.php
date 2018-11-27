<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 21/12/2016
 * Time: 3:23 PM
 */

namespace kuainiu;

class Module extends \yii\base\Module
{
    public $tableMap = [
        'user_table'            =>  '{{%user}}',
        'username_field'        =>  'name',
        'email_field'           =>  'email',
        'password_hash_field'   =>  'password_hash',
        'fullname_field'        =>  'chinese_name',
        'avatar_field'          =>  'avatar',
        'position_field'        =>  'position',
    ];

    public function init()
    {
        parent::init();
    }
}