# yii2-fond-authclient

[![Latest Stable Version](https://poser.pugx.org/summic/yii2-fond-authclient/v/stable)](https://packagist.org/packages/summic/yii2-fond-authclient)
[![Latest Unstable Version](https://poser.pugx.org/summic/yii2-fond-authclient/v/unstable)](https://packagist.org/packages/summic/yii2-fond-authclient)
[![Total Downloads](https://poser.pugx.org/summic/yii2-fond-authclient/downloads)](https://packagist.org/packages/summic/yii2-fond-authclient)
[![License](https://poser.pugx.org/summic/yii2-fond-authclient/license)](https://packagist.org/packages/summic/yii2-fond-authclient)

This extension adds Fond.io OAuth2 supporting for [yii2-authclient](https://github.com/yiisoft/yii2-authclient).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

run

```
composer require summic/yii2-fond-authclient
```


## Usage

You must read the yii2-authclient [docs](https://github.com/yiisoft/yii2/blob/master/docs/guide/security-auth-clients.md)

Register your application [in Fond.io](https://www.fond.io/developer/clients/register)

and add the Fond client to your auth clients.

```php
'components' => [
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'fond' => [
                'class' => 'summic\authclient\Fond',
                    'clientId' => 'fond_client_id',
                    'clientSecret' => 'fond_client_secret',
                ],
            ],
            // other clients
        ],
    ],
    // ...
 ]
 ```

allow auth action in SiteCiontroller

```php
public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['auth','login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }
```

and actions

```php
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ]
        ];
    }
```

and add login method

```php
public function actionLogin()
{
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }else{
        $this->redirect(Url::to(["site/auth",'authclient' => 'fond']));
    }
}
public function oAuthSuccess($client) {

}
```
	
