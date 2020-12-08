<?php
/*================================================================
*  File Name：CommonCompany.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 11:21:22
*  Description：
*  Model层只允许Service层请求，Model层不再做具体参数的校验，具体参数
*  的校验必须在Service层完成。
===============================================================*/
class CommonCompanyModel
{
    /**
     * 保存公司信息
     */
    public function saveCompany($params = [])
    {
        if (empty($params)) return []; 
        $sql = 'INSERT INTO `common_company` (`area_id`,`industry_id`, `company_num`, `system_name`,`system_signed`, `prefix`, `status`, `company_name`,
`business_license`, `legal_person`, `legal_mobile`, `phone`, `fax`, `address`, `web_url`, `dh_url`, `logo`, `about`, `begin_date`, `end_date`, `client_number`, `sms_number`, `data_database`, `create_date`, `email`, `contact`, `version`, `regist_ip`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ';
        try{
            DB::getInstance('master')->beginTransaction();
            $result = DB::getInstance('master')->insert('ssssssssssssssssssssssssssss', $sql, [
                'area_id' => $params['city_id'],
                'industry_id' => $params['industry_id'],
                'company_num' => $params['company_num'],
                'system_name' => $params['system_name'],
                'system_signed' => $params['system_signed'],
                'prefix' => $params['prefix'],
                'status' => $params['status'],
                'company_name' => $params['company_name'],
                'business_license' => $params['business_license'],
                'legal_person' => $params['legal_person'],
                'legal_mobile' => $params['legal_mobile'],
                'phone' => $params['phone'],
                'fax' => $params['fax'],
                'address' => $params['address'],
                'web_url' => $params['web_url'],
                'dh_url' => $params['dh_url'],
                'logo' => $params['logo'],
                'about' => $params['about'],
                'begin_date' => $params['begin_date'],
                'end_date' => $params['end_date'],
                'client_number' => $params['client_number'],
                'sms_number' => $params['sms_number'],
                'data_database' => $params['data_database'],
                'create_date' => $params['create_date'],
                'email' => $params['email'],
                'contact' => $params['contact'],
                'version' => $params['version'],
                'regist_ip' => $params['regist_ip']
            ]);
        } catch (Exception $e){
            DB::getInstance('master')->rollBack();
            throw $e;
        }
        DB::getInstance('master')->commit();
        return !empty($result['insert_id']) ? $result['insert_id'] : 0;
    }

}

