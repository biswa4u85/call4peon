<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_user');
    }

    public function users() {
        $getvar = $this->input->get();
        $postvar = $this->input->post();

        if ($getvar['id'] != '' && $getvar['m'] != '') {
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            if ($mode == 'delete') {
                $iId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                if ($getvar['call'] == 'ajax') {
                    $res = 1;
                } else {
                    echo $res = $this->general->check_permission('del', 'customers', 'ajax');
                }
                if ($res == 1) {
                    $upData['iIsDeleted'] = 1;
                    $upData['dtUpdatedDate'] = date("Y-m-d H:i:s");
                    $upWhere = 'iUserId = "' . $iId . '"';
                    $this->model_user->update($upData, $upWhere, 'user_master');
                    $this->session->set_flashdata("success", "User deleted successfully");
                    redirect('users');
                }
            }
        }
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('list', 'users');
        }
        $data['sublist'] = 'notreq';
        $this->load->view('user_list', $data);
    }

    public function user_add() {

        $getVars = $this->input->get();
        $userId = (isset($getVars['id']) && $getVars['id'] != '') ? $this->general->decryptData($getVars['id']) : '';
        $mode = (isset($getVars['m']) && $getVars['m'] != '') ? $this->general->decryptData($getVars['m']) : '';
        $data['vehicleTypes'] = $this->model_user->getData('vehicle_type_master', 'iVehicleTypeId,vType', 'iIsDeleted != 1 and eStatus = "Active"');
        if ($userId != '' && $mode = "edit") {
            $extCond = "iUserId = $userId";
            $fields = "iUserId,vFirstName,vLastName,vEmail,vDl,vIdimg,vPassword,vContactNo,eBusinessType,vArea,tAddress,iVehicleId,vNumber,tStandingPoint,eStatus";
            $data['all'] = $this->model_user->getData('', $fields, $extCond);
            $vehicleId = (isset($data['all'][0]['iUserId'])) ? $data['all'][0]['iUserId'] : 0;
            if ($vehicleId > 0) {
                $data['images'] = $this->model_user->getData('vehicle_images', 'iImageId,vName', "iVehicleId=" . $vehicleId);
            }
            $data['mode'] = 'edit';
        }
        
//        pr($data, 1);
        $this->load->view('user_add', $data);
    }

    public function user_add_action() {
        $postvar = $this->input->post();
        $submit = $postvar['submit'][0];
        $id = $postvar['iUserId'];
        $mode = $postvar['mode'];
        $insertData['vFirstName'] = (!empty($postvar['firstName'])) ? $postvar['firstName'] : "";
        $insertData['vLastName'] = (!empty($postvar['lastName'])) ? $postvar['lastName'] : "";
        $insertData['vEmail'] = (!empty($postvar['email'])) ? $postvar['email'] : "";
        if (isset($postvar['password']) && $postvar['password'] != '') {
            $insertData['vPassword'] = md5($postvar['password']);
        }
        $insertData['iRoleId'] = "3";
        $insertData['vContactNo'] = (!empty($postvar['contactNo'])) ? $postvar['contactNo'] : "";
        $insertData['eBusinessType'] = (!empty($postvar['bussinessType'])) ? $postvar['bussinessType'] : "";
        $insertData['tAddress'] = (!empty($postvar['address'])) ? $postvar['address'] : "";
        $insertData['vArea'] = (!empty($postvar['area'])) ? $postvar['area'] : "";
        $insertData['eStatus'] = (!empty($postvar['status'])) ? $postvar['status'] : "";
        $insertData['iVehicleId'] = (!empty($postvar['vehicleId'])) ? $postvar['vehicleId'] : "";
        $insertData['vNumber'] = (!empty($postvar['number'])) ? $postvar['number'] : "";
        $insertData['tStandingPoint'] = (!empty($postvar['standingPoint'])) ? $postvar['standingPoint'] : "";
        $vehData['iVehicleTypeId'] = (!empty($postvar['vehicleId'])) ? $postvar['vehicleId'] : "0";
        $vehData['vNumber'] = (!empty($postvar['number'])) ? $postvar['number'] : "";
        $vehData['tStandingPoint'] = (!empty($postvar['standingPoint'])) ? $postvar['standingPoint'] : "";
        
        
//        $location = $this->general->getLatLngFromAddress($vehData['tStandingPoint']);
//        $vehData['vLatitude'] = $location['lat'];
//        $vehData['vLongitude'] = $location['long'];
       
//        pr($vehData, 1);

        if ($id != '' && $mode == 'edit') {
            $ext_cond = "iUserId=" . $id;
            $insertData['dtUpdatedDate'] = date('Y-m-d H:i:s');
            $this->model_user->update($insertData, $ext_cond);
            $userId = $id;
            $this->session->set_flashdata("success", "User updated successfully");
        } else {
            $insertData['eUserType'] = "ADMIN";
            $insertData['dtCreatedDate'] = date('Y-m-d H:i:s');
            $insertData['dtUpdatedDate'] = date('Y-m-d H:i:s');
            $insertData['iIsDeleted'] = 0;
            $userId = $this->model_user->insert($insertData);

            $this->session->set_flashdata("success", "User added successfully");
        }

        if (isset($_FILES['dlimg']['name']) && $_FILES['dlimg']['name'] != "") {
            $vDl['vDl'] = $this->uploadImage($userId, 'dlimg');
            $this->model_user->update($vDl, "iUserId =$userId");
        }
        if (isset($_FILES['idimg']['name']) && $_FILES['idimg']['name'] != "") {
            $vIdimg['vIdimg'] = $this->uploadImage($userId, 'idimg');
            $this->model_user->update($vIdimg, "iUserId =$userId");
        }

        
        if (isset($_FILES['vehImages']['name']) && $_FILES['vehImages']['name'] != "") {
            $this->uploadVehicleImages($id);
        }
        
        if ($submit == "savenew")
            redirect('user-add');
        else
            redirect('users');
        exit;
    }

    public function checkEmail() {

        $getvar = $this->input->get();
        $postvar = $this->input->post();
        $tbl = '';

        if ($postvar['vEmail'] != '') {
            if ($getvar['tablename'] != '') {
                $tbl = $getvar['tablename'];
            }
            if ($getvar['id'] != '') {
                $ext_cond = "vEmail ='" . $postvar['vEmail'] . "' and iUserId !=" . $getvar['id'];
            } else {
                $ext_cond = "vEmail ='" . $postvar['vEmail'] . "'";
            }
            $ext_cond.=" and isDelete != 1";

            echo $this->model_customer->getUserValidation('vEmail', $postvar['vEmail'], $tbl, $ext_cond);
            exit;
        }
        exit;
    }

    private function uploadImage($userId, $imgname) {
        $temp_folder_path = $this->config->item('upload_path') . 'users/' . $userId . '/';
        $this->general->createfolder($temp_folder_path);
        $name = $_FILES[$imgname]['name'];
        if (isset($name) && $name != "") {
            $file_name = date('YmdHis') . "_" . pathinfo($_FILES[$imgname]['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES[$imgname]['tmp_name'], $temp_folder_path . $file_name);
            return $file_name;
        }
    }

    private function uploadVehicleImages($userId) {
        $temp_folder_path = $this->config->item('upload_path') . 'vehicles/' . $userId . '/';
        $this->general->createfolder($temp_folder_path);
        for ($i = 0; $i < count($_FILES['vehImages']['name']); $i++) {
            $file_name = $userId . '_' . date('YmdHis') . "_" . $i . "." . pathinfo($_FILES['vehImages']['name'][$i], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['vehImages']['tmp_name'][$i], $temp_folder_path . $file_name);
            $file_data['iVehicleId'] = $userId;
            $file_data['vName'] = $file_name;
            $file_data['dtCreatedDate'] = date('Y-m-d H:i:s');
            $this->model_user->insert($file_data, 'vehicle_images');
        }
    }

    public function deleteVehicleImage() {
        $postVars = $this->input->post();
        $imageId = (isset($postVars['file'])) ? $postVars['file'] : 0;
        if ($imageId > 0) {
            $this->model_user->delete("iImageId=$imageId", 'vehicle_images');
        }
    }

}
