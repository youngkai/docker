<?php
/*================================================================
 *  File Name：PlatformAgents.php
 *  Author：carlziess, chengmo9292@126.com
 *  Create Date：2018-06-14 18:09:59
 *  Description：
 ===============================================================*/
class PlatformAgentsModel
{

    /**
     * 根据代理Id获取代理信息
     * @param int $agentId 代理ID
     * @return array
     */
    public function getAgentByAgentId($agentId = 0)
    {
        if (0 == $agentId) return [];
        $sql = 'SELECT `auto_open_erp`, `agent_email`, `agent_name`, `channel_id` AS `accounts_id` FROM `platf_agents` WHERE `agent_id` = ?;';
        return DB::getInstance('master')->getOne('i', $sql, ['agent_id'=>$agentId]) ? : [];    
    }

    /**
     * 根据区域ID获取代理商信息
     * @param string $cityId 地区ID
     * @return array
     */
    public function getAgentsByCityId($cityId = 0)
    {
        if (0 == $cityId) return [];
        $tmp = substr($cityId, 0, 2) . '0000';
        $in = "'". implode("','", [$cityId, $tmp]) . "'";
        $sql = 'SELECT `agent_id`, `channel_id` AS `accounts_id` FROM `platf_agents` WHERE `agent_city` IN (' . $in . ') AND `agent_type` = ? AND `status` = ?;';
        return DB::getInstance('master')->getOne('si', $sql, ['agent_type'=>'operation', 'status'=>0]) ? : [];    
    }


}

