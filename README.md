# yii2-fond
[![Latest Stable Version](https://poser.pugx.org/summic/yii2-fond/v/stable)](https://packagist.org/packages/summic/yii2-fond)
[![Latest Unstable Version](https://poser.pugx.org/summic/yii2-fond/v/unstable)](https://packagist.org/packages/summic/yii2-fond)
[![Total Downloads](https://poser.pugx.org/summic/yii2-fond/downloads)](https://packagist.org/packages/summic/yii2-fond)
[![License](https://poser.pugx.org/summic/yii2-fond/license)](https://packagist.org/packages/summic/yii2-fond)

This extension adds Fond.io OAuth2 supporting for [yii2-authclient](https://github.com/yiisoft/yii2-authclient).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require summic/yii2-fond
```

or add


```
"summic/yii2-fond-authclient": "*"
```

to the require section of your composer.json file.

## Usage

在 [Fond.io](https://www.fond.io/developer/clients/register) 注册您的应用

之后,修改需要登录项目的配置文件(main.php 或 main-local.php)
```php
return [
    'components' => [
		'authClientCollection' => [
	        'class' => 'yii\authclient\Collection',
	        'clients' => [
	            'fond' => [
	                'class' => 'summic\fond\components\authclient\Fond',
	                'clientId' => 'fond_client_id',
	                'clientSecret' => 'fond_client_secret',
	            ],
	        ],
	    ],
	    ...
	]
];
 ```
module 的配置需要放在 common 项目的配置文件(main.php 或 main-local.php 因为数据迁移需要执行console)
```php
'modules' => [
    'fond' => [
        'class' => 'summic\fond\Module',
    ],
    ...
],
```


执行数据迁移:

```shell
php yii migrate --migrationPath=@vendor/summic/yii2-fond/migrations
```

在登录页面增加 『使用企业通行证登录』 链接

```html
<div class="social-auth-links text-center">
    <p class="text-light-blue">- 或 -</p>
    <a href="/fond/user/auth?authclient=fond" class="btn btn-block btn-social btn-dropbox">
        <i class="fa fa-ticket"></i>使用企业通行证登录
    </a>
</div>
```

如果全站只允许员工访问，不需要登录页面，直接修改 SiteController 的 actionLogin 方法:

```php
public function actionLogin()
{
	if (!Yii::$app->user->isGuest) {
    	return $this->goHome();
	}
    $this->redirect(['oauth','authclient'=>fond]);
}
```

## 使用用户信息
在 view 文件中直接使用, 注意: 用户未登录界面调用会抛异常
```html
//头像
<?=Yii::$app->user->identity->avatar?>
//帐号
<?=Yii::$app->user->identity->username?>
//中文名
<?=Yii::$app->user->identity->fullname?>
//职位
<?=Yii::$app->user->identity->position?>
```

## 获取组织架构
```php
$collection = Yii::$app->get('authClientCollection');
$client = $collection->getClient('fond');
$response = $client->api('department/list', 'GET', $params);
```

## One more thing...

如果你的项目使用了 AdinLTE, GOOGLE 字体被墙还是比较恶心的，在 composer.json 增加以下内容可解决：

```json
"scripts": {
    "post-install-cmd": [
        "summic\\fond\\components\\AdminLTEInstaller::initProject"
    ],
    "post-update-cmd": [
        "summic\\fond\\components\\AdminLTEInstaller::initProject"
    ]
}
```