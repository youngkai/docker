<?php
/*================================================================
*  File Name：BaseClientType.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 16:50:22
*  Description：
===============================================================*/
class BaseClientTypeModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `base_client_type` (`company_id`,`data_type`,`type_num`,`type_name`,`is_default`,`order_num`) VALUES (?, ?, ?, ?, ?, ?);';
        return DB::getInstance($database)->insert('ssssss', $sql, $params) ? : [];
    }


}
