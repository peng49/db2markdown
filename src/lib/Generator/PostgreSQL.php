<?php
/**
 * Description of this file
 *
 * @author  peng49 <1219955253@qq.com>
 * @date    2020/8/28 17:02
 */

namespace DB2Markdown\Generator;

use PDO;

/**
 * Class PostgreSQL
 * @package DB2Markdown\Generator
 */
class PostgreSQL extends Base {

    protected $schema = 'public';
    protected $port = 5432;

    public function setTableSchema($schema) {
        $this->schema = $schema;
        return $this;
    }

    protected function connection() {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database};";
        $this->pdo = new PDO($dsn, $this->username, $this->password);
    }

    /**
     * 获取所有的表名
     *
     * @return array
     * @date    2023/7/12 16:02
     */
    protected function getTables() {
        $sql = "SELECT * FROM pg_catalog.pg_tables where schemaname = '{$this->schema}';";

        $statement = $this->pdo->query($sql, PDO::FETCH_ASSOC);

        $items = $statement->fetchAll();

        return array_column($items, 'tablename');
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
        $sql = <<<SQL
SELECT
    column_name "Field",
    udt_name "Type",
    column_default "Default",
    is_nullable "Null",
    Null "Comment",
    Null "Key"
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '{$table}' ORDER BY ordinal_position;
SQL;

        $statement = $this->pdo->query($sql, PDO::FETCH_ASSOC);

        if (!$statement) {
            throw new \Exception('Exception G');
        }

        return $statement->fetchAll();
    }
}
