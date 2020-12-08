<?php
/*================================================================
*  File Name：PlatformCompanyReport.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-15 01:11:43
*  Description：
===============================================================*/
class PlatformCompanyReportService
{
    public function getCompanyReport($params = [])
    {
        if (empty($params)) {
            throw new Exception('参数无效', 200030001000);
        }
        return (new PlatformCompanyReportModel())->getCompanyReport($params);
    }

    public function updateReport($params = [])
    {
        if (empty($params)) {
            throw new Exception('参数无效', 200030001001);
        }
        return (new PlatformCompanyReportModel())->updateReport($params);
    }

}
