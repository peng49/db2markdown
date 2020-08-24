<?php
require_once 'src/Generator.php';

try{

    $generator = new DocGenerator('mysql:dbname=db_spider;host=localhost;port=3306','username','password');

    $generator->output("","*");
}catch (PDOException $e){
    echo $e->getMessage();
}
