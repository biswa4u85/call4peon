<?php

class Model_vehicle extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "vehicle_master";
        $this->primary_key = "iVehicleId";
    }

    function insert($data = array(), $tbl = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->insert($tbl);
        $insert_id = $this->db->insert_id();
        //pr($insert_id);
        //echo $this->db->last_query();exit;
        return $insert_id;
    }

    function update($data = array(), $where = '', $tbl = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->where($where, false, false);
        $res = $this->db->update($tbl, $data);
        $rs = $this->db->affected_rows();
        //echo $this->db->last_query();exit;
        return $res;
    }

    function getData($tbl = '', $fields, $condition = '', $join_ary = array(), $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        $this->db->start_cache();

        if (trim($fields) != '') {
            $this->db->select($fields);
        }

        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        if (trim($groupby) != '') {
            $this->db->group_by($groupby);
        }
        if (is_array($join_ary) && count($join_ary) > 0) {
            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
        }
        if (trim($having) != '') {
            $this->db->having($having);
        }
        if ($orderby != '' && is_array($paging_array) && count($paging_array) == "0") {
            $this->db->order_by($orderby);
        }
        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }

        $this->db->stop_cache();
        $list_data = $this->db->get()->result_array();
//        echo $this->db->last_query();exit;
        $this->session->set_userdata(array('query' => $this->db->last_query()));
        $this->db->flush_cache();
        print_r($list_data);
        return $list_data;
    }

    function delete($where = '', $tbl) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where, FALSE, FALSE);
        $this->db->delete($tbl);
        return 'deleted';
    }

}
