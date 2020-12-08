<?php
/*================================================================
*  File Name：Member.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2016-09-19 23:18:49
*  Description：
===============================================================*/
class MemberModel extends Auth\Driver
{
    
    public function retrieve($token = '')
    {
        if ('' == $token) {
            return NULL;
        }
        return json_decode($token);
    }

    public function attempt($args = []) { }

}
?>
