<?php
/*================================================================
*  File Name：RegisterInvitationCodeService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 10:56:31
*  Description：
*  每个Service代表一个领域的业务单元，所有的业务逻辑处理必须在
*  Service层完成。
===============================================================*/
class RegisterInvitationCodeService
{

    public function getRegisterInvitationCode($code = '')
    {
        if (empty($code)) {
            throw new Exception('注册邀请码无效', 2000100000);
        }
        $registerInvitationCode = (new RegisterInvitationCodeModel())->getRegisterInvitationCode($code);
        if (empty($registerInvitationCode)) {
            throw new Exception('注册邀请码无效', 2000100001);
        }
        return $registerInvitationCode;
    }


}
