<?php

class Model_admin extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "admin";
        $this->primary_key = "iAdminId";
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
//        echo $res;exit;
//        $rs = mysqli_affected_rows();
        return $res;
    }

    function getData($fields = '', $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        if (trim($fields) != '') {
            $this->db->select($fields, FALSE);
        }
        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
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
        if (is_array($climit)) {
            list($offset, $limit) = $climit;
            $this->db->limit($limit, $offset);
        } else if (trim($climit) != '') {
            $this->db->limit($climit);
        }

//        if ($tbl != '') {
//            $this->db->from($tbl);
//        } else {
//            $this->db->from($this->main_table);
//        }
        $this->db->from($this->main_table);
        $list_data = $this->db->get()->result_array();


        //print_r($list_data);
//        echo $this->db->last_query();
        return $list_data;
    }

    function delete($where = '') {
        $this->db->where($where);
        $this->db->delete($this->main_table);
        //  echo $this->db->last_query();exit;
        return 'deleted';
    }

    public function authenticate($vUserName, $uPwd) {

        $ext = 'vPassword = "' . $uPwd . '" AND (vUserName = "' . $vUserName . '" OR vEmail = "' . $vUserName . '")';
        $this->db->select('iAdminId,vName,vEmail,vUserName,vPassword,vImage,iRoleId,eStatus');
        $this->db->from($this->main_table);
        $this->db->where($ext);
        $result = $this->db->get();
        $record = $result->result_array();
        if (is_array($record) && count($record) > 0) {
            if ($record[0]['eStatus'] == 'Inactive') {
                $this->errorCode = 2;
                $this->errorMessage = 'Your account has been not activated, Contact to administrator.';
            } else {
                $this->_id = $record[0]["iAdminId"];
                //  $record->role = "owner";
                $this->session->set_userdata("iAdminId", $record[0]["iAdminId"]);
                $this->session->set_userdata("vName", $record[0]["vUserName"]);
                $this->session->set_userdata("vEmail", $record[0]["vEmail"]);
                $this->session->set_userdata("iRoleId", $record[0]["iRoleId"]);
                $this->session->set_userdata("vImage", $record[0]["vImage"]);
                $sessionLoginData['iAdminId'] = $record[0]['iAdminId'];
                $sessionLoginData['dtLoginDate'] = date('Y-m-d H:i:s');
                $this->session->set_userdata("iLogId", $iLogId);
                $this->errorCode = 1;
                $error['role'] = $record[0]['iRoleId'];
            }
        } else {
            $this->errorCode = 0;
            $this->errorMessage = 'Email or Password are not correct.';
        }

        $error['errorCode'] = $this->errorCode;
        $error['errorMessage'] = $this->errorMessage;

        return $error;
    }

    function getForgotPassword($vemail) {
        $ext = '(vUserName = "' . $vemail . '" OR vEmail = "' . $vemail . '")';
        $this->db->select('*');
        $this->db->from($this->main_table);
        $this->db->where($ext);
        $result = $this->db->get();
        $record = $result->result_array();
        // pr($record);
        //echo $this->db->last_query();exit;
        return $record;
    }

    function getUserValidation($usertype = '', $value = '', $tbl = '', $ext_con = '') {
        if ($value != '') {
            $this->db->select($usertype);
            if ($tbl != '') {
                $this->db->from($tbl);
            } else {
                $this->db->from($this->main_table);
            }
            if ($id != '') {
                $this->db->where($ext_con);
            }
            $this->db->where($ext_con);
            $user_data = $this->db->get()->result_array();
            if (is_array($user_data) && count($user_data) > 0) {
                return "false";
            } else {
                return "true";
            }
        } else {
            return "false";
        }
    }

    function getCountryDetail($id = '') {
        $this->db->select('iCountryId,vCountry');
        if ($id != '') {
            $this->db->where('Country_Id', $id);
        }
        $array = $this->db->get('country')->result_array();
        return $array;
    }

    function getModule($where = '') {
        $this->db->select('*');
        if ($where != '') {
            $this->db->where('iModuleId', $where);
        }
        $array = $this->db->get('module_master')->result_array();
        return $array;
    }

    function updateData($table, $data = array(), $where = '') {
        $this->db->where($where);
        $res = $this->db->update($table, $data);
        //echo $this->db->last_query();exit;  
        $rs = $this->db->affected_rows();
        return $rs;
    }

    function deleteData($table, $where = '') {
        $this->db->where($where);
        $this->db->delete($table);
        //  echo $this->db->last_query();exit;
        return true;
    }

    function get_data($fields = '', $tbl = '', $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

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

        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }

        $this->db->stop_cache();
        $list_data = $this->db->get()->result_array();
        $this->session->set_userdata(array('query' => $this->db->last_query()));
        $this->db->flush_cache();
        //print_r($list_data);
        //$this->db->last_query();exit;
        return $list_data;
    }

    public function system_setting($eConfigType) {
        $this->db->select('*');
        $this->db->from('setting');
        $this->db->where("eConfigType", $eConfigType);
        $this->db->where("eStatus", 'Active');
        $this->db->order_by("iOrderBy", 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function update_system_setting($key, $value) {
        $this->db->set('vValue', $value);
        $this->db->where('vName', $key);
        $res = $this->db->update('setting');
//        echo $this->db->last_query();exit;
//        $rs = mysql_affected_rows();
        return true;
    }

}
