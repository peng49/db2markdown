<?php
require_once "vendor/autoload.php";

/* @var $generator \DB2Markdown\Generator\Mysql */
$generator = \DB2Markdown\Factory::getGenerator('mysql');

// $generator
$generator->setHost('localhost')
    ->setPort(3306)
    ->setDatabase('database')
    ->setUsername('username')
    ->setPassword('password')
    ->output("filename", "*");
