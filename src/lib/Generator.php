<?php
/**
 * Description of this file
 *
 * @author  peng49 <1219955253@qq.com>
 * @date    2020/8/28 16:21
 */

namespace DB2Markdown;


interface Generator
{
    public function output($filename, $tables = '*');
}
