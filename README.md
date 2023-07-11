#### 通过Sql语句生成markdown文档的php程序

##### 安装

> composer require peng49/db2markdown

##### 命令行使用
> php vendor/bin/db2markdown

输入数据库的 地址(host), 端口(port) 用户名,密码,要导出的表,默认是*,生成所有表的文档,指定多个表明用逗号隔开,如: table1,table2

```shell
$ php vendor/bin/db2markdown
please enter the host(localhost): localhost
please enter the port(3306): 3306
please enter username(root): root
please enter password: Admin@123
please enter database: acg
please enter tables(default is *,match all table): 
show full columns from admin_menu

show full columns from admin_operation_log

show full columns from admin_permissions

show full columns from admin_role_menu

...

E:\develop\library\db2markdown20230711031625.md is export success
```

##### 代码中使用

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
