<?php
/*================================================================
 *  File Name：CommonCompanyService.php
 *  Author：carlziess, chengmo9292@126.com
 *  Create Date：2018-06-14 10:44:59
 *  Description：
 *  每个Service代表一个领域的业务单元，所有的业务逻辑处理必须在
 *  Service层完成。
 *  
 ===============================================================*/
use Utility\Utility;
class CommonCompanyService
{

    //公司领域模型，Company的模型中必要字段
    private $_requiredFields = [
        'tel' => '电话',
        'accounts_name' => '登录账号', //他妈的什么鬼东西都能揉在一起
        'password' => '密码',
        'company_name' => '公司',
        'city_id' => '归属地',
        'industry_id' => '行业ID'
    ];

    //行业id
    private $_industryIds = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '100'];

    /**
     * 存储公司信息
     * @param array $params 公司入参
     * @return boolean
     */
    public function save($params = [])
    {
        if (empty($params)) {
            throw new Exception('入参无效', 200100001);
        }
        foreach($this->_requiredFields as $k=>$v) {
            if (empty($params[$k])) {
                throw new Exception($v . '无效', 200100002); 
            } 
            if ('tel' == $k && false == preg_match('/^1([0-9]{9})/', $params[$k])) {
                throw new Exception('电话号码无效', 200100003);
            }
            if ('password' == $k && false == preg_match("/^[a-zA-Z0-9]{3,18}$/", $params[$k])) {
                throw new Exception('密码无效', 200100004); 
            }
            if ('industry_id' == $k && false == in_array($params[$k], $this->_industryIds)) {
                throw new Exception('行业ID无效', 200100005); 
            }
        }
        //invitation code
        if (!empty($params['regist_invite_code'])) {
            $registerInvitationCode = (new RegisterInvitationCodeService())->getRegisterInvitationCode($params['regist_invite_code']);
            $params['agent_id'] = 0;
            if ('agent' == $registerInvitationCode['type']) {
                $registerInvitationCode['accounts_id'] = 84;
                $accountsInfo = (new PlatformAccountsService())->getPlatformAccountsByAccountsId($registerInvitationCode['accounts_id']);
                $agentInfo = (new PlatformAgentsService())->getAgentByAgentId($accountsInfo['agent_id']);
                $params['sale_id'] = $agentInfo['accounts_id'];
            }
            if ('platf' == $registerInvitationCode['type']) {
                $params['agent_id'] = $registerInvitationCode['accounts_id']; 
            }
            //regional agent
            $regionalAgentInfo = (new PlatformAgentsService())->getAgentsByCityId($params['city_id']);
            if (!empty($regionalAgentInfo)) {
                $params['agent_id'] = $regionalAgentInfo['agent_id'];
                $params['sale_id'] = $regionalAgentInfo['accounts_id'];
            }
        } else {
            //report
            $platfCompanyReport = (new PlatformCompanyReportService())->getCompanyReport($params);
            if (!empty($platfCompanyReport)) {
                $params['agent_id'] = $platfCompanyReport['agent_id']; 
                $agentInfo = (new PlatformAgentsService())->getAgentByAgentId($params['agent_id']);
                $params['sale_id'] = $agentInfo['accounts_id'];
                $isReport = true;
            }
        }
        //@fixme company (N个参数需要校验~~~~~)
        $params['area_id'] = $params['city_id'];
        $params['phone'] = $params['tel'];
        $params['legal_mobile'] = $params['tel'];
        $params['system_name'] = $params['company_name'];
        $params['version'] = !empty($params['version']) ? $params['version'] : 'free';
        $params['company_num'] = get_data_number('common_company', 1, 0);
        $params['prefix'] = 'd-'. $params['company_num'];
        $params['begin_date'] = date('Y-m-d');
        $params['end_date'] = date('Y-m-d', strtotime('+1 weeks', time()));
        $params['create_date'] = date('Y-m-d');
        $params['regist_ip'] = Utility::ip();
        if (HOST == 'dhb168.com') {
            $params['data_database'] = 'dhb_data_'.$params['industry_id']; 
        } elseif (HOST == 'newdhb.com') {
            $params['data_database'] = 'test_data_'.rand(1,2); 
        } else {
            $params['data_database'] = 'dhb_data_'.rand(1,2); 
        }
        //@fixme 短信数代码写死？然后放到主表？
        $params['sms_number'] = 20;
        //@fixme 客户数量代码写死？放主表合适？
        $params['client_number'] = 10000;
        $params['system_signed'] = 's' . $params['company_num'];
        $params['status']  = 'N';
        $params['business_license'] = !empty($params['business_license']) ? $params['business_license'] : '';
        $params['legal_person'] = !empty($params['legal_person']) ? $params['legal_person'] : '';
        $params['fax'] = !empty($params['fax']) ? $params['fax'] : '';
        $params['address'] = !empty($params['address']) ? $params['address'] : '';
        $params['web_url'] = !empty($params['web_url']) ? $params['web_url'] : '';
        $params['dh_url'] = !empty($params['dh_url']) ? $params['dh_url'] : '';
        $params['logo'] = !empty($params['logo']) ? $params['logo'] : '';
        $params['about'] = !empty($params['about']) ? $params['about'] : '';
        $params['email'] = !empty($params['email']) ? $params['email'] : '';
        $params['contact'] = !empty($params['contact']) ? $params['contact'] : '';
        /**
         * @fixme
         * 添加公司的model耦合了erp、运营平台、账号、默认数据(在业务库)，还在写业务库，不同的实例不同的连接，需要数据库底层支持跨实例事务
         * 1、先保证主库数据入库,如果主库失败便不再操作业务库
         * 2、如果主库成功业务库失败，先临时搁置，但必须尽快修复
         * 3、第二次优化的时候，使用跨实例事务，同时提交同时失败
         * 4、或者使用消息队列做正向的事务补偿
         */
        $newCompanyId = (new CommonCompanyModel())->saveCompany($params);
        if (0 == $newCompanyId) {
            throw new Exception('操作失败', 200100006); 
        }
        $channelId = '';
        if (!empty($params['regist_channel_code'])) {
            $channelId = (new PlatformChannelService())->getChannelByChannelCode($params['regist_channel_code']); 
        }
        //salers && staff
        $params['company_id'] = $newCompanyId;
        $params['chan_code'] = !empty($params['regist_channel_code']) ? $params['regist_channel_code'] : '';
        $params['channel_id'] = $channelId;
        $params['invite_code'] = !empty($params['regist_invite_code']) ? $params['regist_invite_code'] : '';
        $params['equipment']  = !empty($params['regist_device_info']) ? $params['regist_device_info'] : '';
        $params['agent_id'] = !empty($params['agent_id']) ? $params['agent_id'] : 0;
        $params['purchase_intention'] = !empty($params['purchase_intention']) ? $params['purchase_intention'] : '';
        //accounts
        $params['accounts_type'] = 'manager';  //注册公司就写死Manager了？
        $params['accounts_pass'] = dhb_encrypt($params['password']); //一个明文传输的password有什么卵用？
        $params['accounts_mobile'] = $params['tel'];
        $params['is_administrator']  = 'T';
        $accountsId = (new CommonAccountsService())->saveAccounts($params);
        //default settings
        (new CommonDefaultService())->initCompany($newCompanyId, $params['industry_id'], $params['version'], $params['data_database']);

        return true;

        //staff
        $params['staff_name'] = '';
        //erp
        if ('T' == $agentInfo['auto_open_erp']) {
            $params['serial_number'] = Utility::create_guid(); 
            $params['erp_password'] = rand(100000,999999);
            $params['token'] = '';
            $params['company_id'] = '';
            $params['status'] = 'T';
            $params['run_status'] = 'T';
            $params['erp_version'] = 0;
            $params['erp_user'] = 'P1112E' == $params['regist_invite_code'] ? 'TEENY' : '';
            $params['order_trans_time'] = date('Y-m-d H:i:s');
            $params['order_trans_check'] = 'T';
            $params['remark'] = '';
        }
        //message
        if (!empty($agent['agent_email'])) {
            (new MessageService())->postMessageByEmail($params);            
        }

    }


}
