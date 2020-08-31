<?php

namespace DB2Markdown\Generator;

use DB2Markdown\Generator;

/**
 * Class Mysql
 */
class Mysql implements Generator
{
    private $host;

    private $port;

    private $database;

    private $username;

    private $password;

    private $pdo;

    private $header = "| Field | Type | Default | Comment  | Null | Key | ".PHP_EOL.
    "|---|---|---|---|---|---|".PHP_EOL;

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
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
        $this->init();

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

    private function init()
    {
        $this->pdo = new \PDO("mysql:dbname={$this->database};host={$this->host};port={$this->port}",$this->username,$this->password);
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
