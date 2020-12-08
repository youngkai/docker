<?php
/*================================================================
*  File Name：CommonDefault.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-18 15:37:36
*  Description：
===============================================================*/
class CommonDefaultModel
{
    public function getCommonDefaultDataByIndustrayId($industryId = '')
    {
        if ('' == $industryId) return [];
        $industryId = "'".implode("','", [0, $industryId])."'";
        $sql = 'SELECT * FROM `common_default` WHERE `industray_id` IN ('. $industryId .') ;';
        return DB::getInstance('master')->getRow('', $sql, []) ? : [];;
    }
}
