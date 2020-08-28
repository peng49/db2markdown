<?php

namespace DB2Markdown\Db;

use DB2Markdown\Connection;

/**
 * Class Mysql
 */
class Mysql implements Connection
{
    private $pdo;

    private $header = "| Field | Type | Default | Comment  | Null | Key | ".PHP_EOL.
    "|---|---|---|---|---|---|".PHP_EOL;

    public function __construct($dsn, $username, $password)
    {
        $this->pdo = new \PDO($dsn, $username, $password);
    }

    /**
     *
     *
     * @param        $filename
     * @param string $importTables
     *
     * @author  peng49 <1219955253@qq.com>
     * @date    2020/8/28 15:05
     */
    public function output($filename, $importTables = "*")
    {
        $tables = $this->getTables();
        $preStr = "";
        foreach ($tables as $table) {
            if ($importTables != "*" && !in_array($table, explode(",", $importTables))) {
                continue;
            }

            try {
                $tableStr = "### {$table} ".PHP_EOL.PHP_EOL;;
                $tableStr .= $this->getTableComment($table);

                $fields = $this->getTableFields($table);

                $tableStr .= $this->header;
                foreach ($fields as $field) {
                    $format   = "|%s|%s|%s|%s|%s|%s|".PHP_EOL;
                    $row      = sprintf(
                        $format,
                        $field['Field'],
                        $field['Type'],
                        $field['Default'] ? $field['Default'] : '-',
                        $field['Comment'] ? $field['Comment'] : '-',
                        $field['Null'],
                        $field['Key'] ? $field['Key'] : '-'
                    );
                    $tableStr .= $row;
                }
                $preStr .= $tableStr;
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        file_put_contents("./{$filename}.md", $preStr);
    }

    /**
     * 获取所有的表名
     *
     * @return array
     * @date    2020/8/28 16:36
     */
    protected function getTables()
    {
        $sql = "show tables";

        $statement = $this->pdo->query($sql, \PDO::FETCH_ASSOC);

        $items = $statement->fetchAll();

        $tables = array_map(
            function ($item) {
                return current($item);
            },
            $items
        );

        return $tables;
    }

    /**
     * 获取表的注释
     *
     * @param $table
     *
     * @return string
     * @date    2020/8/28 16:36
     */
    protected function getTableComment($table)
    {
        return $table.' desc'.PHP_EOL.PHP_EOL;
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
    protected function getTableFields($table)
    {
        $sql = "show full columns from {$table}";

        echo $sql.PHP_EOL.PHP_EOL;

        $statement = $this->pdo->query($sql, \PDO::FETCH_ASSOC);

        if (!$statement) {
            throw new \Exception('Exception G');
        }

        return $statement->fetchAll();
    }
}
