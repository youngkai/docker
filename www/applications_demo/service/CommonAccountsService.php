<?php
/*================================================================
*  File Name：CommonAccountsService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 13:37:07
*  Description：
===============================================================*/
class CommonAccountsService
{

    //Required Fields
    private $_requiredFields = [
        'company_id' => '公司ID',
        'accounts_type' => '账号类型',
        'accounts_name' => '登录账号',
        'accounts_pass' => '账号密码',
        'accounts_mobile' => '手机号码',
        'is_administrator' => '是否管理员',
    ];
    /**
     * 根据AccountsId获取用户信息
     * @param int $accountsId 账号ID
     * @return array
     */
    public function getAccountsByAccountsId($accountsId = 0)
    {
        if (0 == $accountsId) {
            throw new Exception('用户Id无效', 200010010000);
        }
        $accountsInfo = (new CommonAccountsModel())->getAccountsByAccountsId($accountsId);
        if (empty($accountsInfo)) {
            throw new Exception('账号无效', 200010010001);
        }
        return $accountsInfo;
    }

    /**
     * 保存账号信息
     */
    public function saveAccounts($params = [])
    {
        if (empty($params)) {
            throw new Exception('参数无效',200010010002);
        }
        foreach($this->_requiredFields as $k=>$v) {
            if (empty($params[$k])) {
                throw new Exception($v . '无效', 200010010003); 
            } 
        }
        $result = (new CommonAccountsModel())->saveAccounts($params);
        if (!$result) {
            throw new Exception('操作失败', 200010010004);
        }
        return $result;
    }



}
