<?php
/*================================================================
*  File Name：BaseStock.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 16:41:36
*  Description：
===============================================================*/
class BaseStockModel
{

    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `base_stock` (`company_id`, `stock_num`, `stock_name`, `is_default`) VALUES ( ?, ?, ?, ?);';
        return DB::getInstance($database)->insert('ssss', $sql, $params) ? : [];
    }

}
