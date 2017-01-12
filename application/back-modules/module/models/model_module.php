<?php

class Model_module extends CI_Model {

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

        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->insert($this->main_table);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($data = array(), $where = '') {
        $this->db->where($where);
        $res = $this->db->update($this->main_table, $data);
//        echo $this->db->last_query();exit;   

        $rs = mysqli_affected_rows();
        return $rs;
    }

    function getData($fields = '', $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        $this->db->start_cache();
        $this->db->select($fields, FALSE);

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
        $this->session->set_userdata(array('query' => $this->db->last_query()));
        $this->db->flush_cache();
        //print_r($list_data);
        //$this->db->last_query();exit;
        return $list_data;
    }

    function delete($where = '') {
        $this->db->where($where);
        $this->db->delete($this->main_table);
        //  echo $this->db->last_query();exit;
        return 'deleted';
    }

    function get_data($tbl = '', $fields = '', $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        $this->db->start_cache();
        $this->db->select($fields, FALSE);

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

        $this->db->from($tbl);
        $this->db->stop_cache();
        $list_data = $this->db->get()->result_array();
        $this->session->set_userdata(array('query' => $this->db->last_query()));
        $this->db->flush_cache();
        //print_r($list_data);
        //$this->db->last_query();exit;
        return $list_data;
    }

    function insert_data($tbl = '', $data = array()) {

        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }
        $this->db->insert($tbl);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update_data($tbl='',$data = array(), $where = '') {
        $this->db->where($where);
        $res = $this->db->update($tbl, $data);
//        echo $this->db->last_query();exit;   

        $rs = mysqli_affected_rows();
        return $rs;
    }

}
