<?php
/*================================================================
*  File Name：CommonBranch.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-19 20:21:55
*  Description：
===============================================================*/
class CommonBranchModel
{
    public function saveDefaultRecords($params = [])
    {
        if (empty($params)) return [];
        $sql = 'INSERT INTO `common_branch` (`company_id`,`parent_id`,`branch_pnum`,`branch_num`,`branch_name`,`create_date`) VALUES (?, ?, ?, ?, ?,?); ';
        $result = DB::getInstance('master')->insert('ssssss', $sql, $params);
        return !empty($result['insert_id']) ? $result['insert_id'] : null;
    }

    public function update($params = [])
    {
        if (empty($params)) return false;
        $sql = 'UPDATE `common_branch` SET `branch_pnum` = ? WHERE `branch_id` = ?; ';
        return DB::getInstance('master')->update('ss', $sql, $params) ? : false;
    }

}
