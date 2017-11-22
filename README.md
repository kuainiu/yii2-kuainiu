# yii2-kuainiu
[![Latest Stable Version](https://poser.pugx.org/kuainiu/yii2-kuainiu/v/stable)](https://packagist.org/packages/kuainiu/yii2-kuainiu)
[![Latest Unstable Version](https://poser.pugx.org/kuainiu/yii2-kuainiu/v/unstable)](https://packagist.org/packages/kuainiu/yii2-kuainiu)
[![Total Downloads](https://poser.pugx.org/kuainiu/yii2-kuainiu/downloads)](https://packagist.org/packages/kuainiu/yii2-kuainiu)
[![License](https://poser.pugx.org/kuainiu/yii2-kuainiu/license)](https://packagist.org/packages/kuainiu/yii2-kuainiu)

This extension adds kuainiu.io OAuth2 supporting for [yii2-authclient](https://github.com/yiisoft/yii2-authclient).

## 安装

yii2-kuainiu 需要使用 [composer](http://getcomposer.org/download/) 安装.
*建议使用 composer 国内源 composer config repo.packagist composer https://packagist.phpcomposer.com*

在项目根目录运行

```
composer require summic/yii2-kuainiu
```

或者手动添加到 composer.json

```
"kuainiu/yii2-kuainiu": "*"
```
之后
```
composer install -vvv
```

## 配置

首先需要在 内部通行证系统 注册您的应用

然后修改*需使用统一登录项目的*配置文件(main.php 或 main-local.php)

```php
//按需配置
'modules' => [
    'kuainiu' => [
        'class' => 'kuainiu\Module',
    ],
    ...
],
```
authClient 的配置需要放在 common 项目的配置文件(main.php 或 main-local.php )

```php
//全局配置
return [
    'components' => [
		'authClientCollection' => [
	        'class' => 'yii\authclient\Collection',
	        'clients' => [
	            'kuainiu' => [
	                'class' => 'kuainiu\components\authclient\Kuainiu',
	                'clientId' => 'kuainiu_client_id',
	                'clientSecret' => 'kuainiu_client_secret',
	            ],
	        ],
	    ],
	    ...
	]
];
 ```


执行数据迁移:

```shell
yii migrate --migrationPath=@vendor/kuainiu/yii2-kuainiu/migrations
```
*以上脚本在 user 表增加了 avatar fullname position 三个字段用来存储头像、中文名和职位，字段名冲突或有错误的话,可以在 modules 中配置,例如:*
```php
'modules' => [
    'kuainiu' => [
        'class' => 'kuainiu\Module',
        'tableMap' => [ // Optional, but if defined, all must be declared
            'user_table'            =>  '{{%user}}',
            'username_field'        =>  'name',
            'email_field'           =>  'email',
            'password_hash_field'   =>  'password_hash',
            'fullname_field'        =>  'chinese_name',
            'avatar_field'          =>  'avatar',
            'position_field'        =>  'position',
        ],
    ],
    ...
],
```

## 使用

### OAuth 登录

在登录页面增加 『使用企业通行证登录』 链接

```html
<div class="social-auth-links text-center">
    <p class="text-light-blue">- 或 -</p>
    <a href="/kuainiu/user/auth?authclient=kuainiu" class="btn btn-block btn-social btn-dropbox">
        <i class="fa fa-ticket"></i>使用企业通行证登录
    </a>
</div>
```
或

如果全站只允许员工访问，不需要登录页面，直接修改 SiteController 的 actionLogin 方法:

```php
public function actionLogin()
{
	if (!Yii::$app->user->isGuest) {
    	return $this->goHome();
	}
    $this->redirect(['kuainiu/user/auth','authclient'=>'kuainiu']);
}
```

用户完成登录之后，用户资料的使用无任何变化，在 view 文件中直接使用, 注意: 用户未登录界面调用会抛异常
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

### API 获取组织架构信息
```php
use kuainiu\components\KuainiuClient;
...
$client = new KuainiuClient();
$response = $client->DepartmentList(82);
```

### API 获取组织架构下的用户信息
```php
use kuainiu\components\KuainiuClient;
...
$client = new FondClient();
$response = $client->DepartmentUser(82);
```

### API 发送企业微信消息
```php
use kuainiu\components\KuainiuClient;
...
$client = new FondClient();
$response = $client->Notification('Allen', 'Hello World');
```

## One more thing...

如果你的项目使用了 AdminLTE, 其使用的 GOOGLE 字体不可描述原因会导致页面打开慢，在 composer.json 增加以下内容可解决：

```json
"scripts": {
    "post-install-cmd": [
        "kuainiu\\components\\AdminLTEInstaller::initProject"
    ],
    "post-update-cmd": [
        "kuainiu\\components\\AdminLTEInstaller::initProject"
    ]
}
```
