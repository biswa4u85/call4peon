<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of systemsettings
 *
 * @author nilay
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SystemSettings extends CI_Model {

    protected $_settings_array = Array();

    public function __construct() {
        parent::__construct();
        $this->getSettingsFromDB();
        $this->getUserData();
        $this->getLanguageSettings();
    }

    private function getSettingsFromDB() {
        $result = $this->db->get('setting')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $this->_settings_array[$result[$i]['vName']] = $result[$i]['vValue'];
            $this->config->set_item($result[$i]['vName'], $result[$i]['vValue']);
        }
    }

    private function getUserData() {
        $userid = $this->session->userdata('iUserId');
        $dateFormat = $this->config->item('date_format');
//        echo $this->config->item('is_admin');exit;
        if (trim($userid) != '' && $this->config->item('is_admin') == 0) {
            $this->db->select('concat(user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as name,user_master.iCompanyId as company_id,user_master.eProfile as profile,user_master.vEmail as email,user_master.vProfileImage as profile_image,user_master.vTimeZone as time_zone, user_master.vDateFormat as date_format, user_master.iTimeFormat as time_format,user_master.iUserRoleId as role_id,role_master.vRole as role,user_master.iParentId as parent_id,company_master.iSuperAdminId as super_admin_id, company_master.vTimeZone as company_time_zone, company_master.vDateFormat as company_date_format, company_master.iTimeFormat as company_time_format, company_master.vCompanyName as company_name, company_master.vLogo as company_logo, company_master.iCountryId as company_country_id', false);
            $this->db->where('user_master.iUserId', $userid);
            $this->db->where('user_master.eStatus', 'Active');
            $this->db->join('role_master', 'user_master.iUserRoleId = role_master.iRoleId', 'left');
            $this->db->join('company_master', 'user_master.iCompanyId = company_master.iCompanyId', 'left');
            $result = $this->db->get('user_master')->result_array();
            //echo $this->db->last_query();exit;
            if (is_array($result) && count($result) > 0) {
                foreach ($result[0] as $key => $value) {
                    if ($key == 'date_format') {
                        $this->config->set_item(strtoupper('yt_user_' . $key), $value);
                        $value = array_search($value, $dateFormat);
                        $key = 'mysql_date_format';
                    }
                    if ($key == 'company_date_format') {
                        $this->config->set_item(strtoupper('yt_user_' . $key), $value);
                        $value = array_search($value, $dateFormat);
                        $key = 'mysql_company_date_format';
                    }
                    $this->config->set_item(strtoupper('yt_user_' . $key), $value);
                }
                $this->config->set_item(strtoupper('yt_user_rec_limit'), "5");
            }
        } else {
            $userid = $this->session->userdata('iAdminId');
            $this->db->select('vName as name,vEmail as email,vUserName,iRoleId as role_id', false);
            $this->db->where('admin.iAdminId', $userid);
            $this->db->where('admin.eStatus', 'Active');
            $result = $this->db->get('admin')->result_array();
            //echo $this->db->last_query();exit;
            if (is_array($result) && count($result) > 0) {
                foreach ($result[0] as $key => $value) {
                    $this->config->set_item(strtoupper('yt_admin_' . $key), $value);
                }
                $this->config->set_item(strtoupper('yt_user_rec_limit'), "5");
            }
        }
        
    }

    private function getLanguageSettings() {
        
    }

    public function getSettings($var_name) {

        if (array_key_exists($var_name, $this->_settings_array)) {
            return $this->_settings_array[$var_name];
        } else {
            return false;
        }
    }

    public function getAllSettings() {

        return $this->_settings_array;
    }

    function getSettingsMaster($eConfigType = "", $assoc_value = false, $fields = "") {
        if ($fields == '')
            $fields = '*';
        $this->db->select($fields);
        $this->db->from("setting");
        $this->db->where("setting.eStatus", "Active");
        if ($eConfigType != '') {
            $this->db->where("setting.eConfigType", $eConfigType);
        }
        $this->db->order_by("setting.iOrderBy, setting.eConfigType ASC");

        if ($assoc_value != false) {
            $sql = $this->db->_compile_select();
            $list_data = $this->db->select_assoc($sql, $assoc_value);
        } else {
            $list_data = $this->db->get()->result_array();
        }
        return $list_data;
    }

    function getQueryResult() {
        return $this->db->query($query);
    }

    function save_setting($updateArr, $field_name, $vValue) {
        $sess_setting = $this->session->userdata('sess_setting');
        $sql_update = "UPDATE setting SET " . @implode(", ", $updateArr) . " WHERE vName = '" . $field_name . "'";
        $db_update = $this->db->query($sql_update);
        return $db_update;
    }

}
