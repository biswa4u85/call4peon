<?php

class Model_support extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "user_master";
        $this->primary_key = "iUserId";
    }

    public function authenticate($email, $password) {

        $ext = 'vPassword = "' . $password . '" AND vEmail = "' . $email . '"';

        $this->db->select('iUserId as user_id,vName as name,vEmail as email,eStatus as status');
        $this->db->from($this->main_table);
        $this->db->where($ext);
        $record = $this->db->get()->result_array();

        if (is_array($record) && count($record) > 0) {

            if ($record[0]['eStatus'] == 'Inactive') {
                $record[0]['code'] = "421";
                $record[0]['message'] = 'Your Account is still Inactive please contact Administrator.';
                return $record;
            } else {
                $datalog['iUserId'] = $record[0]['user_id'];
                $datalog['vSessionId'] = $this->general->encryptData($email . "user" . date('Y-m-d h:i:s'));
                $datalog['eUserType'] = ucfirst("user");
                $datalog['eLoginType'] = "Mobile";
                $datalog['dLoginDate'] = date('Y-m-d H:i:s');
                $this->load->model('tools/loghistory');
                $this->loghistory->insert($datalog);
                $record[0]['session_id'] = $datalog['vSessionId'];
                return $record;
            }
        } else {
            $record[0]['code'] = "401";
            $record[0]['message'] = 'Email or Password is incorrect.';
            return $record;
        }
    }

    function insert($tbl = '', $data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->insert($tbl, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($tbl = '', $data = array(), $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
//        foreach ($data as $key => $value) {
//            $this->db->set($key, $value, false);    
//        }
        $this->db->where($where, false, false);
        $res = $this->db->update($tbl, $data);
//        $rs = mysql_affected_rows();
        //echo $this->db->last_query();
        return $res;
    }

    function getData($tbl = '', $fields, $condition = '', $join_ary = array(), $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        //$this->db->start_cache();
        $this->db->select($fields, FALSE);

        if (is_array($join_ary) && count($join_ary) > 0) {
            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
        }

        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        if (trim($groupby) != '') {
            $this->db->group_by($groupby);
        }
        if (trim($having) != '') {
            $this->db->having($having, FALSE);
        }
        if ($orderby != '' && is_array($paging_array) && count($paging_array) == "0") {
            $this->db->order_by($orderby, FALSE);
        }
        if (trim($climit) != '') {
            $this->pagination_limit($climit);
        }
        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }

        //$this->db->stop_cache();
        $list_data = $this->db->get()->result_array();
        //
//        echo $this->db->last_query();exit;
        //$this->session->set_userdata(array('query' => $this->db->last_query()));
        //$this->db->flush_cache();
        //print_r($list_data);
        return $list_data;
    }

    function delete($tbl = '', $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where);
        $this->db->delete($tbl);
        return 'deleted';
    }

    function getCountryList($id = '') {
        $this->db->select('iCountryId as countryId,vCountry as countryName');
        $this->db->where("isDelete != ", "1");
        $this->db->where("eStatus", "Active");
        if ($id > 0) {
            $this->db->where("iCountryId", "$id");
        }
        $this->db->from("country");
        $country_data = $this->db->get()->result_array();
        return $country_data;
    }

    function session_check($session_id) {
        $ext = 'vSessionId = "' . $session_id . '" and ISNULL(dLogoutDate)';
        $this->db->select('count(*) as tot', false);
        $this->db->where($ext);
        $result = $this->db->get('log_history');
        $record = $result->result_array();
        $res = $record[0]['tot'];
        return $res;
    }

    public function logout($session_id, $user_id, $type = '') {
//        $this->db->set('vDeviceToken', '');
//        $this->db->where('iUserId', $user_id);
//        $this->db->update('user_master');

        $this->db->set('dLogoutDate', date('Y-m-d H:i:s'));
        $this->db->where('iUserId', $user_id);
        $this->db->where('eUserType', $type);
        $this->db->where('vSessionId', $session_id);
        $id = $this->db->update('log_history');

        return $id;
    }

    public function pagination_limit($page = '', $recLimit = 0) {
        $limit = ($recLimit != '' && $recLimit != 0) ? $recLimit : $this->config->item('WS_PAGE_LIMIT');
        if (is_numeric($page) && $page > 1) {
            $start = (($page - 1) * $limit);
            $this->db->limit($limit, $start);
        } else {
            $this->db->limit($limit);
        }
    }

    public function record_count($pageno = 1, $recLimit = 0) {
        //echo $lastquery = $this->db->last_query();exit;
        $lastquery = $this->db->last_query();
        if (strpos($lastquery, "LIMIT") !== false) {
            $new_query = substr($lastquery, 0, strrpos($lastquery, 'LIMIT'));
        } else {
            $new_query = $lastquery;
        }
        $new_result = $this->db->query($new_query)->result_array();

        if (count($new_result) > 0) {
            $limitrec = count($new_result);
        } else {
            $limitrec = 0;
        }
        $limit = ($recLimit != '' && $recLimit != 0) ? $recLimit : $this->config->item('WS_PAGE_LIMIT');
        $pageno = ($pageno != '' && $pageno > 0) ? $pageno : 1;

        return (($limitrec - ($pageno * $limit)) > 0) ? 'true' : 'false';
        //return $limitrec;
    }

}
