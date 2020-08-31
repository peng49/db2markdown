#### 通过Sql语句生成markdown文档的php程序

##### 安装

> composer require peng49/db2markdown


##### 使用

```php
<?php
require_once "vendor/autoload.php";

/* @var $generator \DB2Markdown\Generator\Mysql */
$generator = \DB2Markdown\Factory::getGenerator('mysql');

//mysql
$generator->setHost('localhost')
    ->setPort(3306)
    ->setDatabase('database')
    ->setUsername('username')
    ->setPassword('password')
    ->output("filename", "*");


```
