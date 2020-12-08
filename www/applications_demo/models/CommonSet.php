<?php
/*================================================================
*  File Name：CommonSet.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-18 16:58:28
*  Description：
*
===============================================================*/
class CommonSetModel
{

    /**
     * @fixme 原来的AboutDefaultService :: _createDefautlSet 直接调用Model::add()
     * 1、没必要参数校验
     * 2、很多跨Service领域直接操作Model的数据异常也不处理，因为数据异常导致的业务异常排查成本高。
     * 3、多处直接引用模型模型的变化将直接导致所有调用方的业务异常，排查成本也高
     * 4、Service里面多入参，多处调用Service，Service本身的入参调整将直接导致调用方的直接错误。
     */
    public function saveDefaultRecords($params = [])
    {
        if (empty($params)) return [];
        $sql = "INSERT INTO `common_set` (`company_id`, `set_value`, `set_type`, `set_name`, `create_date`) VALUES (?, ?, ?, ?, ?);";
        return DB::getInstance('master')->insert('sssss', $sql, $params) ? : false;
    }

}
