<?php
/*================================================================
*  File Name：BaseMultiOptions.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 15:11:51
*  Description：
===============================================================*/
class BaseMultiOptionsModel
{
    public function saveDefaultRecords($dataStr = '', $database = '')
    {
        if ('' == $dataStr || '' == $database) return [];
        $sql = 'INSERT INTO `base_multi_options` (`company_id`, `multi_id`, `options_num`, `options_name`) VALUES '. $dataStr .';';
        return DB::getInstance($database)->insert('', $sql);
    }


}
