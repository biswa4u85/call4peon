<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('user/model_user');
        $this->load->model('model_vehicle');
    }
    
    public function vehicles() {
        $getvar = $this->input->get();
        if ($getvar['id'] != '' && $getvar['m'] != '') {
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            if ($mode == 'delete') {
                $iId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                if ($getvar['call'] == 'ajax') {
                    $res = 1;
                } else {
                    echo $res = $this->general->check_permission('del', 'vehicles', 'ajax');
                }
                if ($res == 1) {
                    $upData['iIsDeleted'] = 1;
                    $upData['dtUpdatedDate'] = date("Y-m-d H:i:s");
                    $upWhere = 'iVehicleId = "' . $iId . '"';
                    $this->model_vehicle->update($upData, $upWhere, 'vehicle_master');
                    $this->session->set_flashdata("success", "Vehicle deleted successfully");
                    redirect('vehicles');
                }
            }
        }
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('list', 'customers');
        }
        $data['sublist'] = 'notreq';
        $this->load->view('vehicle_list', $data);
    }

    public function vehicle_add() {

        $getVars = $this->input->get();
        $vehicleId = (isset($getVars['id']) && $getVars['id'] != '') ? $this->general->decryptData($getVars['id']) : '';
        $mode = (isset($getVars['m']) && $getVars['m'] != '') ? $this->general->decryptData($getVars['m']) : '';
        $data['mode'] = "Add";

        $data['users'] = $this->model_user->getData('', 'iUserId,vFirstName,tAddress', 'iIsDeleted != 1 and eStatus = "Active"');
        if ($vehicleId != '' && $mode = "edit") {
            $extCond = "iVehicleId = $vehicleId";
            $fields = "iVehicleId,iUserId,iVehicleTypeId,vNumber,tStandingPoint,vehicle_master.eStatus";
//            $joinArray = array(array('table' => 'vehicle_type_master','condition' => 'vehicle_type_master.iVehicleTypeId = vehicle_master.iVehicleTypeId'));
            $data['all'] = $this->model_vehicle->getData('', $fields, $extCond);
            $data['vehicleTypes'] = $this->model_vehicle->getData('vehicle_type_master', 'iVehicleTypeId,vType','eStatus = "Active"');
            
            $data['images'] = $this->model_vehicle->getData('vehicle_images', 'iImageId,vName', "iVehicleId=$vehicleId");
            $data['mode'] = 'edit';
        }

        $this->load->view('vehicle_add', $data);
    }

    public function vehicle_add_action() {
        $postvar = $this->input->post();
        $submit = $postvar['submit'][0];
        $id = $postvar['iVehicleId'];
        $mode = $postvar['mode'];
        $insertData['iUserId'] = (!empty($postvar['user'])) ? $postvar['user'] : "";
        $insertData['vType'] = (!empty($postvar['type'])) ? $postvar['type'] : "";
        $insertData['vNumber'] = (!empty($postvar['number'])) ? $postvar['number'] : "";
        $insertData['tStandingPoint'] = (!empty($postvar['standingPoint'])) ? $postvar['standingPoint'] : "";
        $location = $this->general->getLatLngFromAddress($insertData['tStandingPoint']);
        $insertData['vLatitude'] = $location['lat'];
        $insertData['vLongitude'] = $location['long'];
        $insertData['eStatus'] = (!empty($postvar['status'])) ? $postvar['status'] : "";

        if ($id != '' && $mode == 'edit') {
            $ext_cond = "iVehicleId=" . $id;
            $insertData['dtUpdatedDate'] = date('Y-m-d H:i:s');
            $this->model_vehicle->update($insertData, $ext_cond);
            $rply = $id;
            $this->session->set_flashdata("success", "Vehicle updated successfully");
        } else {
            $insertData['dtCreatedDate'] = date('Y-m-d H:i:s');
            $insertData['dtUpdatedDate'] = date('Y-m-d H:i:s');
            $insertData['iIsDeleted'] = 0;
            $rply = $this->model_vehicle->insert($insertData);
            $this->session->set_flashdata("success", "Vehicle added successfully");
        }

        if ($rply) {
            $this->uploadImages($rply);
        }
        if ($submit == "savenew")
            redirect('vehicle-add');
        else
            redirect('vehicles');
        exit;
    }

    private function uploadImages($vehicleId) {
        $temp_folder_path = $this->config->item('upload_path') . 'vehicles/' . $vehicleId . '/';
        $this->general->createfolder($temp_folder_path);
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            $file_name = $vehicleId . '_' . date('YmdHis') . "_" . $i . "." . pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['images']['tmp_name'][$i], $temp_folder_path . $file_name);
            $file_data['iVehicleId'] = $vehicleId;
            $file_data['vName'] = $file_name;
            $file_data['dtCreated'] = date('Y-m-d H:i:s');
            $this->model_vehicle->insert($file_data, 'vehicle_images');
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
