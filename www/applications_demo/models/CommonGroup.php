<?php
/*================================================================
*  File Name：CommonGroup.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 19:18:31
*  Description：
===============================================================*/
class CommonGroupModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `common_group` (`company_id`, `group_name`, `create_date`, `is_administrator`) VALUES (?, ?, ?, ?);';
        $result = DB::getInstance($database)->insert('ssss', $sql, $params);
        return empty($result['insert_id']) ? $result['insert_id'] : null;
    }

}
