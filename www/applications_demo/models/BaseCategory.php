<?php
/*================================================================
*  File Name：BaseCategory.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 17:36:39
*  Description：
===============================================================*/
class BaseCategoryModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return [];
        $sql = 'INSERT INTO `base_category` (`company_id`, `parent_id`, `category_pnum`, `category_num`, `category_name`, `is_default`) VALUES (
?, ?, ?, ?, ?, ?);';
        $result = DB::getInstance($database)->insert('ssssss', $sql, $params);
        return empty($result['insert_id']) ? $result['insert_id'] : null;
    }

    public function update($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return false;
        $sql = 'UPDATE `base_category` SET `category_pnum` = ? WHERE `category_id` = ?;';
        return DB::getInstance($database)->update('ss', $sql, $params) ? : false;
    }

}
