<?php
/*================================================================
*  File Name：PlatformAccountsService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 18:55:16
*  Description：
===============================================================*/
class PlatformAccountsService
{
    public function getPlatformAccountsByAccountsId($accountId = 0)
    {
        if (0 == $accountId) {
            throw new Exception('代理账号ID无效', 200030001000);
        }
        $accountsInfo = (new PlatformAccountsModel())->getPlatformAccountsByAccountsId($accountId);
        if (empty($accountsInfo)) {
            throw new Exception('代理账号信息无效', 200030001001);
        }
        return $accountsInfo;
    }


}
