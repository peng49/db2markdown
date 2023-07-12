<?php

namespace DB2Markdown\Generator;

use DB2Markdown\Generator;
use PDO;

abstract class Base implements Generator {

    protected $host;

    protected $port;

    protected $database;

    protected $username;

    protected $password;

    protected $pdo;

    protected $header = "| Field | Type | Default | Comment  | Null | Key | " . PHP_EOL .
    "|---|---|---|---|---|---|" . PHP_EOL;

    public function setHost($host) {
        $this->host = $host;

        return $this;
    }

    public function setPort($port) {
        $this->port = $port;

        return $this;
    }

    public function setDatabase($database) {
        $this->database = $database;

        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    abstract protected function connection();
    abstract protected function getTables();

    /**
     * 获取表的注释
     *
     * @param $table
     *
     * @return string
     * @date    2020/8/28 16:36
     */
    protected function getTableComment($table) {
        return "" . PHP_EOL . PHP_EOL;
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
    public function output($filename, $importTables = "*") {
        $this->connection();

        $tables = $this->getTables();
        $preStr = "";
        foreach ($tables as $table) {
            if ($importTables != "*" && !in_array($table, explode(",", $importTables))) {
                continue;
            }

            try {
                $tableStr = "### {$table} " . PHP_EOL . PHP_EOL;;
                $tableStr .= $this->getTableComment($table);

                $fields = $this->getTableFields($table);

                $tableStr .= $this->header;
                foreach ($fields as $field) {
                    $format = "|%s|%s|%s|%s|%s|%s|" . PHP_EOL;
                    $row = sprintf(
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

                echo PHP_EOL . "{$table} successful" . PHP_EOL;

            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        file_put_contents("./{$filename}.md", $preStr);

        echo realpath("./{$filename}.md"), " is export success";
    }




}
