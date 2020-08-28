<?php
/**
 * Description of this file
 *
 * @author  彭杨杨 <yypeng@sfcservice.com>
 * @date    2020/8/28 16:21
 */

namespace DB2Markdown;


interface Connection
{
    public function output($filename, $tables = '*');
}
