<?php
/*================================================================
*  File Name：BaseUnits.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 16:24:17
*  Description：
===============================================================*/
class BaseUnitsModel
{
    public function saveDefaultRecords($params = [], $database = '')
    {
        if (empty($params) || '' == $database) return []; 
        $sql = 'INSERT INTO `base_units` (`company_id`, `units_name`) VALUES (?, ?);';
        return DB::getInstance($database)->insert('ss', $sql, $params) ? : [];
    }

}
