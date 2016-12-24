<?php

/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 21/12/2016
 * Time: 4:48 PM
 */

namespace summic\fond\controllers;

use yii;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ]
        ];
    }

    /**
     * This function will be triggered when user is successfully authenticated using oAuth client.
     *
     * @param \yii\authclient\ClientInterface $client
     * @return boolean | \yii\web\Response
     */
    public function successCallback($client)
    {
        $profile = $client->getUserAttributes();

        $identityClass = \Yii::$app->user->identityClass;
        $tableMap = Yii::$app->getModule('fond')->tableMap;

        $user = $identityClass::find()->where([
            $tableMap['email_field'] => $profile['email']
        ])->one();

        if ($user) { // 登录
            // 更新用户资料
            $user->setAttribute($tableMap['fullname_field'], $profile['fullname']);
            $user->setAttribute($tableMap['avatar_field'], $profile['avatar']);
            $user->setAttribute($tableMap['position_field'], $profile['position']);
            $user->save();

            Yii::$app->user->login($user);
            Yii::$app->getSession()->setFlash('success', '登录成功');
            $this->goBack();
        } else { // 注册新用户
            if ($profile['email'] !== null) {
                $user = new $identityClass([
                    $tableMap['username_field'] => $profile['username'],
                    $tableMap['email_field'] => $profile['email'],
                    $tableMap['password_hash_field'] => md5($profile['email'] . rand() . time()), // TODO: FIXME
                    $tableMap['fullname_field'] = $profile['fullname'],
                    $tableMap['avatar_field'] = $profile['avatar'],
                    $tableMap['position_field'] = $profile['position']
                ]);
                if ($user->save()) {
                    Yii::$app->getSession()->setFlash('success', '帐号创建完成, 您需要向系统管理员申请权限后才能使用相应功能');
                    Yii::$app->user->login($user);
                    $this->goBack();
                } else {
                    Yii::$app->getSession()->setFlash('error', '帐号创建失败: ' . json_encode($user->getErrors()));
                }
            } else {
                Yii::$app->getSession()->setFlash('error', '注册失败: ' . json_encode($user->getErrors()));
            }
        }
    }
}