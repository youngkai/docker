<?php
/*================================================================
*  File Name：PlatformCompanyReport.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-15 01:34:16
*  Description：
===============================================================*/
class PlatformCompanyReportModel
{
    public function getCompanyReport($params = [])
    {
        if (empty($params)) return [];
        $sql = 'SELECT `agent_id`, `company_name`, `industry_id` FROM `platf_company_report` WHERE `industry_id` = ? AND `area_id` = ? AND `mobile` = ? AND `company_name` = ? AND  `status` = ? AND `expire_date` >= ?;';
        return DB::getInstance('master')->getOne('isssss', $sql, ['industry_id'=>$params['industry_id'], 'area_id'=>$params['city_id'], 'mobile'=>$params['tel'], 'company_name'=>$params['company_name'], 'status'=>'F', 'expire_date'=>date('Y-m-d')]) ? : [];    
    }

    public function updateReport($params = [])
    {
        if (empty($params)) return false;
        $sql = 'UPDATE `platf_company_report` SET `reg_date`=?, `status`=? WHERE `report_id`=?;';
        return DB::getInstance('master')->update('sss', $sql, 
            [
                'reg_date'=>date('Y-m-d'), 
                'status'=>$params['status'], 
                'report_id'=>$params['report_id']
            ]);
    }

}
