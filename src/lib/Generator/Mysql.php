<?php

namespace DB2Markdown\Generator;

use PDO;

/**
 * Class Mysql
 */
class Mysql extends Base {

    protected function connection() {
        $dsn = "mysql:dbname={$this->database};host={$this->host};port={$this->port}";
//        echo $dsn;
        $this->pdo = new PDO($dsn, $this->username, $this->password);
    }

    /**
     * 获取所有的表名
     *
     * @return array
     * @date    2020/8/28 16:36
     */
    protected function getTables() {
        $sql = "show tables";

        $statement = $this->pdo->query($sql, PDO::FETCH_ASSOC);

        $items = $statement->fetchAll();

        return array_map(
            function ($item) {
                return current($item);
            },
            $items
        );
    }

    /**
     * 获取表的注释
     *
     * @param $table
     *
     * @return string
     * @date    2020/8/28 16:36
     */
    protected function getTableComment($table) {
        $stat = $this->pdo->query("show create table {$table};");
        $rows = $stat->fetchAll(PDO::FETCH_ASSOC);

        preg_match("/\).*COMMENT='(.*?)'/", $rows[0]['Create Table'], $match);

        return (isset($match[1]) ? $match[1] : $table) . PHP_EOL . PHP_EOL;
    }

    /**
     * 获取指定表的所有字段
     *
     * @param $table
     *
     * @return array
     * @throws \Exception
     * @date    2020/8/28 16:35
     */
    protected function getTableFields($table) {
        $sql = "show full columns from {$table}";

        $statement = $this->pdo->query($sql, PDO::FETCH_ASSOC);

        if (!$statement) {
            throw new \Exception('Exception G');
        }

        return $statement->fetchAll();
    }
}
