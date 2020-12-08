<?php
/*================================================================
 *  File Name：CommonDefaultService.php
 *  Author：carlziess, chengmo9292@126.com
 *  Create Date：2018-06-18 14:20:29
 *  Description：
 *  添加一个公司需要提前初始化这么多数据，业务边界和数据边界在哪里呢？
 *  这个初始化来回写业务库、更新业务库，事务一致性很不好做，回头需要重新设计
 ===============================================================*/
class CommonDefaultService
{

    private $_default = [];

    public function initCompany($company_id = 0, $industry_id = '', $version = 'free', $database = '')
    {
        if (0 == $company_id || '' == $industry_id || '' == $database) {
            throw new Exception('初始化公司失败', 200050001000);
        }
        $tmp = (new CommonDefaultModel())->getCommonDefaultDataByIndustrayId($industry_id);
        $this->_rebuidData($tmp);
        foreach($this->_default['independence'] as $k=>$item){
            switch ($item['data_table_name']) {
                case 'base_area':
                    $this->_createDefautlArea($item, $company_id, $database);//区域
                    break;
                case 'common_branch':
                    $this->_createDefautlBranch($item, $company_id);//部门
                    break;
                case 'common_group':
                    $this->_createDefautlGroup($item, $company_id, $version);
                    break;
                case 'base_bank':
                    $this->_createDefautlBank($item, $company_id, $database);
                    break;
                case 'base_category':
                    $this->_createDefautlCategory($item, $company_id, $database);
                    break;
                case 'base_client_type':
                    $this->_createDefautlClientType($item, $company_id, $database);
                    break;
                case 'base_stock':
                    $this->_createDefautlStock($item, $company_id, $database);
                    break;
                case 'base_units':
                    $this->_createDefautlUnits($item, $company_id, $database);
                    break;
                case 'base_multi':
                    $this->_createDefautlMulti($item, $company_id, $database);
                    break;
                case 'common_set':
                    $this->_createDefautlSet($item, $company_id);
                    break;
                default:
                    break;
            }
        }

    }


    private function _createDefautlSet($item, $company_id){
        $data = array(
            'company_id'    =>  $company_id,
            'set_value'     =>  $item['default_value'],
            'set_type'      =>  $item['default_type'],
            'set_name'      =>  $item['default_name'],
            'create_date'   =>  date('Y-m-d H:i:s' , time())
        );
        return (new CommonSetModel())->saveDefaultRecords($data);
    }


    private function _createDefautlMulti($item, $company_id, $database){
        $data = array(
            'company_id'    =>  $company_id,
            'multi_num'     =>  get_data_number('base_multi' , 1 , $company_id),
            'multi_name'    =>  $item['default_name'],
        );
        $lastId = (new BaseMultiModel())->saveDefaultRecords($data, $database);
        if (null == $lastId) return false;
        $currDetail = $this->_default['dependence'][$item['default_id']];
        $tempArr = explode('、', $currDetail['default_value']);
        foreach ($tempArr as $key => $value) {
            $dataArr[] = "('" . $company_id . "', '" . $lastId . "', '" . get_data_number('base_multi_options' , 1 , $company_id) . "', '" . $value ."')";
        }
        $tmp = implode(',', $dataArr);
        return (new BaseMultiOptionsModel())->saveDefaultRecords($tmp, $database);
    }

    private function _createDefautlUnits($item, $company_id, $database){
        $data = array(
            'company_id'    =>  $company_id,
            'units_name'        =>  $item['default_name'],
        );
        return (new BaseUnitsModel())->saveDefaultRecords($data, $database);
    }

    private function _createDefautlStock($item, $company_id, $database){
        $data = array(
            'company_id'    =>  $company_id,
            'stock_num'     =>  get_data_number('base_stock' , 1 , $company_id),
            'stock_name'    =>  $item['default_name'],
            'is_default'    =>  'T',
        );
        return (new BaseStockModel())->saveDefaultRecords($data, $database);
    }

    private function _createDefautlClientType($item, $company_id, $database){
        $data = array(
            'company_id'    =>  $company_id,
            'data_type'     =>  'agency',
            'type_num'      =>  get_data_number('base_client_type' , 1 , $company_id),
            'type_name'     =>  $item['default_name'],
            'is_default'    =>  'T',
            'order_num'     =>  500
        );
        return (new BaseClientTypeModel())->saveDefaultRecords($data, $database);
    }

    private function _createDefautlCategory($item, $company_id, $database){
        $data = array(
            'company_id'        =>  $company_id,
            'parent_id'         =>  0,
            'category_pnum'     =>  '0.',
            'category_num'      =>  get_data_number('base_category' , 1 , $company_id),
            'category_name'     =>  $item['default_name'],
            'is_default'        =>  'T'
        );
        $cateObj = new BaseCategoryModel();
        $lastId = $cateObj->saveDefaultRecords($data, $database);
        if (null == $lastId) return false;
        return $cateObj->update(['category_pnum' => '0.'.$lastId.'.', 'category_id' => $lastId], $database);
    }

    private function _createDefautlBank($item, $company_id, $database){
        $data = array(
            'company_id'    =>  $company_id,
            'status'        =>  'T',
            'account_name'  =>  $item['default_name'],
            'is_default'    =>  'T'
        );
        return (new BaseBankModel())->saveDefaultRecords($data, $database);
    }

    private function _createDefautlGroup($item, $company_id, $version='free'){
        $data = array(
            'company_id'    =>  intval($company_id),
            'group_name'        =>  $item['default_name'],
            'create_date'       =>  date('Y-m-d H:i:s' , time())
        );
        if ($item['default_value'] == 'T') {
            $data['is_administrator'] = 'T';
        }else{
            if($version == 'affiliate') return false;
        }
        $lastId = (new CommonGroupModel())->saveDefaultRecords($data);
        if (null == $lastId) return false;
        $currDetail = $this->_default['dependence'][$item['default_id']];
        $tempArr = explode(',', $currDetail['default_value']);
        foreach ($tempArr as $key => $value) {
            $dataArr[] = "('" . $company_id . "', '" . $lastId . "', '" . $value ."')";
        }
        $tmp = implode(',', $dataArr);
        return (new CommonJurisdictionModel())->saveDefaultRecords($tmp);
    }

    private function _createDefautlBranch($item, $company_id){
        $data = array(
            'company_id'    =>  $company_id,
            'parent_id'     =>  0,
            'branch_pnum'       =>  '0.',
            'branch_num'        =>  get_data_number('common_branch' , 1 , $company_id),
            'branch_name'       =>  $item['default_name'],
            'create_date'       =>  date('Y-m-d H:i:s' , time())
        );
        $branchObj = new CommonBranchModel();
        $lastId = $branchObj->saveDefaultRecords($data);
        if (null == $lastId) return false;
        //更新 pnum字段
        return $branchObj->update(['branch_pnum'=>'0.'.$lastId.'.', 'branch_id'=>$lastId]);
    }

    private function _createDefautlArea($item, $company_id, $database){
        $data = array(
            'company_id'    =>  $company_id,
            'parent_id'     =>  0,
            'area_pnum'     =>  '0.',
            'is_default'    =>  'T',
            'area_num'      =>  get_data_number('base_area' , 1 , $company_id),
            'area_name'     =>  $item['default_name'],
            'pinyin'        =>  $item['default_name']
        );
        $areaObj = new BaseAreaModel();
        $lastId = $areaObj->saveDefaultRecords($data, $database);
        if (null == $lastId) return false;
        return $areaObj->update(['area_pnum'=>'0.'.$lastId.'.', 'area_id'=>$lastId], $database);
    }

    private function _rebuidData($params = [])
    {
        if (empty($params)) return [];
        foreach($params as $k=>$v){
            if($v['relation_default_id'] != 0) {
                $this->_default['dependence'][$v['relation_default_id']] = $v;
            }
            $this->_default['independence'][$v['default_id']] = $v;
        }
    }

}
