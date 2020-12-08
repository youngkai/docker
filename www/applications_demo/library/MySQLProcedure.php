<?php
/*================================================================
*  File Name：MySQLProcedure.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-17 23:56:30
*  Description：
*  先兼容存储过程，后期必须把存储过程干掉。PHP生成安全随机数的能力
*  已经相当的可靠。
===============================================================*/
class MySQLProcedure
{

    /**
     * 调用存储过程
     * @param string $sql sql语句
     * @param string $fields 需要返回的数据字段
     * @param string $connection 数据库连接标识,默认走主库，可以不传。
     * @return mixed.
     */
    public function callProcedure($sql = '', $fields = '', $connection = 'master')
    {
        if ('' == $sql) {
            throw new Exception('入参无效', 400);
        }
        $result = DB::getInstance($connection)->query('CALL' . $sql);
        if (!empty($fields)) {
            $result['data'] = DB::getInstance($connection)->query('SELECT' . $fields); 
        }
        return $result;
    }

}

