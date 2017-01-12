<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class V1 extends MX_Controller {

    private $code;
    private $message;

    public function __construct() {
        parent::__construct();
        error_reporting();
        $this->load->model('model_support');
        $this->load->library('general');
    }

    public function getVehicleType() {
        $postdata = $this->ws_input();
        $cond = "eStatus = 'Active'";
        if (isset($postdata['timestamp']) && $postdata['timestamp'] != NULL)
            $cond .= " and dtUpdatedDate > '" . date('Y-m-d H:i:s', $postdata['timestamp']) . "'";
        $vehicleType = $this->model_support->getData("vehicle_type_master", "dtUpdatedDate,iVehicleTypeId as vehicleTypeId,vType as vehicleType,vIcon as vehicleIcon", $cond);
        foreach ($vehicleType as $key => $value) {
            $image_url = $this->config->item('images_url') . 'typenoimage.png';
            $file_path = $this->config->item('upload_path') . 'vehicles_type_icon/' . $value['vehicleTypeId'] . '/' . $value['vehicleIcon'];
            if (file_exists($file_path)) {
                $image_url = $this->config->item('upload_url') . 'vehicles_type_icon/' . $value['vehicleTypeId'] . '/' . $value['vehicleIcon'];
            }
            $vehicleType[$key]['vehicleIcon'] = $image_url;
        }
        return $vehicleType;
//        $this->setOutput(200, "success", $vehicleType);
    }

    public function getCountry() {
//        pr(strtotime('2016-02-20 09:38:08'),1);
        $postdata = $this->ws_input();
        $cond = "iCountryId = 113 and eStatus = 'Active'";
        if (isset($postdata['timestamp']) && $postdata['timestamp'] != NULL)
            $cond .= " and dtCreated  > '" . date('Y-m-d H:i:s', $postdata['timestamp']) . "'";
        $country = $this->model_support->getData("country", "iCountryId as countryId,vCountry as countryName", $cond);
//        pr($country);
//        pr($this->db->last_query(), 1);
        return $country;
//        $this->setOutput(200, "success", $country);
    }

    public function getState() {
        $postdata = $this->ws_input();
        $countryId = isset($postdata['countryId']) ? $postdata['countryId'] : '113';
        $cond = "iCountryId = '$countryId' and eStatus = 'Active'";
        if (isset($postdata['timestamp']) && $postdata['timestamp'] != NULL)
            $cond .= " and dtModify > '" . date('Y-m-d H:i:s', $postdata['timestamp']) . "'";
        $states = $this->model_support->getData("states", "iCountryId as countryId,iStateId as stateId,vStateName as stateName", $cond);
//        $this->setOutput(200, "success", $states);
        return $states;
    }

    public function getCity() {
        $postdata = $this->ws_input();
        $countryId = isset($postdata['countryId']) ? $postdata['countryId'] : '113';
        $stateId = isset($postdata['stateId']) ? $postdata['stateId'] : '';
        $cond = "iCountryId = '$countryId' and eStatus = 'Active'";
        if ($stateId != '') {
            $cond .= " and iStateId = '$stateId'";
        }
        if (isset($postdata['timestamp']) && $postdata['timestamp'] != NULL)
            $cond .= " and dtModify > '" . date('Y-m-d H:i:s', $postdata['timestamp']) . "'";
        $city = $this->model_support->getData("city", "iCountryId as countryId,iStateId as stateId,iCityId as cityId,vCityName as cityName", $cond);
//        $this->setOutput(200, "success", $city);
        return $city;
    }

    public function getArea() {
        $postdata = $this->ws_input();
        $countryId = isset($postdata['countryId']) ? $postdata['countryId'] : '113';
        $stateId = isset($postdata['stateId']) ? $postdata['stateId'] : '';
        $cityId = isset($postdata['cityId']) ? $postdata['cityId'] : '';
        $cond = "iCountryId = '$countryId' and eStatus = 'Active'";
        if ($stateId != '') {
            $cond .= " and iStateId = '$stateId'";
        }
        if ($cityId != '') {
            $cond .= " and iCityId = '$cityId'";
        }
        if (isset($postdata['timestamp']) && $postdata['timestamp'] != NULL)
            $cond .= " and dtModify > '" . date('Y-m-d H:i:s', $postdata['timestamp']) . "'";
        $area = $this->model_support->getData("area", "iCountryId as countryId,iStateId as stateId,iCityId as cityId,iAreaId as areaId,vAreaName as areaName", $cond);
//        $this->setOutput(200, "success", $area);
//        pr($this->db->last_query(), 1);
        return $area;
    }

    public function addTransporters() {
        $postdata = $this->ws_input();
        $postvar = (array) json_decode($postdata['transporter']);
//        $postvar = $postdata;
//        pr($postvar,1);
        if (count($postvar) > 0) {
            $data['iRoleId'] = 3;
            $data['eUserType'] = "SELF";
            $data['vFirstName'] = (!empty($postvar['firstName'])) ? $postvar['firstName'] : "";
            $data['vLastName'] = (!empty($postvar['lastName'])) ? $postvar['lastName'] : "";
            $data['vContactNo'] = (!empty($postvar['phone'])) ? $postvar['phone'] : "";
            $data['iCountryId'] = (!empty($postvar['country'])) ? $postvar['country'] : 113;
            $data['iStateId'] = (!empty($postvar['state'])) ? $postvar['state'] : "";
            $data['iCityId'] = (!empty($postvar['city'])) ? $postvar['city'] : "";
            $data['vArea'] = (!empty($postvar['residentArea'])) ? $postvar['residentArea'] : "";
            $data['tAddress'] = (!empty($postvar['residentAddress'])) ? $postvar['residentAddress'] : "";
            $data['eBusinessType'] = (!empty($postvar['businessType'])) ? $postvar['businessType'] : "Individual";
            $data['eStatus'] = (!empty($postvar['status'])) ? $postvar['status'] : "Inactive";
            $data['tDescription'] = (!empty($postvar['description'])) ? $postvar['description'] : "";
            $data['dtCreatedDate'] = date("Y-m-d H:i:s");
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $data['iIsDeleted'] = 0;
            $vehData['iVehicleTypeId'] = (!empty($postvar['vehicleType'])) ? $postvar['vehicleType'] : "0";
            $vehData['vNumber'] = (!empty($postvar['vehicleNumber'])) ? $postvar['vehicleNumber'] : "";
            $vehData['tStandingPoint'] = (!empty($postvar['standingPoint'])) ? $postvar['standingPoint'] : "";
            $vehData['vStandingArea'] = (!empty($postvar['standingArea'])) ? $postvar['standingArea'] : "";
            $location = $this->general->getLatLngFromAddress($vehData['tStandingPoint']);
            $vehData['vLatitude'] = (!empty($location['lat'])) ? $location['lat'] : null;
            $vehData['vLongitude'] = (!empty($location['lng'])) ? $location['lng'] : null;
            $vehdata['dtCreatedDate'] = date("Y-m-d H:i:s");
            $vehdata['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $vehdata['iIsDeleted'] = 0;
            $userId = $this->model_support->insert('user_master', $data);
            if ($userId > 0) {
                $vehData['iUserId'] = $userId;
                $vehicleId = $this->model_support->insert('vehicle_master', $vehData);
            }

            if (!empty($_FILES)) {
                $target_path = $this->config->item('upload_path') . 'vehicles/' . $vehicleId . '/';
                $vImgData['iVehicleId'] = $vehicleId;
                $vImgData['dtCreatedDate'] = date('Y-m-d H:i:s');
                $this->general->createfolder($target_path);
                $this->load->library('upload');
                $i = 0;
                foreach ($_FILES as $key => $value) {
                    $file = $_FILES[$key];
                    
                    if ($file['name'] != '') {
                        $file_name = date('ymdhis') . '_' . date('YmdHis');

                        $upload_config = array(
                            'upload_path' => $target_path,
                            'allowed_types' => "jpg|jpeg|gif|png|pdf|doc|docx", //*
                            'max_size' => 1028 * 1028 * 2,
                            'file_name' => $file_name,
                            'remove_space' => TRUE,
                            'overwrite' => FALSE
                        );

                        $this->upload->initialize($upload_config);
                        if ($this->upload->do_upload($key)) {
                            $file_info = $this->upload->data();
                            $uploadedFile = $file_info['file_name'];
                            $vImgData['vName'] = $uploadedFile;
                    $this->model_support->insert('vehicle_images', $vImgData);
                        } else {
                            $this->setOutput(401, $this->upload->display_errors());
                }
            }
                }
            }
        } else {
            $this->setOutput(423, "Please check your parameters");
        }
        $val->message = "success";
        $val->code = 200;

        $this->setOutput(200, "success", $val);
    }

    public function addShipments() {
        $postdata = $this->ws_input();
        $postvar = (array) json_decode($postdata['shipment']);
        $data = [];
        if (count($postvar) > 0) {
            $data['vTitle'] = (!empty($postvar['title'])) ? $postvar['title'] : '';
            $data['tDescription'] = (!empty($postvar['description'])) ? $postvar['description'] : '';
            $data['vContactNo'] = (!empty($postvar['phone'])) ? $postvar['phone'] : '';
            $data['vPreferredDate'] = (!empty($postvar['prefferedDate'])) ? $postvar['prefferedDate'] : '';
            $data['iVehicleId'] = (!empty($postvar['vehicle'])) ? $postvar['vehicle'] : '';
            $data['vFirstName'] = (!empty($postvar['firstName'])) ? $postvar['firstName'] : '';
            $data['vLastName'] = (!empty($postvar['lastName'])) ? $postvar['lastName'] : '';
            $data['vPickupAddress'] = (!empty($postvar['pickupAddress'])) ? $postvar['pickupAddress'] : '';
            $data['iPickupCountryId'] = (!empty($postvar['pickupCountry'])) ? $postvar['pickupCountry'] : '';
            $data['iPickupStateId'] = (!empty($postvar['pickupState'])) ? $postvar['pickupState'] : '';
            $data['iPickupCityId'] = (!empty($postvar['pickupCity'])) ? $postvar['pickupCity'] : '';
            $data['vPickupArea'] = (!empty($postvar['pickupArea'])) ? $postvar['pickupArea'] : '';
            $data['vPickupLandmark'] = (!empty($postvar['pickupLandmark'])) ? $postvar['pickupLandmark'] : '';
            $data['iPickupStateId'] = (!empty($postvar['pickupState'])) ? $postvar['pickupState'] : '';
            $pLatLng = $this->general->getLatLngFromAddress($data['vPickupAddress']);
            $data['vPickupLat'] = $pLatLng['lat'];
            $data['vPickupLng'] = $pLatLng['lng'];
            $data['vDropAddress'] = (!empty($postvar['dropAddress'])) ? $postvar['dropAddress'] : '';
            $data['iDropCountryId'] = (!empty($postvar['dropCountry'])) ? $postvar['dropCountry'] : '';
            $data['iDropStateId'] = (!empty($postvar['dropState'])) ? $postvar['dropState'] : '';
            $data['iDropCityId'] = (!empty($postvar['dropCity'])) ? $postvar['dropCity'] : '';
            $data['vDropArea'] = (!empty($postvar['dropArea'])) ? $postvar['dropArea'] : '';
            $data['vDropLandmark'] = (!empty($postvar['dropLandmark'])) ? $postvar['dropLandmark'] : '';

            $dLatLng = $this->general->getLatLngFromAddress($data['vDropAddress']);
            $data['vPickupLat'] = $dLatLng['lat'];
            $data['vPickupLng'] = $dLatLng['lng'];
            $data['iIsShipped'] = "Pending";
            $data['iIsUrgent'] = (!empty($postvar['urgent'])) ? 1 : 0;
            $data['eStatus'] = (!empty($postvar['status'])) ? $postvar['status'] : "Inactive";
            $data['dtCreatedDate'] = date("Y-m-d H:i:s");
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $data['iIsDeleted'] = 0;

            $shipmentId = $this->model_support->insert('shipment_master', $data);


            if (!empty($_FILES)) {
                $target_path = $this->config->item('upload_path') . 'shipments/' . $shipmentId . '/';
//                pr($target_path);exit;
                $sImgData['iShipmentId'] = $shipmentId;
                $sImgData['dtCreatedDate'] = date('Y-m-d H:i:s');
                $this->general->createfolder($target_path);
                $this->load->library('upload');
                $i = 0;
                foreach ($_FILES as $key => $value) {
                    $file = $_FILES[$key];

                    if ($file['name'] != '') {
                        $file_name = date('ymdhis') . '_' . date('YmdHis');

                        $upload_config = array(
                            'upload_path' => $target_path,
                            'allowed_types' => "jpg|jpeg|gif|png|pdf|doc|docx", //*
                            'max_size' => 1028 * 1028 * 2,
                            'file_name' => $file_name,
                            'remove_space' => TRUE,
                            'overwrite' => FALSE
                        );

                        $this->upload->initialize($upload_config);
                        if ($this->upload->do_upload($key)) {
                            $file_info = $this->upload->data();
                            $uploadedFile = $file_info['file_name'];
                            $sImgData['vName'] = $uploadedFile;
                            $this->model_support->insert('shipment_images', $sImgData);
                        } else {
                            $this->setOutput(401, $this->upload->display_errors());
                        }
                    }
                }
            }
        } else {
            $this->setOutput(422, "Please check your parameters");
        }
        $val->message = "success";
        $val->code = 200;

        $this->setOutput(200, "success", $val);
    }

    public function getTransporters() {
        $postdata = $this->ws_input();
        if (empty($postdata['userLat']) || empty($postdata['userLat'])) {
            $this->setOutput(423, "Please check your parameters");
        }
        $id = $postdata['transporterId'];
        $page = $postdata['page'];
        $userLat = $postdata['userLat'];
        $userLong = $postdata['userLong'];
        $fromPoint = $postdata['fromPoint'];
        $toPoint = $postdata['toPoint'];
        $vehicleType = $postdata['vehicleType'];
        $distance = $postdata['distance'];
        $cond = "iRoleId = 3 and user_master.eStatus='Active'";
        if ($id != '') {
            $cond .= " and user_master.iUserId='$id'";
        }
        if ($fromPoint != '') {
            $cond .= " and (tStandingPoint like '%$fromPoint%' or vStandingArea like '%$fromPoint%')";
        }
        if ($vehicleType != '') {
            $cond .= " and vehicle_type_master.vType like '%$vehicleType%'";
        }
        $joinArray = array(array('table' => 'vehicle_master', 'condition' => 'vehicle_master.iUserId = user_master.iUserId and vehicle_master.eStatus = "Active"'),
            array('table' => 'vehicle_type_master', 'condition' => 'vehicle_type_master.iVehicleTypeId = vehicle_master.iVehicleTypeId and vehicle_type_master.eStatus = "Active"', 'jointype' => 'left'),
            array('table' => 'country', 'condition' => 'country.iCountryId = user_master.iCountryId and country.eStatus = "Active"', 'jointype' => 'left'),
            array('table' => 'states', 'condition' => 'states.iStateId = user_master.iStateId and states.eStatus = "Active"', 'jointype' => 'left'),
            array('table' => 'city', 'condition' => 'city.iCityId = user_master.iCityId and city.eStatus = "Active"', 'jointype' => 'left'));

        $order = 'distance asc';
        $group = '';
        $having = ((int) $distance > 0) ? "distance < '$distance'" : '';
        $climit = ($page > 1) ? $page : 1;
        $data['transporters'] = $this->model_support->getData('user_master', "user_master.iUserId as transporterId, iVehicleId as vehicleId, vFirstName as firstName,vLastName as lastName,user_master.tDescription as description,vContactNo as phone, vCountry as country,vStateName as state, vCityName as city,vArea as residentArea,vLandMark as residentLandMark,tAddress as residentAddress, eBusinessType as businessType,vType as vehicleType, vNumber as vehicleNumber, coalesce(tStandingPoint,'') as standingPoint,coalesce(vStandingArea,'') as standingArea, coalesce(vLatitude,'') as standingLat, coalesce(vLongitude,'') as standingLong,coalesce(ROUND(((2*ATAN2(SQRT((SIN(((vLatitude*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)*SIN(((vLatitude*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)+COS(('".$userLat."'*1)*(PI()/180))*COS(vLatitude*(PI()/180))*SIN(((vLongitude*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2)*SIN(((vLongitude*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2))), SQRT(1-(SIN(((vLatitude*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)*SIN(((vLatitude*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)+COS(('".$userLat."'*1)*(PI()/180))*COS(vLatitude*(PI()/180))*SIN(((vLongitude*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2)*SIN(((vLongitude*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2)))))*6378.388)/100000,2),'') AS distance", $cond, $joinArray, $order, $group, $having, $climit);
        if (count($data['transporters']) > 0) {
            $next_page = $this->model_support->record_count($page);
            $data['transporters'][0]['nextPage'] = $next_page;
            foreach ($data['transporters'] as $key => $value) {
                $vcond = "iVehicleId = '" . $value['vehicleId'] . "'";
                $image_data = $this->model_support->getData('vehicle_images', 'vName as vehicle_image', $vcond);
                if (count($image_data) < 1) {
                    $image_url = $this->config->item('images_url') . 'vehicle_noimage.png';
                    $data['transporters'][$key]['images'][] = $image_url;
                }
                foreach ($image_data as $ikey => $ivalue) {
                    $image_url = $this->config->item('images_url') . 'vehicle_noimage.png';
                    $file_path = $this->config->item('upload_path') . 'vehicles/' . $value['vehicleId'] . '/' . $ivalue['vehicle_image'];
                    if (file_exists($file_path)) {
                        $image_url = $this->config->item('upload_url') . 'vehicles/' . $value['vehicleId'] . '/' . $ivalue['vehicle_image'];
                    }
                    $data['transporters'][$key]['images'][] = $image_url;
                }
            }
        }
        $this->setOutput(200, "success", $data);
    }

    public function getShipments() {
        $postdata = $this->ws_input();
        $id = $postdata['shipmentId'];

        if (empty($postdata['userLat']) || empty($postdata['userLat'])) {
            $this->setOutput(422, "Please check your parameters");
        }
        $page = $postdata['page'];
        $userLat = $postdata['userLat'];
        $userLong = $postdata['userLong'];
        $fromPoint = $postdata['fromPoint'];
        $toPoint = $postdata['toPoint'];
        $vehicleType = $postdata['vehicleType'];
        $distance = $postdata['distance'];
        $cond = "shipment_master.eStatus='Active'";
        if ($id != '') {
            $cond .= " and shipment_master.iShipmentId='$id'";
        }
        if ($fromPoint != '') {
            $cond .= " and (vPickupAddress like '%$fromPoint%' or iPickupCityId like '%$fromPoint%' or vPickupArea like '%$fromPoint%' or iPickupStateId like '%$fromPoint%')";
        }
        if ($toPoint != '') {
            $cond .= " and (vDropAddress like '%$toPoint%' or iDropCityId like '%$toPoint%' or vDropArea like '%$toPoint%' or iDropStateId like '%$toPoint%')";
        }
        if ($vehicleType != '') {
            $cond .= " and vehicle_type_master.vType like '%$vehicleType%'";
        }
        $joinArray = array(array('table' => 'vehicle_type_master', 'condition' => 'vehicle_type_master.iVehicleTypeId = shipment_master.iVehicleId and vehicle_type_master.eStatus = "Active"', 'jointype' => 'left'),
        );

        $order = 'distance asc';
        $group = '';
        $having = ((int) $distance > 0) ? "distance < '$distance'" : '';
        $climit = ($page > 1) ? $page : 1;
        $data['shipments'] = $this->model_support->getData('shipment_master', "shipment_master.iShipmentId as shipmentId, shipment_master.iVehicleId as vehicleId,vTitle as title,coalesce(tDescription,'') as description,vFirstName as firstName,vLastName as lastName,vContactNo as phone,getCountry(iPickupCountryId) as pickupCountry,getState(iPickupCountryId,iPickupStateId) as pickupState, getCity(iPickupCountryId,iPickupStateId,iPickupCityId) as pickupCity,coalesce(vPickupArea,'') as pickupArea,coalesce(vPickupLandmark,'') as pickupLandMark,coalesce(vPickupAddress,'') as pickupAddress,getCountry(iDropCountryId) as dropCountry,getState(iDropCountryId,iDropStateId) as dropState, getCity(iDropCountryId,iDropStateId,iDropCityId) as dropCity,coalesce(vDropArea,'') as dropArea,coalesce(vDropLandmark,'') as dropLandMark,coalesce(vDropAddress,'') as dropAddress,vType as vehicleType , coalesce(vPickupLat,'') AS pickupLat, coalesce(vPickupLng,'') AS pickupLng, coalesce(vDropLat,'') AS dropLat, coalesce(vDropLng,'') AS dropLng, coalesce(ROUND(((2*ATAN2(SQRT((SIN(((vPickupLat*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)*SIN(((vPickupLat*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)+COS(('".$userLat."'*1)*(PI()/180))*COS(vPickupLat*(PI()/180))*SIN(((vPickupLng*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2)*SIN(((vPickupLng*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2))), SQRT(1-(SIN(((vPickupLat*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)*SIN(((vPickupLat*(PI()/180))-(('".$userLat."'*1)*(PI()/180)))/2)+COS(('".$userLat."'*1)*(PI()/180))*COS(vPickupLat*(PI()/180))*SIN(((vPickupLng*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2)*SIN(((vPickupLng*(PI()/180))-(('".$userLong."'*1)*(PI()/180)))/2)))))*6378.388)/100000,2),'') AS distance, iIsUrgent as urgent", $cond, $joinArray, $order, $group, $having, $climit);

        if (count($data['shipments']) > 0) {
            $next_page = $this->model_support->record_count($page);
            $data['shipments'][0]['nextPage'] = $next_page;
            foreach ($data['shipments'] as $key => $value) {
                $scond = "iShipmentId = '" . $value['shipmentId'] . "'";
                $image_data = $this->model_support->getData('shipment_images', 'vName as shipment_image', $scond);

                if (count($image_data) < 1) {
                    $image_url = $this->config->item('images_url') . 'shipment_noimage.png';
                    $data['shipments'][$key]['images'][] = $image_url;
                }
                foreach ($image_data as $ikey => $ivalue) {
                    $image_url = $this->config->item('images_url') . 'shipment_noimage.png';
                    $file_path = $this->config->item('upload_path') . 'shipments/' . $value['shipmentId'] . '/' . $ivalue['shipmentId'];
                    if (file_exists($file_path)) {

                        $image_url = $this->config->item('upload_url') . 'shipments/' . $value['shipmentId'] . '/' . $ivalue['shipment_image'];
                    }
                    $data['shipments'][$key]['images'][] = $image_url;
                }
            }
        }
        $this->setOutput(200, "success", $data);
    }

    public function getLocations() {
        $cond = "";
        $data['locations'] = $this->model_support->getData('location_master', "getCountry(iCountryId) as country,getState(iCountryId,iStateId) as state,getCity(iCountryId,iStateId,iCityId) city,getArea(iCountryId,iStateId,iCityId,iAreaId) as area, vLandmark as landmark, vLatitude AS latitude , vLongitude as longitude", [], $cond);
//        echo $this->db->last_query();exit;
        $this->setOutput(200, "success", $data);
    }

    public function addLocations() {
        $this->setOutput(403, "Currently you dont have access to this service");
        exit;
        $postdata = $this->ws_input();
        $locations = (!empty($postdata['locations'])) ? $postdata['locations'] : [];
        if (count($locations)) {
            foreach ($locations as $key => $value) {
                $area = $this->model_location->getData('area', 'vAreaName', 'iAreaId = "' . $value['areaId'] . '"');
                $location['iCountryId'] = (!empty($value['countryId'])) ? $value['countryId'] : "113";
                $location['iStateId'] = (!empty($value['stateId'])) ? $value['stateId'] : "";
                $location['iCityId'] = (!empty($value['cityId'])) ? $value['cityId'] : "";
                $location['iAreaId'] = (!empty($value['areaId'])) ? $value['areaId'] : "";
                $location['vLandmark'] = (!empty($value['landmark'])) ? $value['landmark'] : "";
                $latlng = $this->general->getLatLngFromAddress(!empty($area[0]['vAreaName']) ? $area[0]['vAreaName'] : "");
                $insertData['vLatitude'] = $latlng['lat'];
                $insertData['vLongitude'] = $latlng['lng'];
                $location['dtCreatedDate'] = date('y-m-d H:i:s');
                $location['dtUpdatedDate'] = date('y-m-d H:i:s');
                $location['iIsDeleted'] = 0;
                $location['eStatus'] = 'Active';

                $this->model_support->insert('location', $location);
            }
            $this->setOutput(200, "success");
        }
        $this->setOutput(423, "Please check your parameters");
    }

    private function setOutput($code, $message, $data = '') {
        $this->code = $code;
        $this->message = $message;
        $this->ws_ouput($data);
    }

    private function ws_input() {
        $get_arr = is_array($this->input->get(null, true)) ? $this->input->get(null, true) : array();
        $post_arr = is_array($this->input->post(null, true)) ? $this->input->post(null, true) : array();
        $raw_data = is_array(json_decode(trim(file_get_contents('php://input')), true)) ? json_decode(trim(file_get_contents('php://input')), true) : array();
        return $request_arr = array_merge($get_arr, $post_arr, $raw_data);
    }

    private function ws_ouput($data) {
        $this->output->set_status_header($this->code, $this->message);
        if ($this->code != 200) {
            $data->code = $this->code;
            $data->message = $this->message;
        }
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $ret = json_encode($data);
        $this->output->set_header('Content-type: application/json');
        echo $ret;
        exit;
    }

    public function getRegionData() {
        $postData = $this->ws_input();
        $data['country'] = $this->getCountry();
        $data['state'] = $this->getState();
        $data['city'] = $this->getCity();
        $data['area'] = $this->getArea();
        $data['vehicles'] = $this->getVehicleType();
        $data['timestamp'] = strtotime('now');
        $this->setOutput(200, "success", $data);
    }

}
