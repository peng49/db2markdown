<?php

use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase {

    public function testMysql() {

        $this->assertTrue(true);
    }

    public function testPostgreSQL() {
        $generator = \DB2Markdown\Factory::getGenerator('postgresql');
        // $generator
        $generator->setHost('localhost')
            ->setPort(5432)
            ->setDatabase('gocron')
            ->setUsername('odoo')
            ->setPassword('odoo')
            ->output("db2markdown" . date('YmdHis'));

        $this->assertTrue(true);
    }
}
