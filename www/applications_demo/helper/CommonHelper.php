<?php
/*================================================================
*  File Name：CommonHelper.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-18 10:35:42
*  Description：
===============================================================*/
use Utility\Sessions;

/**
 * 获取公司Id
 * @return null|company_id
 */
function get_company_id()
{
    if (defined('BIND_COMPANY_ID')) {
        return intval(BIND_COMPANY_ID);
    } 
    $sessions = Sessions::getSession('cInfo');
    return !empty($sessions['company_id']) ? $sessions['company_id'] : null;
}

/**
 * 通存储过程获取序列号
 * php的openssl_random_pseudo_bytes或者random_bytes(php7)的随机能力已经秒级百万了
 * 没必要搞存储过程这个性能杀手,更没必要大规模使用，不能为了设计而作。工程问题需要科学处理。
 * @param string $dataTableName :表名，$isUpdate:是否更新，1:更新，0:不更
 * @return null|string
 */
function get_data_number($tableName = '', $isUpdate = 0, $companyId = null)
{
    if ('' == $tableName) return '';
    $proSql  = " proc_get_auto_no(" . $companyId . ", '" . $tableName . "', " . $isUpdate . ")";
    $result = (new MySQLProcedure())->callProcedure($proSql);
    return !empty($result) ? $result[0]['returns'] : null;
}

/**
 * @param string $data 
 */
function dhb_encrypt($data = '')
{
    if ('' == $data) {
        throw new Exception('加密数据无效', 400);
    }
    $key = (new \Yaf\Config\Ini(APPLICATION_PATH. DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'other.ini'))->key; 
    return md5($key . $data);
}
