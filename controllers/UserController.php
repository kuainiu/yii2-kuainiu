<?php

/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 21/12/2016
 * Time: 4:48 PM
 */

namespace summic\authclient\controllers;

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




}