#### 通过Sql语句生成markdown文档的php程序

##### 安装

> composer require peng49/db2markdown


##### 使用

```php
<?php
    require_once "vendor/autoload.php";
    
    $generate = new DB2Markdown\Generator('mysql:dbname=database;host=localhost;port=3306','username','password');
    
    $generate->output('filename', '*');

```
