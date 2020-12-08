<?php
/*================================================================
*  File Name：BaseBank.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 18:50:03
*  Description：
===============================================================*/
class BaseBankModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `base_bank` (`company_id`, `status`, `account_name`, `is_default`) VALUES (?, ?, ?, ?);';
        $result = DB::getInstance($database)->insert('ssss', $sql, $params);
        return empty($result['insert_id']) ? $result['insert_id'] : null;
    }

}
