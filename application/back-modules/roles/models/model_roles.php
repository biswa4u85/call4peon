<?php

class Model_roles extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "role_master";
        $this->primary_key = "iRoleId";
    }

    function insert($data = array()) {
        
        $this->db->insert($this->main_table, $data);
        $insert_id = $this->db->insert_id();
        //pr($insert_id);
        return $insert_id;
    }

    function update($data = array(), $where = '') {
        
        if (intval($where) > 0) {
            $this->db->where($this->primary_key, $where);
        } else {
            $this->db->where($where, false, false);
        }
        $res = $this->db->update($this->main_table, $data);
        $rs=  mysql_affected_rows();
        //echo $this->db->last_query();exit;
        return $res;
    }

    function getData($fields, $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like=array()) {
        
        if ($fields == '') {
           $fields = "*";
        }
 
        $this->db->start_cache();
    
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
         // echo $this->db->last_query();exit;
        $this->session->set_userdata(array('query'=>$this->db->last_query()));
        $this->db->flush_cache();
        //print_r($list_data);
        return $list_data;
    }
    
    function delete($id) {
        $this->db->where("iRoleId = ".$id);
        $this->db->delete('permission');
        
        $this->db->where("iRoleId = ".$id);
        $this->db->delete($this->main_table);
        return 'deleted';
    }
    
    function getuserdata($condition)
    {
         $this->db->where($condition);
        $this->db->from('user_tbl');
         return $this->db->get($table)->result_array();
        
    }
    
}
