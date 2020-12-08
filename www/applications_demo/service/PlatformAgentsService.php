<?php
/*================================================================
*  File Name：PlatformAgentsService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-14 18:14:51
*  Description：
===============================================================*/
class PlatformAgentsService
{
    /**
     * 根据AgentId获取代理用户信息
     * @param int $agentId 代理用户Id
     * @return array
     */
    public function getAgentByAgentId($agentId = 0)
    {
        if (0 == $agentId) {
            throw new Exception('代理ID无效', 200020001000);
        }
        $agentInfo = (new PlatformAgentsModel())->getAgentByAgentId($agentId);
        if (empty($agentInfo)) {
            throw new Exception('代理无效', 200020001001); 
        }
        return $agentInfo;
    }

    public function getAgentsByCityId($cityId = 0)
    {
        if (0 == $cityId) {
            throw new Exception('归属地无效', 200020001002);
        }
        $agentInfo = (new PlatformAgentsModel())->getAgentsByCityId($cityId);
        if (empty($agnetInfo)) {
            throw new Exception('代理无效', 200020001003); 
        }
        return $agentInfo;
    }

    public function query($params = [])
    {
    
    
    }

}
