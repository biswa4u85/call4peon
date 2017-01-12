<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_page');
    }
    
    public function page_list() {
        $getvar = $this->input->get();
        if ($getvar['id'] != '' && $getvar['m'] != '') {
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            if ($mode == 'delete') {
                $iId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                if ($getvar['call'] == 'ajax') {
                    $res = 1;
                } else {
                    echo $res = $this->general->check_permission('del', 'page', 'ajax');
                }
                if ($res == 1) {
                    $upData['isDelete'] = 1;
                    $upData['dtModify'] = date("Y-m-d H:i:s");
                    $upWhere = 'iPageId = "' . $iId . '"';
                    $this->model_page->update($upData, $upWhere, 'page_settings');
                    $this->session->set_flashdata("success", "Vehicle deleted successfully");
                    redirect('pages');
                }
            }
        }
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('list', 'customers');
        }
        $data['sublist'] = 'notreq';
        $this->load->view('page_list', $data);
    }

    public function page_add() {

        $getVars = $this->input->get();
        $pageId = (isset($getVars['id']) && $getVars['id'] != '') ? $this->general->decryptData($getVars['id']) : '';
        $mode = (isset($getVars['m']) && $getVars['m'] != '') ? $this->general->decryptData($getVars['m']) : '';
        $data['mode'] = "Add";
        
        if ($pageId != '' && $mode = "edit") {
            $extCond = "iPageId = $pageId";
            $fields = "iPageId,vPageTitle,vPageCode,tContent,vUrl,eType,eStatus";
            $data['all'] = $this->model_page->getData('', $fields, $extCond);
            $data['mode'] = 'edit';
        }

        $this->load->view('page_add', $data);
    }

    public function page_add_action() {
        $postvar = $this->input->post();
        $submit = $postvar['submit'][0];
        $id = $postvar['iPageId'];  
        
        $mode = $postvar['mode'];
        $insertData['vPageTitle'] = (!empty($postvar['pagetitle'])) ? $postvar['pagetitle'] : "";
        $insertData['vPageCode'] = (!empty($postvar['pagecode'])) ? str_replace(' ', '_', strtoupper($postvar['pagecode'])) : "";
        if ($postvar['eType'] == 'Guide'){
            $insertData['tContent'] = (!empty($postvar['tContent'])) ? $postvar['tContent'] : "";
        } else {
            $insertData['tContent'] = (!empty($postvar['tContentCKe'])) ? $postvar['tContentCKe'] : "";
        }
        $insertData['eType'] = (!empty($postvar['eType'])) ? $postvar['eType'] : "";
        $insertData['eStatus'] = (!empty($postvar['status'])) ? $postvar['status'] : "";

        if ($id != '' && $mode == 'edit') {
            $ext_cond = "iPageId=" . $id;
            $insertData['dtModify'] = date('Y-m-d H:i:s');
            $this->model_page->update($insertData, $ext_cond);
            $rply = $id;
            $this->session->set_flashdata("success", "page updated successfully");
        } else {
            $insertData['dtCreated'] = date('Y-m-d H:i:s');
            $insertData['dtModify'] = date('Y-m-d H:i:s');
            $insertData['isDelete'] = 0;
            $rply = $this->model_page->insert($insertData);
            $this->session->set_flashdata("success", "page added successfully");
        }

        if ($rply) {
            //$this->uploadImages($rply);
        }
        if ($submit == "savenew")
            redirect('page_add');
        else
            redirect('pages');
        exit;
    }

    private function uploadImages($iPageId) {
        
        $temp_folder_path = $this->config->item('upload_path') . 'pages/' . $iPageId . '/';
        $this->general->createfolder($temp_folder_path);
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            $file_name = $iPageId . '_' . date('YmdHis') . "_" . $i . "." . pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['images']['tmp_name'][$i], $temp_folder_path . $file_name);
            $file_data['vUrl'] = $file_name;
            //$this->model_page->insert($file_data);
        }
    }

    public function deleteImage() {
        $postVars = $this->input->post();
        $imageId = (isset($postVars['file'])) ? $postVars['file'] : 0;
        if ($imageId > 0) {
            $this->model_vehicle->delete("iImageId=$imageId", 'vehicle_images');
        }
    }

}
