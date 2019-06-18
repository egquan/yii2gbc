<p align="center">
    <a href="https://github.com/egquan/yii2gbc" target="_blank">
        <img src="" height="100px">
    </a>
    <h1 align="center">Yii 2 Gbc 音乐管理系统</h1>
    <br>
</p>

使用 [Yii 2](http://www.yiiframework.com/) 开发，本项目是业余时间写的，不定期更新，目前已完成前后台用户管理、后台权限管理、角色授权管理等功能。

安装教程
1.使用git clone 命令克隆项目
2.导入最新更新的SQL文件
3.更改config/db.php 数据库配置文件
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```
[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      modules/            contains  modules
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



开发环境
------------
PHP 版本 7.3.4 Mysql版本8.0 apache2.4

截图
------------
登录页面
![登陆页](https://github.com/egquan/yii2gbc/blob/master/README/1.PNG)

密码错误三次自动开启验证码
![错误三次开启验证码](https://github.com/egquan/yii2gbc/blob/master/README/2.PNG)
