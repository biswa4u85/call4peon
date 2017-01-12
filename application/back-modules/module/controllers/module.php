<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Module extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // $dat=array();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->general->checkSession();

        $this->load->model('model_module');
    }

    public function modules() {
        $getvar = $this->input->get();
//        pr($getvar);exit;
        if ($getvar['id'] != '' && $getvar['m'] != '') {
            //delete
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            if ($mode == 'delete') {
                $iModuleId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                $ext_cond = "iModuleId =" . $iModuleId;
                $update['isDelete'] = "1";
                $update['iDeleteBy'] = $this->session->userdata('iAdminId');
                $this->model_module->update($update, $ext_cond);
                $this->session->set_flashdata("success", "Data deleted successfully");
                redirect('modules');
            }
        }
        $data['sublist'] = "notreq";

        $this->load->view('modules_list', $data);
    }

    public function module_add() {
        $getvar = $this->input->get();
        $postvar = $this->input->post();

        $ext_cond_parent = "isDelete = 0";
        $menutype = $this->general->getEnumValues("module_master", "eMenuType");
        $relate = $this->general->getEnumValues("module_master", "eRelatedTo");
        $status = $this->general->getEnumValues("module_master", "eStatus");
        $parents = $this->model_module->getData("iModuleId,vModule", array(), $ext_cond_parent);
        $flaguserId = urldecode($this->general->decryptData($getvar['id']));
        if ($getvar != '') {
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            $fields = "*";
            $ext_cond = 'iModuleId ="' . $flaguserId . '"';
            $reply = $this->model_module->getData($fields, array(), $ext_cond);
            $data['all'] = $reply;
            if (isset($getvar['p']) && $getvar['p'] != '' && $this->general->decryptData($getvar['p']) == "view") {
                $frompage = "view";
            }
            if ($reply[0]['vRefTable'] != '') {
                $crated_by = $this->session->userdata("iAdminId");
                $col = $this->db->query("call module_customization('" . $flaguserId . "','" . $reply[0]['eRelatedTo'] . "','" . $reply[0]['vRefTable'] . "','" . $crated_by . "')")->result_array();
                $this->db->close();
                $this->db->initialize();
            }
        } else {
            $mode = "add";
        }
        $data['col'] = $col;
        $data['relate'] = $relate;
        $data['status'] = $status;
        $data['mode'] = $mode;
        $data['menutype'] = $menutype;
        $data['parents'] = $parents;

        $this->load->view('module_add', $data);
    }

    public function module_action() {
        $postvar = $this->input->post();
        $submit = $postvar['submit'][0];
        $id = $postvar['iModuleId'];
        $mode = $postvar['mode'];
        unset($postvar['iModuleId']);
        unset($postvar['submit']);
        unset($postvar['mode']);
        if ($id != '' && $mode == 'edit') {
            $ext_cond = "iModuleId =" . $id;
            $postvar['iModifyBy'] = $this->session->userdata('iAdminId');
            $postvar['dtModify'] = date('Y-m-d H:i:s');
            $rply = $this->model_module->update($postvar, $ext_cond);
            
            
            if($postvar['eMenuType'] == 'Back'){
                $whr = 'iRoleId = 1 and  iModuleId= "'.$id.'"';
                $adminuser = $this->model_module->get_data('permission','*',array(),$whr);
                $prm['iRoleId'] = 1;
                $prm['iModuleId'] = $id;
                $prm['isRead'] = $prm['isWrite'] = $prm['isDelete'] = 1;
                if(count($adminuser) > 0){
                    $this->model_module->update_data('permission',$prm,'iPermissionId = "'.$adminuser[0]['iPermissionId'].'"');
                }else{
                    $this->model_module->insert_data('permission',$prm);
                }
            }
            if ($postvar['vRefTable'] != '') {
                $redirectUrl = 'module_add?id=' . urlencode($this->general->encryptData($id)) . '&m=' . $this->general->encryptData('edit');
                redirect($redirectUrl);
            }
        } else {
            $postvar['iCreatedBy'] = $this->session->userdata('iAdminId');
            $postvar['dtCreated'] = date('Y-m-d H:i:s');
            $postvar['iModifyBy'] = $this->session->userdata('iAdminId');
            $postvar['dtModify'] = date('Y-m-d H:i:s');
            $postvar['isDelete'] = 0;
            $id = $this->model_module->insert($postvar);
            
            if($postvar['eMenuType'] == 'Back'){
                $prm['iRoleId'] = 1;
                $prm['iModuleId'] = $id;
                $prm['isRead'] = $prm['isWrite'] = $prm['isDelete'] = 1;
                $this->model_module->insert_data('permission',$prm);
            }
            
        }
        if ($submit == "savenew")
            redirect('module_add');
        else
            redirect('modules');

        exit;
    }

    public function section_add() {
        $getvar = $this->input->get();
        if ($getvar['secid'] != '') {
            $secfield = "iSectionId,vSectionName,iModuleId,eColumnLayoutType,vIcon,isChangable,iSequenceOrder";
            $sec_ext_cond = "iSectionId =" . $getvar['secid'];
            $secrply = $this->model_module->get_data("section_master", $secfield, array(), $sec_ext_cond);
        }
        $field = "count(iModuleId) as total";
        $ext_cond = "iModuleId =" . $getvar['secmodid'];
        $rply = $this->model_module->get_data("section_master", $field, array(), $ext_cond);
        $coltype = $this->general->getEnumValues("section_master", "eColumnLayoutType");
        $data['coltype'] = $coltype;
        $data['total'] = $rply[0]['total'];
        $data['secmodid'] = $getvar['secmodid'];
        $data['all'] = $secrply;
        $this->load->view('section_add', $data);
    }

    public function section_add_action() {
        $postvar = $this->input->post();
        parse_str($postvar['value'], $val);
        $secid = $val['isectionid'];
        if ($secid != '') {
            $update['vSectionName'] = $val['vSectionName'];
            $update['eColumnLayoutType'] = $val['eColumnLayoutType'];
            $update['vIcon'] = $val['vIcon'];
            $update['isChangable'] = $val['isChangable'];
            $update['iModifyBy'] = $this->session->userdata('iAdminId');
            $update['dtModify'] = date('Y-m-d H:i:s');
            $ext_cond = "iSectionId =" . $secid;
            $this->model_module->update_data("section_master", $update, $ext_cond);
        } else {
            $insert['iModuleId'] = $val['secmodid'];
            $insert['vSectionName'] = $val['vSectionName'];
            $insert['eColumnLayoutType'] = $val['eColumnLayoutType'];
            $insert['vIcon'] = $val['vIcon'];
            $insert['isChangable'] = $val['isChangable'];
            $insert['iSequenceOrder'] = $postvar['scecount'] + 1;
            $insert['iCreatedBy'] = $this->session->userdata('iAdminId');
            $insert['dtCreated'] = date('Y-m-d H:i:s');
            $insert['eStatus'] = "Active";
            $this->model_module->insert_data("section_master", $insert);
        }
    }

    public function getPageLayout() {
        $postvar = $this->input->post();
        $field = "iSectionId,vSectionName,iModuleId,eColumnLayoutType,vIcon,isChangable,iSequenceOrder";
        $ext_cond = "iModuleId =" . $postvar['module'] . " and isDelete!='1' order by iSequenceOrder asc";
        $rply = $this->model_module->get_data("section_master", $field, array(), $ext_cond);
        $data['msection'] = $rply;
        $this->load->view('module_pagelayout', $data);
    }

    function changeSectionOrder() {
        $postdata = $this->input->post();
        $divPosition = $postdata['positions'];
        $divArray = explode("|", $divPosition);
//        pr($postdata['positions']);exit;
        foreach ($divArray as $key => $value) {
            $order_id = $key + 1;
            $postvar['iSequenceOrder'] = $order_id;
            $postvar['iModifyBy'] = $this->session->userdata('iUserId');
            $postvar['dtModify'] = date('Y-m-d H:i:s');
            $ext_cond = 'iSectionId = "' . $value . '"';
            $this->model_module->update_data('section_master', $postvar, $ext_cond);
        }
    }

    function changeOrder() {
        $postdata = $this->input->post();
        $divPosition = $postdata['positions'];
        //$divPosition = $_COOKIE['positions'];
        $divArray = explode("|", $divPosition);
        $sectionIdArray = array();
        $sectionIdArray1 = array();
//        pr($divPosition);exit;
        //$same = 0;
        foreach ($divArray as $key => $value) {
            $divArr = explode(",", $value);
            $sectionId = $divArr[0];
            $fieldCustomizationId = $divArr[1];
            $sectionColumn = $divArr[2];

            $divArr1 = explode(",", $divArray[$key - 1]);
            $sectionId1 = $divArr1[0];

            if ($sectionId == $sectionId1) {
                if (!in_array($sectionId, $sectionIdArray)) {
                    $sectionIdArray[] = $sectionId;
                    $same = 1;
                }
                $same++;
                $fieldOrder = $same;
            } else {

                if (!in_array($sectionId, $sectionIdArray1)) {
                    $sectionIdArray1[] = $sectionId;
                    $diff = 1;
                }

                $fieldOrder = $diff;
                $diff++;
            }

            if ($sectionId == '0') {
                $postvar['isRemove'] = '1';
                $postvar['isVisible'] = '0';
                $postvar['iSectionId'] = $sectionId;
                $postvar['iSectionColumn'] = $sectionColumn;
            } else {
                $postvar['iSectionId'] = $sectionId;
                $postvar['iSectionColumn'] = $sectionColumn;
                $postvar['isRemove'] = '0';
                $postvar['isVisible'] = '1';
            }

            $postvar['iSequenceOrder'] = $fieldOrder;
            $postvar['iModifyBy'] = $this->session->userdata('iAdminId');
            $postvar['dtModify'] = date('Y-m-d H:i:s');
            $ext_cond = 'iModuleSettingsId = "' . $fieldCustomizationId . '"';
            $this->model_module->update_data('module_settings_master', $postvar, $ext_cond);
        }
    }

    function field_settings() {
        $gettvar = $this->input->get();
        $fields = "*";
        $ext_cond = 'iModuleSettingsId = "' . $gettvar['modulesettingsid'] . '"';
        $rply = $this->model_module->get_data('module_settings_master', $fields, array(), $ext_cond);
        $ext_cond_sec = "iModuleId =" . $gettvar['moduleid'];
        $sectype = $this->model_module->get_data('section_master', "vSectionName,iSectionId", array(), $ext_cond_sec);
        $data['sectype'] = $sectype;
        $data['all'] = $rply;

        $mode = "edit";
        $type = $this->general->getEnumValues("module_settings_master", "eType");
        $data['type'] = $type;
        $data['mode'] = $mode;
        $this->load->view("field_settings", $data);
    }

    function field_settings_action() {
        $postvar = $this->input->post();
        parse_str($postvar['value'], $val);

        $iModuleSettingsId = $val['iModuleSettingsId'];
        $update['iSectionId'] = $val['iSectionId'];
        $update['vLabel'] = $val['vLabel'];
        $update['eType'] = $val['eType'];
        $update['isChangable'] = $val['isChangable'];
        $update['isMandatory'] = $val['isMandatory'];
        $update['isVisible'] = $val['isVisible'];
        $update['isLocked'] = $val['isLocked'];
        $update['iModifyBy'] = $this->session->userdata('iAdminId');
        $update['dtModify'] = date('Y-m-d H:i:s');
        $ext_cond = "iModuleSettingsId =" . $iModuleSettingsId;
        $this->model_module->update_data("module_settings_master", $update, $ext_cond);
    }

    function getTotalColumn() {
        $postvar = $this->input->post();
        $fields = "vModule,vRefTable";
        $ext_cond = 'iModuleId ="' . $postvar['module'] . '"';
        $reply = $this->model_module->getData($fields, array(), $ext_cond);
        $crated_by = $this->session->userdata("iAdminId");
        $col = $this->db->query("call module_customization('" . $postvar['module'] . "','" . $reply[0]['eRelatedTo'] . "','" . $reply[0]['vRefTable'] . "','" . $crated_by . "')")->result_array();
        $data['col'] = $col;
        $this->load->view("module_total_column", $data);
    }

}
