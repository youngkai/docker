<?php
/*================================================================
*  File Name：RegisterInvitationCode.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 09:03:49
*  Description：
*  Model层只允许Service层请求，Model层不再做具体参数的校验，具体参数
*  的校验必须在Service层完成。
===============================================================*/
class RegisterInvitationCodeModel
{
    /**
     * @todo 业务场景需要优化
     * 数据结构需要调整
     */
    public function getRegisterInvitationCode($code = '')
    {
        if (empty($code)) return [];
        $sql = 'SELECT `accounts_id`,`invite_code_id`,`type` FROM `common_invite_code` WHERE `code_value`=?;'; 
        return DB::getInstance('master')->getOne('i', $sql, ['code_value'=>$code]) ? : [];    
    }


}

