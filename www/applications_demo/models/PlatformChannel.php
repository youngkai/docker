<?php
/*================================================================
*  File Name：PlatformChannel.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 21:33:29
*  Description：
===============================================================*/
class PlatformChannelModel
{
    public function getChannelByChannelCode($code = '')
    {
        if ('' == $code) return [];
        $sql = 'SELECT `channel_id`,`channel_name`,`channel_code` FROM `platf_channel` WHERE `channel_code` = ?;';
        return DB::getInstance('master')->getOne('s', $sql, ['channel_code'=>$code]) ? : [];
    }


}
