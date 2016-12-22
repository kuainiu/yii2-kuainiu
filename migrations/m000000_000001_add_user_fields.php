<?php
use yii\db\Schema;

class m000000_000001_add_user_fields extends \yii\db\Migration
{
    private $userFieldMap;

    public function up()
    {
        $userFieldMap = Yii::$app->getModule('oauth')->userFieldMap;

        $this->addColumn('User', $userFieldMap['fullname'], Schema::TYPE_STRING . '(48)');
        $this->addColumn('User',$userFieldMap['avatar'], Schema::TYPE_STRING . '(128)');
        $this->addColumn('User',$userFieldMap['position'], Schema::TYPE_STRING . '(32)');
    }

    public function down()
    {
        $userFieldMap = Yii::$app->getModule('oauth')->userFieldMap;
        $this->dropColumn('User',$userFieldMap['fullname']);
        $this->dropColumn('User',$userFieldMap['avatar']);
        $this->dropColumn('User',$userFieldMap['position']);
    }
}