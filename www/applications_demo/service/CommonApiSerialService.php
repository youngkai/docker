<?php
/*================================================================
*  File Name：CommonApiSerialService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-15 14:43:22
*  Description：
===============================================================*/
class CommonApiSerialService
{
    public function save($params = [])
    {
        if (empty($params)) {
            throw new Exception('入参无效', 200040001000);
        }
    
    }

}
