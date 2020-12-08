<?php
/*================================================================
*  File Name：PlatformAccounts.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 18:09:59
*  Description：
===============================================================*/
class PlatformAccountsModel
{

    /**
     * 根据accountId获取代理账号信息
     * @param int $accountId 代理账号ID
     * @return array
     */
    public function getPlatformAccountsByAccountsId($accountId = 0)
    {
        if (0 == $accountId) return [];
        $sql = 'SELECT `accounts_id`, `status`, `agent_id`  FROM `platf_accounts` WHERE `accounts_id` = ?;';
        return DB::getInstance('master')->getOne('i', $sql, ['agent_id'=>$accountId]) ? : [];    
    }


}

