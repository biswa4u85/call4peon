<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->library('Datatables');
        $this->load->model('model_support');
    }

    public function index() {
        $data['about_us'] = $this->model_support->get_contain('ABOUT_US');
        $data['transporters'] = $this->model_support->get_contain('TRANSPORTERS');
        $data['shipment'] = $this->model_support->get_contain('SHIPMENT');
        $data['lorem_lpsum'] = $this->model_support->get_contain('LOREM_LPSUM');
        
        
        $data['vehicleTypes'] = $this->model_support->getData('vehicle_type_master', 'iVehicleTypeId,vType', 'iIsDeleted != 1 and eStatus = "Active"');
        
        $this->load->view('index',$data);
        
    }
    
    public function getStateData() {
        $postvar = $this->input->post();
        if ($postvar['Id'] != '') {
            $condition = $postvar['Id'];
            $tbl = $postvar['tablename'];
            echo $this->model_support->getState('iStateId,vStateName', $tbl, $condition);
            exit;
        }
        exit;
    }
    
    public function getCityData() {
        $postvar = $this->input->post();
        if ($postvar['Id'] != '') {
            $condition = $postvar['Id'];
            $state_id = $postvar['state_id'];
            $tbl = $postvar['tablename'];
            echo $this->model_support->getCity('iCityId,vCityName', $tbl, $condition, $state_id);
            exit;
        }
        exit;
    }
    
    public function shipment_add() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
          header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
          header('Access-Control-Allow-Credentials: true');
          header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
 
       if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:  {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
     }

      $apivar = file_get_contents("php://input");
      $apivar = json_decode($apivar);
print_r($apivar); exit;
        $shipmentId = (isset($getVars['id']) && $getVars['id'] != '') ? $this->general->decryptData($getVars['id']) : '';
        $mode = (isset($getVars['m']) && $getVars['m'] != '') ? $this->general->decryptData($getVars['m']) : '';
        $data['mode'] = "Add";

        $data['vehicleTypes'] = $this->model_support->getData('vehicle_type_master', 'iVehicleTypeId,vType', 'iIsDeleted != 1 and eStatus = "Active"');
        if ($shipmentId != '' && $mode = "edit") {
            $extCond = "iShipmentId = $shipmentId";
            $fields = "iShipmentId,vTitle,tDescription,vContactNo,vPreferredDate,iVehicleId,vFirstName,vLastName,vPickupAddress,iPickupCountryId,iPickupStateId,iPickupCityId,vPickupArea,vPickupLandmark,vDropAddress,iDropCountryId,iDropStateId,iDropCityId,vDropArea,vDropLandmark,iIsShipped,iIsUrgent,eStatus";
            $data['all'] = $this->model_shipment->getData('', $fields, $extCond);
            $data['images'] = $this->model_shipment->getData('shipment_images', 'iImageId,vName', "iShipmentId=$shipmentId");
            $data['mode'] = 'edit';
        }
        
        $this->load->view('check', $data);
    }
    
    public function user_add(){
        $postvar_root = $this->input->post();
        $postvar = $postvar_root['data']['d1'];
        
        $insertData['vDl'] = (!empty($postvar_root['data']['f1'])) ? $postvar_root['data']['f1'] : "";
        $insertData['vIdimg'] = (!empty($postvar_root['data']['f2'])) ? $postvar_root['data']['f2'] : "";

        $insertData['vFirstName'] = (!empty($postvar['firstName'])) ? $postvar['firstName'] : "";
        $insertData['vLastName'] = (!empty($postvar['lastName'])) ? $postvar['lastName'] : "";
        $insertData['vEmail'] = (!empty($postvar['email']['text'])) ? $postvar['email']['text'] : "";
        $insertData['iRoleId'] = "3";
        $insertData['vContactNo'] = (!empty($postvar['contactNo'])) ? $postvar['contactNo'] : "";
        $insertData['tAddress'] = (!empty($postvar['address'])) ? $postvar['address'] : "";
        $insertData['iVehicleId'] = (!empty($postvar['vehicleId'])) ? $postvar['vehicleId'] : "";
        $insertData['vNumber'] = (!empty($postvar['number'])) ? $postvar['number'] : "";
        $insertData['eStatus'] = "Pending";
 
        $insertData['eUserType'] = "SELF";
        $insertData['dtCreatedDate'] = date('Y-m-d H:i:s');
        $insertData['dtUpdatedDate'] = date('Y-m-d H:i:s');
        $insertData['iIsDeleted'] = 0;
        $userId = $this->model_support->insert('user_master', $insertData);

        $data['status'] = 'OK';
        $data['msg'] = 'User data has been added successfully.';
        echo json_encode($data);
    }
    
    public function user_add_upload(){
        $target_dir = $this->config->item('upload_path') . "users/";
//        print_r($_FILES);
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    }
    
    public function contact_form(){
             
     if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
     }
 
     if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
     }

             $apivar = file_get_contents("php://input");
             $apivar = json_decode($apivar);
        if (!empty($apivar)) {
             $postvar = (array)$apivar;
        } else {
             $postvar = $this->input->post();
        }   


            $submit = $postvar['submit'][0];
            $fname = (!empty($postvar['fname'])) ? $postvar['fname'] : "";
            $lname = (!empty($postvar['lname'])) ? $postvar['lname'] : "";
            $fullname = $fname . " " . $lname;
            $email = (!empty($postvar['email'])) ? $postvar['email'] : "";
            $telephone = (!empty($postvar['telephone'])) ? $postvar['telephone'] : "";
            $comment = (!empty($postvar['message'])) ? $postvar['message'] : "";
            
            $to = "call4peon@gmail.com";
            $from    = $fullname;
            $email   = $email;
            $subject = "Contact Us Information";
        
		

            $message = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				 <tr>
					<td colspan='2'><strong>Contact Us</strong></td>
					
				  </tr>		
				  <tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>
				  <tr>
					<td width='10%'>Name:-</td>
					<td align='left' width='90%'>$fullname</td>
				  </tr>
				   <tr>
				   <td width='10%'>Email :-</td>
					<td align='left'  width='90%'>$email</td>
				  </tr>	
				  <tr>
				  <td width='10%'>Phone:-</td>
					<td align='left'  width='90%'>$telephone</td>
				  </tr>  
				  <tr>
				   <td width='10%'>Message:-</td>
					<td align='left'  width='90%'>$comment</td>
				  </tr>
				</table>";
	
				

		$headers = "From: $email";
		// Generate a boundary string
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		
		// Add the headers for a file attachment
		$headers .= "\nMIME-Version: 1.0\n" .
				  "Content-Type: multipart/mixed;\n" .
				  " boundary=\"{$mime_boundary}\"";
		
		// Add a multipart boundary above the plain message
		$message1 = "This is a multi-part message in MIME format.\n\n" .
				 "--{$mime_boundary}\n" .
				 "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
				 "Content-Transfer-Encoding: 7bit\n\n" .
				 $message . "\n\n";
		 
		// Send the message
		@mail($to, $subject, $message1, $headers);
        
                echo 'Form Submit successfully';
            
        exit;
    }

    public function login_action() {
        $postvar = $this->input->post();
        
        if((empty(trim($postvar['email']))) && (empty(trim($postvar['contact'])))){
            $this->session->set_flashdata("failure", "You have already requested. Thank you!");
            return redirect('index');
        }
        
        $data['vEmail'] = (!empty(trim($postvar['email']))) ? $postvar['email'] : NULL;
        $data['vContactNo'] = (!empty(trim($postvar['contact']))) ? $postvar['contact'] : NULL;
        $data['dtCreatedDate'] = date("Y-m-d H:i:s");
        $requested = $this->model_support->getData('pre_launch', 'count(*) as tot', [], ' vEmail = "' . $data['vEmail'] . '" or vContactNo = "' . $data['vContactNo'] . '"');
        if ($requested[0]['tot'] > 0) {
            $this->session->set_flashdata("failure", "You have already requested. Thank you!");
            return redirect('index');
        }
        $response = $this->model_support->insert('pre_launch', $data);
        $this->load->model('tools/emailer');
        $contact = ($data['vEmail'] != NULL) ? $data['vEmail'] : NULL;
        $contact .= ($contact != "" && $data['vContactNo'] != NULL) ? " and " . $data['vContactNo'] : " " . $data['vContactNo'];
        $emailData['contact'] = $contact;
        $emailData['vEmail'] = $data['vEmail'];
        if ($data['vEmail'] != NULL) {
//            $this->emailer->send_mail($emailData, 'USER_REQUEST');
        }
        $this->session->set_flashdata("success", "Your request has been submitted successfully! Thank you!");
        redirect('index');
    }

    public function staticpage() { //echo "staticpage function";exit;
        $vPageCode = end($this->uri->rsegments);
        $this->load->model('tools/staticpages');
        $page_details = $this->staticpages->getStaticpage($vPageCode);

        $vPageTitle = $page_details[0]["vPageTitle"];
        $tContent = $page_details[0]["tContent"];
        $meta_title = $page_details[0]["tMetaTitle"];
        $meta_description = $page_details[0]["tMetaKeyword"];
        $meta_keyword = $page_details[0]["tMetaDesc"];

        $render_arr = array(
            'vPageCode' => strtolower($vPageCode),
            'vPageTitle' => $vPageTitle,
            'tContent' => $tContent,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keyword' => $meta_keyword,
            'open' => (isset($_REQUEST['d']) ? $_REQUEST['d'] : '')
        );
        $this->load->view('staticpage', $render_arr);
    }

    function chksession1() {
        echo $this->general->checkSession('ajax');
        exit;
    }

    public function list_ajax() {
        $this->load->model('model_support');
        $getvar = $this->input->get();
        $postvar = $this->input->post();
//        pr($postvar);exit;
        $griddata = $this->general->griddata($postvar['tbl']);
        //pr($griddata);exit;
        $tbl = stripslashes($postvar['tbl']);
        $editpermission = $griddata['options']['edit'];
        $deletepermission = $griddata['options']['delete'];
        $viewpermission = $griddata['options']['view'];
        $fields = $griddata['colshead'];
        $page = $postvar['page']; // get the requested page
        $limit = $postvar['length']; // get how many rows we want to have into the grid 
        $sidx = $postvar['sidx']; // get index row - i.e. user click to sort 
        $sord = $postvar['sord']; // get the direction 
        $search = $postvar['search']['value']; // get the direction 
        $joins = $griddata['join'];
        $listorder = $griddata['listorder'];

        $user_timezone = $this->config->item('YT_USER_TIME_ZONE');
        $user_dateformat = $this->config->item('YT_USER_MYSQL_DATE_FORMAT');
        $timeFormat = $this->config->item('YT_USER_TIME_FORMAT');

        $user_timeformat = ($timeFormat == "12") ? " %h:%i %p" : " %h:%i:%s";

        if ($tbl != 'activities') {
            $this->datatables->select(implode(',', $fields), false)->from($tbl);
            if (is_array($joins) && count($joins) > 0) {
                foreach ($joins as $join) {
                    $this->datatables->join($join['tbl'], $join['cond'], $join['type']);
                }
            }
        }

        if (is_array($griddata['orderby']) && count($griddata['orderby']) && $postvar['draw'] == 1) {
            $this->datatables->orderby($griddata['orderby'][0], $griddata['orderby'][1]);
        } else {
            $this->datatables->get_sorting();
        }

        switch ($tbl) {
            case 'user_master':
                $orderby = 'user_master.dtModify';
                $type = 'DESC';

                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }

                $this->datatables->where('user_master.iCompanyId ="' . $this->config->item('YT_USER_COMPANY_ID') . '" AND user_master.isDelete != 1');
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }
                break;
            default :
                if (strtolower($this->config->item('YT_USER_PROFILE')) == "administration") {
                    $where = $tbl . '.iCompanyId ="' . $this->config->item('YT_USER_COMPANY_ID') . '" AND ' . $tbl . '.isDelete != 1';
                } else {
                    $where = $tbl . '.iUserId ="' . $this->session->userdata('iUserId') . '" AND ' . $tbl . '.isDelete != 1';
                }
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }
//                 if($search != ''){
//                $this->datatables->like($fields,$search);
//                }
                break;
        }
        $responce = json_decode($this->datatables->generate($tbl));
        $getdata = (array) $responce;
        $getdata1 = $getdata['aaData'];
//        pr($getdata1);exit;
        foreach ($getdata1 as $key => $value) {
            $tbl = trim($tbl);
//            pr($value[0]);exit;
            switch ($tbl) {
                case 'user_master':
                    $actiondata = '';

                    $u_mode = 'data-href';
                    $u_onclick = '" onclick="deleteUser(this);"';
                    $deleteurl = $griddata['delete_url'];

                    if ($viewpermission == 1)
                        $actiondata.= '
                        <a href="' . $griddata['view_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('view')) . '" class="listviewbtn listicon hidden" data-toggle="tooltip" data-original-title="View" data-placement="left"><i class="fa fa-eye"></i></a>';
                    if ($editpermission == 1)
                        $actiondata .= '<a href="' . $griddata['edit_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('edit')) . '" class="listeditbtn listicon" data-toggle="tooltip" data-original-title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>';

                    if ($deletepermission == 1 && $this->session->userdata('iUserId') != $value[0] && $this->config->item('YT_USER_SUPER_ADMIN_ID') != $value[0])
                    //  $actiondata.= '<a href="' . $griddata['delete_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('delete')) . '" class="dellink listdelbtn listicon text-danger Delete" data-toggle="tooltip" data-original-title="Delete" data-placement="left" data-type="' . $griddata['type'] . '"><i class="fa fa-trash-o"></i></a>';
                        $actiondata.= '<a ' . $u_mode . '="' . $deleteurl . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('delete')) . '&t=' . urlencode($this->general->encryptData($type)) . '&f=ajax&N=Change Owner" class="dellink listdelbtn listicon text-danger ' . $u_onclick . ' data-id="' . urlencode($this->general->encryptData($value[0])) . '" data-toggle="tooltip" data-original-title="Delete" data-placement="left"><i class="fa fa-trash-o"></i></a>';

                    $getdata1[$key][count($getdata1[$key])] = $actiondata;
                    break;
                default:
                    $actiondata = '';
                    //default edit and delete btn in listing with dynamic id (recordwise)
                    if ($viewpermission == 1)
                        $actiondata.= '
                        <a href="' . $griddata['view_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('view')) . '" class="listviewbtn listicon hidden" data-toggle="tooltip" data-original-title="View" data-placement="left"><i class="fa fa-eye"></i></a>';
                    if ($editpermission == 1)
                        $actiondata .= '<a href="' . $griddata['edit_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('edit')) . '" class="listeditbtn listicon" data-toggle="tooltip" data-original-title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>';

                    if ($deletepermission == 1)
                        $actiondata.= '<a href="' . $griddata['delete_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('delete')) . '" class="dellink listdelbtn listicon text-danger Delete" data-toggle="tooltip" data-original-title="Delete" data-placement="left" data-type="' . $griddata['type'] . '"><i class="fa fa-trash-o"></i></a>';

                    $getdata1[$key][count($getdata1[$key])] = $actiondata;
                    break;
            }
        }
        $getdata['aaData'] = $getdata1;

        echo json_encode($getdata);
        exit;
    }

    function forbidden() {
        $this->load->view('forbidden');
    }

    function browse_images() {
        $this->load->view('browse_images');
    }

    private function uploadImage($userId, $imgname) {
        
        $temp_folder_path = $this->config->item('upload_path') . 'users/' . $userId . '/';
        $this->general->createfolder($temp_folder_path);
        $name = $_FILES[$imgname]['name'];
        if (isset($name) && $name != "") {
            $file_name = date('YmdHis') . "_" . pathinfo($_FILES[$imgname]['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES[$imgname]['tmp_name'], $temp_folder_path . $file_name);
            echo $file_name;
        }
    }

    function getgridfields() {
        $postvar = $this->input->post();
        $getvar = $this->input->get();
        $griddata = $this->general->griddata($postvar['module'], 'inline');
        echo json_encode($griddata);
        exit;
    }
    
    public function verification_action() {
        $this->load->model('user/model_user');
        $postvar = $this->input->post();
        $email = $this->general->decryptData($postvar['d']);

        if ($postvar['register-agree-me'] == "Yes") {
            $user_exist = $this->model_user->checkDuplicate('vEmail', $email);
            if ($user_exist == 'false') {
                $this->model_user->changeStatus('user_master', 'vEmail', $email, 'Active');
                $this->session->set_flashdata('success', "Welcome to MEH, set your password.");
                redirect('reset_pass?d=' . urlencode($postvar['d']));
            } else {
                $this->session->set_flashdata('failure', "Your email does not exist.");
                redirect('signin');
            }
        }
    }

    function reset_pass() {
        $getvar = $this->input->get();
        $this->load->view('reset_pass', $getvar);
    }

    function resetpassword_action() {
        $this->load->model('user/model_user');
        $postvar = $this->input->post();
        $getvar = $this->input->get();
        $id = $this->general->decryptData($getvar['d']);

        $onetimepass = $this->general->decryptData($getvar['one']);

        if ($onetimepass != $postvar['onetimepass']) {
            $this->session->set_flashdata('failure', "Your oneTime password does not match, please check your e-mail");
            redirect('reset_pass?d=' . urlencode($getvar['d']) . '&one=' . urlencode($getvar['one']));
        }
        if ($postvar['confirmpass'] != $postvar['newpass']) {
            $this->session->set_flashdata('failure', "Your confirm password does not match with your password");
            redirect('reset_pass?d=' . urlencode($getvar['d']) . '&one=' . urlencode($getvar['one']));
        }
        $data['vPassword'] = md5($postvar['newpass']);
        $ext_cond = "iUserId = '" . $id . "'";
        $success = $this->model_user->update($data, $ext_cond);
        if ($success == '1') {
            $this->session->set_flashdata('success', "Your Password is changed Successfully.");
        } else {
            $this->session->set_flashdata('failure', "Please Try Again Later.");
        }
        redirect('signin');
    }

    function resetpass_action() {
        $this->load->model('user/model_user');
        $postvar = $this->input->post();
        $getvar = $this->input->get();
        $email = $this->general->decryptData($getvar['d']);

        if ($email != '') {
            $data['vPassword'] = md5($postvar['newpass']);
            $ext_cond = "vEmail = '" . $email . "'";
            $success = $this->model_user->update($data, $ext_cond);

            if ($success == '1') {
                $this->session->set_flashdata('success', "Your Password is changed Successfully.");

                $rply = $this->model_user->authenticate($email, $data['vPassword']);

                if ($rply['errorCode'] == 1) {//echo 1;exit;
                    $this->session->set_flashdata('success', 'Logged in successfully');

                    if ($this->session->userdata('iUserId') > 0) {
                        redirect('dashboard');
                    } else {
                        redirect('signin');
                    }
                } else if ($rply['errorCode'] == 3) {//echo 1;exit;
                    $this->session->set_flashdata('success', 'Logged in successfully');

                    if ($this->session->userdata('iUserId') > 0) {
                        redirect('cases');
                    } else {
                        redirect('signin');
                    }
                } else {
                    $this->session->set_flashdata('failure', $rply['errorMessage']);
                    redirect('signin');
                }


//            require_once(APPPATH . '/front-modules/user/controllers/user.php'); //include controller
//            $aObj = new User();  //create object 
//            $aObj->aut_action("automatic"); //call function
//            //$this->load->library('../controllers/instructor');
//
////$this->instructor->functioname();
            } else {
                $this->session->set_flashdata('failure', "Please Try Again Later.");
            }
        }
        redirect('reset_pass?d=' . $getvar['d']);
    }

    function saveImage() {
        $data = array();
        $new_file_name = 'tmp_file.png';
        $companyId = $this->config->item('YT_USER_COMPANY_ID');

        $postvar = $this->input->post();

        $postvar['field'] = trim($postvar['field']);
        $postvar['table'] = trim($postvar['table']);
        $postvar['idfield'] = trim($postvar['idfield']);
        $postvar['idvalue'] = trim($postvar['idvalue']);

        if ($postvar['idvalue'] != '') {
            $idValue = '/' . $postvar['idvalue'];
        } else {
            $idValue = '';
        }

        switch ($postvar['table']) {
            case 'user_master':
                $uploadFolder = "users";
                $imageDivId = "userImage";
                break;
            case 'lead_master':
                $uploadFolder = "leads";
                $imageDivId = "leadImage";
                break;
            case 'contact_master':
                $uploadFolder = "contacts";
                $imageDivId = "contactImage";
                break;
            default:
                break;
        }

        $folderPath = $uploadFolder . '/' . $companyId . $idValue;

        $upload_path = $this->config->item('upload_path') . $folderPath;
        $upload_url = $this->config->item('upload_url') . $folderPath;

        $temp_folder_path = $this->config->item('upload_path') . $folderPath;
        $this->general->createfolder($temp_folder_path);

        $img = $postvar['imgBase64'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        if ($idValue != '') {
            $new_file_name = $postvar['idvalue'] . '_' . date('YmdHis') . '.png';
        }
        $file = $upload_path . '/' . $new_file_name;
        $success = file_put_contents($file, $data);

        if ($success === false) {
            echo "failed";
        } else if (file_exists($file) && $idValue != '') {

            $new_img_url = $upload_url . '/' . $new_file_name;

            $fields = $postvar['field'];
            $ext_cond = $postvar['idfield'] . " = '" . $postvar['idvalue'] . "'";
            $reply = $this->model_support->getData($postvar['table'], $fields, array(), $ext_cond);
            $dbimage = $reply[0][$postvar['field']];

            if ($dbimage != '') {
                $img_path = $upload_path . '/' . $dbimage;
                if (file_exists($img_path)) {
                    unlink($img_path);
                }
            }
            $postvar1[$postvar['field']] = $new_file_name;
            $this->model_support->update($postvar['table'], $postvar1, $ext_cond);
            echo $imageDivId . "," . $new_img_url;
        }
        exit;
    }

    function deleteImage() {
        $data = array();
        $new_file_name = 'tmp_file.png';
        $companyId = $this->config->item('YT_USER_COMPANY_ID');

        $postvar = $this->input->post();

        $postvar['field'] = trim($postvar['field']);
        $postvar['table'] = trim($postvar['table']);
        $postvar['idfield'] = trim($postvar['idfield']);
        $postvar['idvalue'] = trim($postvar['idvalue']);

        switch ($postvar['table']) {
            case 'user_master':
                $uploadFolder = "users";
                $imageDivId = "userImage";
                break;
            case 'lead_master':
                $uploadFolder = "leads";
                $imageDivId = "leadImage";
                break;
            case 'contact_master':
                $uploadFolder = "contacts";
                $imageDivId = "contactImage";
                break;
            default:
                break;
        }

        $folderPath = $uploadFolder . '/' . $companyId . '/' . $postvar['idvalue'];
        $upload_path = $this->config->item('upload_path') . $folderPath;

        $fields = $postvar['field'];
        $ext_cond = $postvar['idfield'] . " = '" . $postvar['idvalue'] . "'";
        $reply = $this->model_support->getData($postvar['table'], $fields, array(), $ext_cond);
        $dbimage = $reply[0][$postvar['field']];

        if ($dbimage != '') {
            $img_path = $upload_path . '/' . $dbimage;
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }

        $postvar1[$postvar['field']] = '';
        $this->model_support->update($postvar['table'], $postvar1, $ext_cond);
        echo $imageDivId . "," . $this->config->item('images_url') . "owner_img.png";
    }

    function todo() {
        $user_timezone = $this->config->item('YT_USER_TIME_ZONE');
        //$today = date('Y-m-d H:i:s');

        $task_where = ' WHERE task_master.isDelete != 1 and task_master.eStatus <> "Completed"';
        $event_where = ' WHERE event_master.isDelete != 1 and event_master.eStatus <> "Completed"';
        $call_where = ' WHERE call_master.isDelete != 1 and call_master.eStatus = "Schedule" ';

        $upcomingquery = 'SELECT * FROM (
   SELECT task_master.iTaskId as id, task_master.vSubject as title, "task" as type, convert_tz(task_master.dtDue,"ETC/GMT","' . $user_timezone . '") as activity_date, "" as todate, task_master.eCallTo as eCallTo, task_master.iCallId as iCallId, task_master.eRelatedTo as eRelatedTo, task_master.iRelatedId as iRelatedId, convert_tz(task_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username FROM task_master LEFT JOIN user_master ON task_master.iCreatedBy=user_master.iUserId ' . $task_where . '
   UNION
   SELECT event_master.iEventId as id, event_master.vTitle as title,"event" as type, convert_tz(event_master.dtRepeatStartDate,"ETC/GMT","' . $user_timezone . '") as activity_date, event_master.dtRepeatEndDate as todate, event_master.eCallTo as eCallTo, event_master.iCallId as iCallId, event_master.eRelatedTo as eRelatedTo, event_master.iRelatedId as iRelatedId, convert_tz(event_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username FROM event_master LEFT JOIN user_master ON event_master.iCreatedBy=user_master.iUserId  ' . $event_where . '
   UNION
   SELECT call_master.iCallId as id, call_master.vSubject as title, "call" as type, convert_tz(call_master.dtCallStart,"ETC/GMT","' . $user_timezone . '") as activity_date, call_master.vCallDuration as todate, call_master.eCallTo as eCallTo, call_master.iCallToId as iCallId, call_master.eRelatedTo as eRelatedTo, call_master.iRelatedId as iRelatedId, convert_tz(call_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username FROM call_master LEFT JOIN user_master ON call_master.iCreatedBy=user_master.iUserId ' . $call_where . '
   ) d order by d.activity_date limit 5';
        $data['todo'] = $this->model_support->query($upcomingquery);
        $this->load->view('todo', $data);
    }

    function uptodo() {
        $postvar = $this->input->post();
        $type = $postvar['module'];
        $id = $this->general->decryptData($postvar['id']);
        $tbl = $where = '';
        $data['eStatus'] = 'Completed';

        switch (strtolower($type)) {
            case 'task':
                $tbl = 'task_master';
                $where = 'iTaskId = "' . $id . '"';
                break;
            case 'event':
                $tbl = 'event_master';
                $where = 'iEventId = "' . $id . '"';
                break;
            case 'call':
                $tbl = 'call_master';
                $where = 'iCallId = "' . $id . '"';
                break;
        }
        if ($tbl != '' && $where != '') {
            $data = $this->model_support->update($tbl, $data, $where);
            $result['type'] = 'success';
            $result['text'] = ucfirst($type) . ' has been updated successfully.';
        } else {
            $result['type'] = 'error';
            $result['text'] = ucfirst($type) . ' has been not updated.';
        }
        echo json_encode($result);
        exit;
    }

//    function sendNotification() {
//        $today = date('Y-m-d');
//        $fields = "*";
//        $task_ext_cond = 'DATE(dtReminder) ="' . $today . '" AND isDeleted != 1 AND eStatus != "Completed"';
//        $event_ext_cond = 'DATE(dtReminder) ="' . $today . '" AND isDeleted != 1 ';
//        $taskResult = $this->model_support->getData('task_master', $fields, array(), $task_ext_cond);
//        $eventResult = $this->model_support->getData('event_master', $fields, array(), $event_ext_cond);
//    }

    function getClickDeskData() {
        $username = 'support@middleeasthotel.com';
        //$password = 'Middle105*';
        $api_key = '9vi79mv9bsqd77bl99rpe3ucu7';
        $url = "https://my.clickdesk.com/rest/dev/api/gettickets/deensr12@hotmail.com";
        $ch = curl_init();
        if (!$ch) {
            die("Cannot allocate a new PHP-CURL handle");
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$api_key");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        $result = curl_exec($ch);
        //$info = curl_getinfo($ch);
        curl_close($ch);
        pr(json_decode($result, true));
        exit;
    }

    function quotation_request() {
        $getdata = $this->input->get();
        $getvar = $this->general->strip_get_post($getdata);

        $id = $this->general->decryptData($getvar['id']);

        $fields = "*";
        $ext_cond = 'iQuotationId = "' . $id . '"';
        $quotationData = $this->model_support->getData('quotation_master', $fields, array(), $ext_cond);
        $user_interest = $quotationData[0]['eUserInterest'];
        $quotation_name = $quotationData[0]['vQuotationName'];
        $passon_to_id = $quotationData[0]['iPassonToId'];
        $lead_id = $quotationData[0]['iLeadId'];
        $user_id = $quotationData[0]['iUserId'];
        $company_id = $quotationData[0]['iCompanyId'];

        if ($user_interest == "No") {
            $updatevar['eUserInterest'] = "Yes";
            $this->model_support->update('quotation_master', $updatevar, $ext_cond);

            $insertvar['vSubject'] = 'Quotation - (' . $quotation_name . ') Request';
            $insertvar['eCallTo'] = 'Lead';
            $insertvar['iCallId'] = $lead_id;
            $insertvar['dtDue'] = date('Y-m-d', strtotime("+2 days"));
            $insertvar['ePriority'] = 'High';
            $insertvar['iAssignedId'] = $passon_to_id;
            $insertvar['eRepeat'] = 'No';
            $insertvar['eRelatedTo'] = '';
            $insertvar['iRelatedId'] = '0';
            $insertvar['iCompanyId'] = $company_id;
            $insertvar['iCreatedBy'] = $user_id;
            $insertvar['dtCreated'] = date('Y-m-d H:i:s');
            $insertvar['iModifyBy'] = $user_id;
            $insertvar['dtModify'] = date('Y-m-d H:i:s');
            $insertvar['isDelete'] = 0;
            $insertvar['eStatus'] = "Not Started";
            $task_id = $this->model_support->insert('task_master', $insertvar);

            $addActivity['iUserId'] = $user_id;
            $addActivity['iItemId'] = $passon_to_id;
            $addActivity['eItemType'] = 'User';
            $addActivity['eItemUrl'] = strtolower('Task') . '_view?id=' . urlencode($this->general->encryptData($task_id)) . '&m=' . urlencode($this->general->encryptData('view')) . '&f=' . urlencode($this->general->encryptData('activities'));
            $addActivity['tMessage'] = 'The Task - (' . $insertvar['vSubject'] . ') has been assigned.';
            $addActivity['dtCreated'] = date('Y-m-d H:i:s');
            $this->model_support->insertActivity($addActivity);
        }

        $this->load->view('quotation_request');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
