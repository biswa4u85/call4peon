<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shipment extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_shipment');
    }

    public function shipments() {
        $getvar = $this->input->get();
        if ($getvar['id'] != '' && $getvar['m'] != '') {
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            
            if ($mode == 'delete') {
                $iId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                if ($getvar['call'] == 'ajax') {
                    $res = 1;
                } else {
                    echo $res = $this->general->check_permission('del', 'shipments', 'ajax');
                }
                if ($res == 1) {
                     
                    $upData['iIsDeleted'] = 1;
                    $upData['dtUpdatedDate'] = date("Y-m-d H:i:s");
                    $upWhere = 'iShipmentId = "' . $iId . '"';
                    $this->model_shipment->update($upData, $upWhere, 'shipment_master');
//                    echo $this->db->last_query(); 
                    $this->session->set_flashdata("success", "Vehicle deleted successfully");
                    redirect('shipments');
                }
            }
        }
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('list', 'shipments');
        }
        $data['sublist'] = 'notreq';
        $this->load->view('shipment_list', $data);
    }

    public function shipment_add() {

        $getVars = $this->input->get();
        $shipmentId = (isset($getVars['id']) && $getVars['id'] != '') ? $this->general->decryptData($getVars['id']) : '';
        $mode = (isset($getVars['m']) && $getVars['m'] != '') ? $this->general->decryptData($getVars['m']) : '';
        $data['mode'] = "Add";

//        $data['vehicles'] = $this->model_shipment->getData('vehicle_master', 'iVehicleId', 'iIsDeleted != 1 and eStatus = "Active"');
        $data['vehicleTypes'] = $this->model_shipment->getData('vehicle_type_master', 'iVehicleTypeId,vType', 'iIsDeleted != 1 and eStatus = "Active"');
        if ($shipmentId != '' && $mode = "edit") {
            $extCond = "iShipmentId = $shipmentId";
            $fields = "iShipmentId,vTitle,tDescription,vContactNo,vPreferredDate,iVehicleId,vFirstName,vLastName,vPickupAddress,vPickupArea,vDropAddress,vDropArea,iIsShipped,iIsUrgent,eStatus";
            $data['all'] = $this->model_shipment->getData('', $fields, $extCond);
            $data['images'] = $this->model_shipment->getData('shipment_images', 'iImageId,vName', "iShipmentId=$shipmentId");
            $data['mode'] = 'edit';
        }
        $this->load->view('shipment_add', $data);
    }

    public function shipment_add_action() {
        $postvar = $this->input->post();
        $submit = $postvar['submit'][0];
        $id = $postvar['iShipmentId'];
        $mode = $postvar['mode'];
        $shipData['vTitle'] = (!empty($postvar['title'])) ? $postvar['title'] : "";
        $shipData['tDescription'] = (!empty($postvar['description'])) ? $postvar['description'] : "";
        $shipData['vContactNo'] = (!empty($postvar['contactNo'])) ? $postvar['contactNo'] : "";
        $shipData['vPreferredDate'] = (!empty($postvar['prefferedDate'])) ? date("Y-m-d H:i:s", strtotime($postvar['prefferedDate'])) : "";
        $shipData['iVehicleId'] = (!empty($postvar['vehicle'])) ? $postvar['vehicle'] : "";
        $shipData['vFirstName'] = (!empty($postvar['firstName'])) ? $postvar['firstName'] : "";
        $shipData['vLastName'] = (!empty($postvar['lastName'])) ? $postvar['lastName'] : "";
        $shipData['eStatus'] = (!empty($postvar['status'])) ? $postvar['status'] : "";
        $shipData['vPickupAddress'] = (!empty($postvar['pickupAddress'])) ? $postvar['pickupAddress'] : "";
        $shipData['vPickupArea'] = (!empty($postvar['pickupArea'])) ? $postvar['pickupArea'] : "";
        

//        $pLatLng = $this->general->getLatLngFromAddress($shipData['vPickupAddress']);
//        $data['vPickupLat'] = $pLatLng['lat'];
//        $data['vPickupLng'] = $pLatLng['lng'];

        $shipData['vDropAddress'] = (!empty($postvar['dropAddress'])) ? $postvar['dropAddress'] : "";
        $shipData['vDropArea'] = (!empty($postvar['dropArea'])) ? $postvar['dropArea'] : "";
        
        $shipData['iIsShipped'] = (!empty($postvar['iIsShipped'])) ? $postvar['iIsShipped'] : "Pending";
        $shipData['iIsUrgent'] = (!empty($postvar['iIsUrgent'])) ? $postvar['iIsUrgent'] : "0";

        if ($id != '' && $mode == 'edit') {
            $ext_cond = "iShipmentId=" . $id;
            $shipData['dtUpdatedDate'] = date('Y-m-d H:i:s');
            $this->model_shipment->update($shipData, $ext_cond);
            $rply = $id;
            $this->session->set_flashdata("success", "Shipment updated successfully");
        } else {
            $shipData['dtCreatedDate'] = date('Y-m-d H:i:s');
            $shipData['dtUpdatedDate'] = date('Y-m-d H:i:s');
            $shipData['iIsDeleted'] = 0;
            $rply = $this->model_shipment->insert($shipData);
            $this->session->set_flashdata("success", "Shipment added successfully");
        }

        if ($rply) {
            $this->uploadImages($rply);
        }
        if ($submit == "savenew")
            redirect('shipment-add');
        else
            redirect('shipments');
        exit;
    }

    private function uploadImages($shipmentId) {
        $temp_folder_path = $this->config->item('upload_path') . 'shipments/' . $shipmentId . '/';
        $this->general->createfolder($temp_folder_path);
        for ($i = 0; $i < count($_FILES['shipImages']['name']); $i++) {
            $file_name = $shipmentId . '_' . date('YmdHis') . "_" . $i . "." . pathinfo($_FILES['shipImages']['name'][$i], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['shipImages']['tmp_name'][$i], $temp_folder_path . $file_name);
            $file_data['iShipmentId'] = $shipmentId;
            $file_data['vName'] = $file_name;
            $file_data['dtCreatedDate'] = date('Y-m-d H:i:s');
            $this->model_shipment->insert($file_data, 'shipment_images');
        }
    }

    public function deleteImage() {
        $postVars = $this->input->post();
        $imageId = (isset($postVars['file'])) ? $postVars['file'] : 0;
        if ($imageId > 0) {
            $this->model_shipment->delete("iImageId=$imageId", 'shipment_images');
        }
    }

}
