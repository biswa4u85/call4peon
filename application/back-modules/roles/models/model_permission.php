<?php

class Model_permission extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "module_master";
        $this->primary_key = "iModuleId";
    }

    function insert($data = array()) {

        $this->db->insert($this->main_table, $data);
        $insert_id = $this->db->insert_id();
        //pr($insert_id);
        return $insert_id;
    }

    function update($tbl = '', $data = array(), $where = '') {
        if ($tbl == '') {
            $this->db->where($where, false, false);
            $res = $this->db->update($this->main_table, $data);
        } else {
            $this->db->where($where, false, false);
            $res = $this->db->update($tbl, $data);
        }
        $rs = $this->db->affected_rows();
        return $rs;
    }

    function getData($fields, $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        $this->db->start_cache();
        $join_arr = array(array('table' => 'permission', 'condition' => 'module_master.iModuleId=permission.iModuleId', 'jointype' => 'left'));
        $join_ary = array_merge($join_arr, $join_ary);
        if (is_array($join_ary) && count($join_ary) > 0) {
            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
        }
        if (trim($condition) != '') {
            $this->db->where($condition);
        }
        if (trim($groupby) != '') {
            $this->db->group_by($groupby);
        }
        if (trim($having) != '') {
            $this->db->having($having);
        }
        if ($orderby != '' && is_array($paging_array) && count($paging_array) == "0") {
            $this->db->order_by($orderby);
        }

        $this->db->from($this->main_table);
        $this->db->stop_cache();
        $list_data = $this->db->get()->result_array();
        //echo $this->db->last_query();exit;
        $this->session->set_userdata(array('query' => $this->db->last_query()));
        $this->db->flush_cache();
        //print_r($list_data);
        return $list_data;
    }

    function delete($where = '') {
        $this->db->where($where);
        $this->db->delete($this->main_table);
        return 'deleted';
    }

    function getuserdata($condition) {
        $this->db->where($condition);
        $this->db->from('user_tbl');
        return $this->db->get($table)->result_array();
    }

    function getRole($id) {
        $this->db->select('*');
        $this->db->where('iRoleId', $id);
        $this->db->from('role_master');
        return $this->db->get()->result_array();
    }

    /*function moduleList() {
        $where = array('eStatus' => 'Active', 'eMenuType' => 'Back');
        $this->db->select('*,(select vModule from module_master as mm where mm.iModuleId = module_master.iParentId) as parent_name');
        $this->db->where($where);
        $this->db->where("vModule not like 'create%'");
        $this->db->from('module_master');
        $res = $this->db->get()->result_array();
        //echo $this->db->last_query();exit;
        return $res;
    }*/
    
    function moduleList() {
        $where = array('eStatus' => 'Active', 'eMenuType' => 'Back', 'iParentId' => '0');
        $this->db->select('*');
        $this->db->where($where);
        $this->db->where('vModule != ','Dashboard');
        $this->db->from('module_master');
        $res = $this->db->get()->result_array();
//        echo $this->db->last_query();exit;
//        pr($res);exit;
        return $res;
    }

    function getPermissionRow($rid, $mid) {
        $this->db->select('*');
        $this->db->where('iRoleId', $rid);
        $this->db->where('iModuleId', $mid);
        $this->db->from('permission');
        $res = $this->db->get()->result_array();
//        echo $this->db->last_query();
//        pr($res);exit;
        return $res;
    }

    function updateRow($tbl = '', $data = array(), $where = '') {
        $this->db->where($where, false, false);
        $res = $this->db->update($tbl, $data);
        return $rs;
    }

    public function checkDuplicate($table = 'role_master', $field = '', $value = '', $cond = '') {
        if ($field != '' && $value != '') {
            $this->db->select($field);
            $this->db->from($table);
            if ($cond != '') {
                $this->db->where($cond, false, false);
            }

            if (is_array($field)) {
                foreach ($field as $key => $type_value) {
                    $this->db->where($type_value, $value[$key]);
                }
            } else {
                $this->db->where($field, $value);
            }

            $user_data = $this->db->get()->result_array();
            //pr($user_data);
            //echo $this->db->last_query();exit;
            if (is_array($user_data) && count($user_data) > 0) {
                return "false";
            } else {
                return "true";
            }
        } else {
            return "false";
        }
    }

    function updatePermissionRow($rId, $mId, $read, $write, $delete) {
        $data['iRoleId'] = $rId;
        $data['iModuleId'] = $mId;
        $data['isRead'] = $read;
        $data['isWrite'] = $write;
        $data['isDelete'] = $delete;
        $this->db->where('iRoleId', $rId);
        $this->db->where('iModuleId', $mId);
        $res = $this->db->update('permission', $data);
        //echo $this->db->last_query();exit;
        return $res;
    }

    function insertPermissionRow($rId, $mId, $read, $write, $delete) {
        $data['iRoleId'] = $rId;
        $data['iModuleId'] = $mId;
        $data['isRead'] = $read;
        $data['isWrite'] = $write;
        $data['isDelete'] = $delete;
        $this->db->insert('permission', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function insertDashboardPermissionRow($rId) {
        $this->db->select('iModuleId');
        $this->db->from('module_master');
        $this->db->where('vModule','Dashboard');
        $this->db->where('eMenuType','Back');
        $res = $this->db->get()->result_array();
        
        $moduleId = $res[0]['iModuleId'];
        
        $data['iRoleId'] = $rId;
        $data['iModuleId'] = $moduleId;
        $data['isRead'] = 1;
        $data['isWrite'] = 1;
        $data['isDelete'] = 1;
        $this->db->insert('permission', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getPagePermission($iRoleId, $selfurl, $type) {
        $this->db->select('m.`iModuleId`,m.`vURL`,p.*');
        $this->db->from('`module_master` m,permission p');
        $this->db->where("m.`vURL` LIKE '" . $selfurl . "' AND p.iRoleId = '" . $iRoleId . "' and m.`iModuleId` = p.`iModuleId` ");
        $res = $this->db->get()->result_array();
//        echo $this->db->last_query();exit;
//        pr($res);exit;
        return $res;
    }

    function getPageDeletePermission($iRoleId, $selfurl, $type) {
        $this->db->select('m.`iModuleId`,m.`vURL`,p.*');
        $this->db->from('`module_master` m,permission p');
        $this->db->where("m.`vURL` LIKE '" . $selfurl . "' AND p.iRoleId = '" . $iRoleId . "' and m.`iModuleId` = p.`iModuleId` ");
        $res = $this->db->get()->result_array();
        return $res;
    }

    function getModuleWithParam($rid) {
        $this->db->select('m.*,p.*');
        $this->db->from('`module_master` m,permission p');
        $this->db->where("m.`iModuleId` = `p`.`iModuleId`");
        $this->db->where("m.`iParentId`", '0');
        $this->db->where("p.iRoleId", $rid);
        $this->db->where("m.eStatus", 'Active');
        $this->db->where("(p.isRead = '1' or p.isWrite='1' or p.isDelete='1')");
        $this->db->order_by("m.iSequenceOrder");
        $res = $this->db->get()->result_array();
        return $res;
    }

    function getSubMenuList($rid, $mid) {
        $this->db->select('m.*,p.*');
        $this->db->from('`module_master` m,permission p');
        $this->db->where("m.`iModuleId` = p.`iModuleId`");
        $this->db->where("m.`iParentId`", $mid);
        $this->db->where("p.iRoleId", $rid);
        $this->db->where("m.eStatus", 'Active');
        $this->db->where("(p.isRead = 1 or p.isWrite=1 or p.isDelete=1)");
        $res = $this->db->get()->result_array();
        return $res;
    }

    function getSubModules($mid) {
        $this->db->select('mm.vModule');
        $this->db->where("mm.iModuleId", $mid);
        $this->db->get("module_master as mm");
        $sub_query = $this->db->last_query();

        $this->db->select('*,(' . $sub_query . ') as parent_name');
        $this->db->where('iParentId', $mid);
        $this->db->from($this->main_table);
        $res = $this->db->get()->result_array();
        
        return $res; 
    }
    
    function checkModulePermission($userRoleId, $moduleId) {
        $this->db->select('*');
        $this->db->from('permission');
        $this->db->where("iRoleId",$userRoleId);
        $this->db->where("iModuleId",$moduleId);
        $res = $this->db->get()->result_array();
        //return $res;
        
        if(is_array($res) && count($res) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

}
