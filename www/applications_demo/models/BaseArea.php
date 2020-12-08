<?php
/*================================================================
*  File Name：BaseArea.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 20:58:06
*  Description：
===============================================================*/
class BaseAreaModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `base_area` (`company_id`,`parent_id`,`area_pnum`,`is_default`,`area_num`,`area_name`,`pinyin`) VALUES (?,?,?, ?, ?, ?, ?);';
        $result = DB::getInstance($database)->insert('sssssss', $sql, $params);
        return !empty($result['insert_id']) ? $result['insert_id'] : null;
    }

    public function update($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return false;
        $sql = 'UPDATE `base_area` SET `area_pnum` = ? WHERE `area_id` = ?; ';
        return DB::getInstance($database)->update('ss', $sql, $params) ? : false;
    }

}
