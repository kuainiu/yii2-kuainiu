<?php

/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 21/12/2016
 * Time: 4:48 PM
 */

namespace summic\authclient\controllers;

use yii;
use yii\web\Controller;
use summic\authclient\models\Auth;

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
                'successCallback' => [$this, 'oAuthSuccess'],
            ]
        ];
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        echo 'OK.';
    }


    public function actionT(){
        return $this->oAuthSuccess();

    }

    /**
     * This function will be triggered when user is successfully authenticated using some oAuth client.
     *
     * @param \yii\authclient\ClientInterface $client
     * @return boolean | \yii\web\Response
     */
    public function oAuthSuccess($client = null) {
        //$profile = $client->getUserAttributes();

        $profile = [
            'id' => 1,
            'username' => 'Allen',
            'email' => 'allen@qianshengqian.com',
            'position' => '联合创始人',
            'avatar' => 'https://p.qlogo.cn/bizmail/XO4fcBHQheHqq0fmyaNXtsT86XyG6gILxqQDctClI43SIrictM0nQAg/0',
            'superadmin' => 1
        ];


        $identityClass = \Yii::$app->user->identityClass;
        $userFieldMap = Yii::$app->getModule('oauth')->userFieldMap;

        $user = $identityClass::find()->where([
            $userFieldMap['email'] => $profile['email']
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($user) { // login
                Yii::$app->user->login($user);
                $this->goBack();
            } else { // 注册新用户
                if ($profile['email'] !== null) {
                    $user = new $identityClass([
                        $userFieldMap['username'] => $profile['username'],
                        $userFieldMap['email'] => $profile['email'],
                        $userFieldMap['password_hash'] => md5($profile['email'].rand().time()), // TODO: FIXME
                    ]);
                    if ($user->save()) {
                        Yii::$app->getSession()->setFlash('success', 'Account Linked.');
                        Yii::$app->user->login($user);
                        $this->goBack();
                    } else {
                        Yii::$app->getSession()->setFlash('error', 'Unable to link WeWork account: '.json_encode($user->getErrors()));
                    }
                } else {
                        Yii::$app->getSession()->setFlash('error', 'Unable to save user: '.json_encode($user->getErrors()));
                }
            }
        } else { //已登录用户
            if (!$user) {
                $user = new $identityClass([
                    $userFieldMap['username'] => $profile['username'],
                    $userFieldMap['email'] => $profile['email'],
                    $userFieldMap['password_hash'] => md5($profile['email'].rand().time()), // TODO: FIXME
                ]);
                if ($user->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Linked Fond account.');
                    $this->goBack();
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Unable to link Fond account: ' . json_encode($user->getErrors()));
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', 'Unable to link Fond account. There is another user using it.');
            }
        }


    }


}