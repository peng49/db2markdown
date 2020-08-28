<?php
require_once 'src/Generator.php';

try{

    $generator = new DB2Markdown\Generator('mysql:dbname=database;host=localhost;port=3306','username','password');

    $generator->output("","*");
}catch (PDOException $e){
    echo $e->getMessage();
}
