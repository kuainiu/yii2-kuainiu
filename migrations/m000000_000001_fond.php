<?php
use yii\db\Schema;

class m000000_000001_kuainiu extends \yii\db\Migration
{
    public function up()
    {
		Yii::$app->setModule('kuainiu', ['class' => 'kuainiu\Module']);
        $tableMap = Yii::$app->getModule('kuainiu')->tableMap;
        $this->addColumn($tableMap['user_table'], $tableMap['fullname_field'], Schema::TYPE_STRING . '(48) AFTER `'.$tableMap['email_field'].'` ');
        $this->addColumn($tableMap['user_table'], $tableMap['avatar_field'], Schema::TYPE_STRING . '(128) AFTER `'.$tableMap['fullname_field'].'` ');
        $this->addColumn($tableMap['user_table'], $tableMap['position_field'], Schema::TYPE_STRING . '(32) AFTER `'.$tableMap['avatar_field'].'` ');
    }

    public function down()
    {
		Yii::$app->setModule('kuainiu', ['class' => 'kuainiu\Module']);
        $tableMap = Yii::$app->getModule('kuainiu')->tableMap;
        $this->dropColumn($tableMap['user_table'], $tableMap['fullname_field']);
        $this->dropColumn($tableMap['user_table'], $tableMap['avatar_field']);
        $this->dropColumn($tableMap['user_table'], $tableMap['position_field']);
    }
}