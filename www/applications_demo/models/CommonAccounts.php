<?php
/*================================================================
*  File Name：CommonAccounts.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 13:38:21
*  Description：
*  Model层只允许Service层请求，Model层不再做具体参数的校验，具体参数
*  的校验必须在Service层完成。
===============================================================*/
class CommonAccountsModel
{

    /**
     * 根据AccountsId获取账号信息
     * @param int $accountsId 账号ID
     * @return array
     */
    public function getAccountsByAccountsId($accountsId = 0)
    {
        if (0 == $accountsId) return [];
        $sql = 'SELECT * FROM `common_accounts` WHERE `accounts_id`= ?;';
        return DB::getInstance('master')->getOne('i', $sql, ['accounts_id'=>$accountsId]) ? : [];    
    }

    /**
     * 保存账号信息
     * @param array $params 用户账号数据通过数组传入
     * @return Boolean
     */
    public function saveAccounts($params = [])
    {
        if (empty($params)) return false;
        $sql = 'INSERT INTO `common_accounts` (`company_id`, `accounts_type`, `accounts_name`, `accounts_pass`, `accounts_mobile`, `is_administrator`, `create_date`) VALUES (?, ?, ?, ?, ?, ?, ?);';
        $result = DB::getInstance('master')->insert('sssssss', $sql, 
            [
                'company_id' => $params['company_id'],
                'accounts_type' => $params['accounts_type'],
                'accounts_name' => $params['accounts_name'],
                'accounts_pass' => $params['accounts_pass'],
                'accounts_mobile' => $params['accounts_mobile'],
                'is_administrator' => $params['is_administrator'],
                'create_date' => date('Y-m-d H:i:s')
            ]);
        return !empty($result['insert_id']) ? $result['insert_id'] : false;
    }

    /**
     * 多条件查询账号信息
     * @param array $params 账号查询条件通过数组传入
     * @return array
     */
    public function queryAccounts($params = [])
    {
        if (empty($params)) return [];
    
    
    }


}
