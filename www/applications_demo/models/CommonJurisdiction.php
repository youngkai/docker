<?php
/*================================================================
*  File Name：CommonJurisdiction.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 19:38:09
*  Description：
===============================================================*/
class CommonJurisdictionModel
{
    public function saveDefaultRecords($dataStr = '')
    {
        if ('' == $dataStr) return [];
        $sql = 'INSERT INTO `common_jurisdiction` (`company_id`,`group_id`,`rule_group_id`) VALUES '. $dataStr .';';
        return DB::getInstance('master')->insert('', $sql);
    }

}
