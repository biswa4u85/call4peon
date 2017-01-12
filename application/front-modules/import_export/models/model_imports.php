<?php

class Model_imports extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "vendor_master";
        $this->primary_key = "iVendorId";
    }

    function insert($data = array()) {
        $this->db->insert($this->main_table, $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($data = array(), $where = '') {
        $this->db->where($where);
        $res = $this->db->update($this->main_table, $data);
        $rs = mysqli_affected_rows();
        return $rs;
    }

    function getData($fields = '', $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {


        if ($fields == '') {
            $fields = "*";
        }

        if (trim($fields) != '') {
            $this->db->select($fields, false);
        }

        if (trim($condition) != '') {
            $this->db->where($condition);
        }
        if (is_array($join_ary) && count($join_ary) > 0) {

            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
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
        $list_data = $this->db->get()->result_array();
//        echo $this->db->last_query();exit;
        return $list_data;
    }

    function delete($where = '') {
        $this->db->where($where);
        $this->db->delete($this->main_table);
//          echo $this->db->last_query();exit;
        return 'deleted';
    }

    function query($sql) {

        $data = $this->db->query($sql)->result_array();
//        echo $this->db->last_query();exit;
        return $data;
    }

    function getContactsValue($id) {
        $query = "SELECT iContactId, eStatus, vFirstName, vLastName, vEmail FROM contact_book WHERE iCompanyId = '$id' AND isLead = 'Yes'";
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    function getContactGroup($id = '') {
        $this->db->select('iContactGroupId,vGroup');
        $this->db->from('contact_groups');
        if ($id != '') {
            $this->db->where('iCompanyId', $id);
        }
        $data = $this->db->get()->result_array();
        return $data;
    }
    
    public function getUserValidation($usertype = '', $value = '', $cond = '') {
        if ($usertype != '' && $value != '') {
            $this->db->select($usertype);
            $this->db->from($this->main_table);
            if($cond != ''){
                $this->db->where($cond);
            }
            
            if (is_array($usertype)) {
                foreach ($usertype as $key => $type_value) {
                    $this->db->where($type_value, $value[$key]);
                }
            } else {
                $this->db->where($usertype, $value);
            }
            
            $user_data = $this->db->get()->result_array();
//            echo $this->db->last_query();exit; 
            if (is_array($user_data) && count($user_data) > 0) {
                echo "false";
            } else {
                echo "true";
            }
        } else {
            echo "false";
        }
    }
    
    
    function getCustomFields($id = '') {
        $this->db->select('*');
        $this->db->from('custom_fields');
        if ($id != '') {
            $this->db->where('iTypeId', $id);
            $this->db->where('eType', "Vendor");
            $this->db->where('eStatus', "Active");
        }
        $data = $this->db->get()->result_array();
        //echo $this->db->last_query();exit;
        return $data;
    }

    function checkEmail($email = '', $phone = '') {
        $id = $this->session->userdata('iCompanyId');
        $query = "SELECT contact_book.iContactId FROM contact_book_fields JOIN contact_book ON contact_book.iContactId = contact_book_fields.iContactId WHERE contact_book.iCompanyId = '$id' AND ((contact_book_fields.vField = 'Email' AND contact_book_fields.vValue in ($email)) or contact_book.vEmail in ($email)) OR ((contact_book_fields.vField = 'Phone' AND contact_book_fields.vValue in ($phone)))";
        $result = $this->db->query($query)->result_array();
        //echo $this->db->last_query();exit;
        if (count($result) > 0) {
            $result[0]['tot'] = count($result);
        } else {
            $result[0]['tot'] = 0;
        }
        return $result;
    }

    function getMasterGroup() {
        $this->db->select('iGroupId,vGroup');
        $result = $this->db->get('group_master')->result_array();
        return $result;
    }

    function insert_contact_field($contactid, $field, $value, $type, $order) {
        $dataa['iContactId'] = $contactid;
        $dataa['vContactType'] = $type;
        $dataa['iOrder'] = $order;
        $dataa['vField'] = $field;
        $dataa['vValue'] = $value;
        $dataa['dtAddedDate'] = date('Y-m-d H:i:s');
        $dataa['dtModifiedDate'] = date('Y-m-d H:i:s');
        $this->db->insert('contact_book_fields', $dataa);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getTotalContacts() {
        $id = $this->session->userdata('iCompanyId');
        $query = "SELECT COUNT(*) as tot FROM " . $this->main_table . " WHERE iCompanyId = '$id'";
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    function mail_count_data($iContactId, $id, $field, $fieldValue) {
        $this->db->select("COUNT(*) as tot");
        $this->db->from('sent_campaign_list');
        $this->db->where($iContactId, $id);
        $this->db->where($field, $fieldValue);
        $result = $this->db->get()->result_array();
        return $result[0]['tot'];
    }

    function contacts_preview($id = '') {
        $where = array('iContactId' => $id, 'isLead' => 'Yes');
        $this->db->select("*,(select vCampaignName from user_email_campaign where iUserCampaignId = sent_campaign_list.iUserCampaignId) as vCampaignName,(select CONCAT(vFirstName,' ',vLastName) from contact_book where contact_book.iContactId = '" . $id . "' )as contactname", false);
        $this->db->from('sent_campaign_list');
        if ($id != '') {
            $this->db->where($where);
        }
        $data = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $data;
    }

    function insertContactField($data = array()) {
        $this->db->insert('contact_book_fields', $data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function delete_vendors($data,$cond){
        $this->db->where($cond);
        $res = $this->db->update($this->main_table, $data);
        return $res;
    }

}
