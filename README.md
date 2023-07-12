#### 通过Sql语句生成markdown文档的php程序

##### 安装

> composer require peng49/db2markdown

##### 命令行使用
> php vendor/bin/db2markdown

输入数据库的 地址(host), 端口(port) 用户名,密码,要导出的表,默认是*,生成所有表的文档,指定多个表明用逗号隔开,如: table1,table2

```shell
$ php src/bin/db2markdown
please enter the db(1 mysql,2 postgresql):
please enter the host(localhost):
please enter the port(3306): 3310
please enter username(root):
please enter password: password
please enter database: acg
please enter tables(default is *,match all table):

admin_menu successful

admin_operation_log successful

admin_permissions successful

....

E:\develop\db2markdown\db2markdown20230712091813.md is export success
```

导出PostgreSQL结构
```shell
$ php src/bin/db2markdown
please enter the db(1 mysql,2 postgresql): 3
please enter the db(1 mysql,2 postgresql): 2
please enter the host(localhost):
please enter the port(5432): 5432
please enter username(root): odoo
please enter password: password
please enter database: gocron
please enter table schema(public):
please enter tables(default is *,match all table):

task successful

task_log successful

host successful

......

E:\develop\db2markdown\db2markdown20230712092030.md is export success
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
