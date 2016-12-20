# yii2-fond-authclient

This extension adds Fond.io OAuth2 supporting for [yii2-authclient](https://github.com/yiisoft/yii2-authclient).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

add

```json
"repositories": [
		{
            "type": "package",
            "package": {
                "name": "allen/yii2-fond-authclient",
                "version": "0.1.0",
                "type": "package",
                "source": {
                    "url": "git@git.fond.io:allen/yii2-fond-authclient.git",
                    "type": "git",
                    "reference": "master"
                }
            }
        }
]
```
to the `require` section of your composer.json.


and run

```
composer require allen/yii2-fond-authclient.git "*"

composer require --prefer-dist yiisoft/yii2-authclient
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
                'class' => 'allen\authclient\Fond',
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
	