<?php
/*================================================================
*  File Name：PlatformChannelService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-15 13:59:21
*  Description：
===============================================================*/
class PlatformChannelService 
{
    public function getChannelByChannelCode($code = '')
    {
        if ('' == $code) {
            throw new Exception('渠道注册编码无效', 200040001000);
        }
        $result = (new PlatformChannelModel())->getChannelByChannelCode($code); 
        if (empty($result)) {
            throw new Exception('渠道注册码无效', 200040001001);
        }
        return $result;
    }

}
