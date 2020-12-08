<?php
/*================================================================
*  File Name：BaseMulti.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 04:07:06
*  Description：
===============================================================*/
class BaseMultiModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `base_multi` (`company_id`, `multi_num`, `multi_name`) VALUES (?, ?, ?);';
        $result = DB::getInstance($database)->insert('sss', $sql, $params);
        return empty($result['insert_id']) ? $result['insert_id'] : null;
    }


}


