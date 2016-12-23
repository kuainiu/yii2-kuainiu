# yii2-fond-authclient
[![Latest Stable Version](https://poser.pugx.org/summic/yii2-fond-authclient/v/stable)](https://packagist.org/packages/summic/yii2-fond-authclient)
[![Latest Unstable Version](https://poser.pugx.org/summic/yii2-fond-authclient/v/unstable)](https://packagist.org/packages/summic/yii2-fond-authclient)
[![Total Downloads](https://poser.pugx.org/summic/yii2-fond-authclient/downloads)](https://packagist.org/packages/summic/yii2-fond-authclient)
[![License](https://poser.pugx.org/summic/yii2-fond-authclient/license)](https://packagist.org/packages/summic/yii2-fond-authclient)

This extension adds Fond.io OAuth2 supporting for [yii2-authclient](https://github.com/yiisoft/yii2-authclient).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require summic/yii2-fond-authclient
```

or add


```
"summic/yii2-fond-authclient": "*"
```

to the require section of your composer.json file.

## Usage

Register your application [in Fond.io](https://www.fond.io/developer/clients/register)

Once the extension is installed, modify your application configuration to include:

```php

return [
    'modules' => [
        ...
        'oauth' => [
            'class' => 'summic\authclient\Module',
        ],
        ...
    ],
    ...
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
    ]
];
 ```

And run migrations:

```shell
php yii migrate --migrationPath=@vendor/summic/yii2-fond-authclient/migrations
```

Add a oauth login button on your login view pages

```html
<div class="social-auth-links text-center">
    <p class="text-light-blue">- 或 -</p>
    <a href="/oauth/auth?authclient=fond" class="btn btn-social btn-facebook btn-flat">
      <i class="fa fa-facebook"></i>使用企业通行证登录
    </a>
</div>
```

Or just change the loginAction of SiteController as this:

```php
 public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->redirect(['oauth','authclient'=>fond]);
    }
```