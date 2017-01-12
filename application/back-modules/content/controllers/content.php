<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // $dat=array();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//        $this->general->checkSession();
        $this->load->library('Datatables');
        $this->load->model('model_support');
    }

    public function index() {
        //$this->load->view('index');
        redirect('login');
    }

    public function list_ajax() {
        $this->load->model('model_support');
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        $griddata = $this->general->admin_griddata($postvar['tbl']);
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
        $main_tbl = $tbl;

        if ($tbl != 'vehicle_master') {
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
//        pr($tbl);exit;
        switch ($tbl) {
            case 'role_master' :

                $orderby = 'role_master.iRoleId';
                $type = 'ASC';


                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "isDelete != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }
                
                break;
            case 'user_master' :

                $orderby = 'user_master.dtUpdatedDate';
                $type = 'DESC';

                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "iIsDeleted != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }

                break;
            case 'vehicle_master' :

                $orderby = 'vehicle_type_master.dtUpdatedDate';
                $type = 'DESC';


                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "vehicle_type_master.iIsDeleted != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }

                break;
            case 'shipment_master' :

                $orderby = 'shipment_master.dtUpdatedDate';
                $type = 'DESC';


                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "iIsDeleted != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }

                break;
            case 'location_master' :

                $orderby = 'location_master.dtUpdatedDate';
                $type = 'DESC';


                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "iIsDeleted != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }

                break;
            case 'module_master' :

                $orderby = 'module_master.eMenuType asc ,module_master.dtCreated';
                $type = 'DESC';


                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "isDelete != 1 and eStatus = 'Active'";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }

                break;
            case 'admin' :

                $orderby = 'admin.dtCreated';
                $type = 'DESC';


                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "isDelete != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }

                break;
            default :

                $orderby = $tbl . '.dtCreated';
                $type = 'DESC';

                if ($orderby != '') {
                    $this->datatables->orderby($orderby, $type);
                } else {
                    $this->datatables->get_sorting();
                }
                $where = "isDelete != 1";
                $this->datatables->where($where, null, false);
                if ($search != '') {
                    $this->datatables->like($fields, $search);
                }
                break;
        }
        $responce = json_decode($this->datatables->generate($tbl));
//        pr($responce,1);
        $getdata = (array) $responce;
        $getdata1 = $getdata['aaData'];
//        pr($getdata1);exit;
        foreach ($getdata1 as $key => $value) {
            $tbl = trim($tbl);
//            pr($value);
            switch ($tbl) {
                case 'admin':
                    $actiondata = '';
                    
                    if ($viewpermission == 1)
                        $actiondata.= '
                        <a href="' . $griddata['view_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('view')) . '" class="listviewbtn listicon hidden" data-toggle="tooltip" data-original-title="View" data-placement="left"><i class="fa fa-eye"></i></a>';
                    if ($editpermission == 1)
                        $actiondata .= '<a href="' . $griddata['edit_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('edit')) . '" class="listeditbtn listicon" data-toggle="tooltip" data-original-title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>';

                    if ($deletepermission == 1)
                        $actiondata.= '<a href="' . $griddata['delete_url'] . '?id=' . urlencode($this->general->encryptData($value[0])) . '&m=' . urlencode($this->general->encryptData('delete')) . '" class="dellink listdelbtn listicon text-danger Delete" data-toggle="tooltip" data-original-title="Delete" data-placement="left" data-type="' . $griddata['type'] . '"><i class="fa fa-trash-o"></i></a>';
//                    echo $deletepermission;exit;
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
//                    echo $deletepermission;exit;
                    $getdata1[$key][count($getdata1[$key])] = $actiondata;
                    break;
            }
        }
        $getdata['aaData'] = $getdata1;
//        pr($getdata);
        echo json_encode($getdata);
        exit;
    }

    function getProfileImage() {
        $ext_cond = "iUserId = " . $this->session->userdata('iUserId') . "";
        $res = $this->model_support->getData('user_master', 'vProfileImage', array(), $ext_cond);
//        pr($res);
        if ($res[0]['vProfileImage'] != '') {
            echo $this->config->item('upload_url') . 'users/' . $this->session->userdata('iUserId') . '/' . $res[0]['vProfileImage'];
        } else {
            echo $this->config->item('assets_url') . 'images/noimage.png';
        }
        exit;
    }

    function getProfileName() {
        $ext_cond = "iUserId = " . $this->session->userdata('iUserId') . "";
        $res = $this->model_support->getData('admin', 'concat(vFirstName," ",vLastName) as Name', array(), $ext_cond);
//        pr($res);
        if ($res[0]['Name'] != '') {
            echo $res[0]['Name'];
        } else {
            echo '';
        }
        exit;
    }

    function remove_images() {
        $postData = $this->input->post();
        unlink($this->config->item('upload_path') . 'editor_files/' . $this->session->userdata('iUserId') . '/' . $postData['name']);
        echo 1;
        exit;
    }

    function browse_images() {
        $this->load->view('browse_images');
    }

    public function imageupload() {
        $ImageFile = $_FILES["upload"];
        if (file_exists($this->config->item('upload_path') . 'editor_files/' . $this->session->userdata('iUserId') . '/' . $ImageFile['name'])) {
            echo 'Image alredy exists.';
            exit;
        }
        if ($ImageFile['name'] != '') {
            $this->load->library('upload');
            $temp_folder_path = $this->config->item('upload_path') . 'editor_files/' . $this->session->userdata('iUserId');
            $this->general->createfolder($temp_folder_path);
            $file_name = $ImageFile['name'];

            $upload_config = array(
                'upload_path' => $temp_folder_path,
                'allowed_types' => "jpg|jpeg|gif|png", //*
                'max_size' => 1028 * 1028 * 2,
                'file_name' => $file_name,
                'remove_space' => TRUE,
                'overwrite' => TRUE
            );

            $this->upload->initialize($upload_config);

            if ($this->upload->do_upload('upload')) {
                $file_info = $this->upload->data();
            }
        }
        echo 'uploaded succesfully';
        exit;
    }

    function getgridfields() {
        $postvar = $this->input->post();
        $getvar = $this->input->get();
        $griddata = $this->general->admin_griddata($postvar['module'], 'inline');
        echo json_encode($griddata);
        exit;
    }

    /**
     * Check the contact us form detail 
     *
     * Function for contact us form detail are exist or not. 
     *
     * @return	string
     */
    function contact_us() {
        $postvar = $this->input->post();
        if ($postvar['record_already_exists'] == "1") {
            $post_arr = $this->general->restorePost($postvar['frmpostdata']);
            $this->smarty->assign('post_arr', $post_arr);
        }
        $this->load->view('contact_us');
    }

    /**
     * Insert the contact us form detail 
     *
     * Function for contact us form detail are insert and send mail to admin. 
     *
     * @param $postvar value 
     * @return	string
     */
    function contactus_action() {
        $postvar = $this->input->post();
        $data = array();
        $data['vName'] = stripslashes($postvar['name']);
        $data['vEmail'] = stripslashes($postvar['email']);
        $data['vPhone'] = stripslashes($postvar['phone']);
        $data['tComments'] = stripslashes($postvar['comment']);

        $data['vFromName'] = $data['vName'];
        $data['vFromEmail'] = $data['vEmail'];
        $data['vEmail'] = $this->config->item('EMAIL_ADMIN');

        $success = $this->general->sendMail($data);  //   send mail

        $this->session->set_flashdata("success", 'Your contact request sent successfully.');
        exit;
    }

    function history_upcoming() {
        $getvar = $this->input->get();
        $id = $this->general->decryptData($getvar['item_id']);
        $type = ucfirst($getvar['type']);
        $user_timezone = $this->config->item('YT_USER_TIME_ZONE');

        if (strtolower($this->config->item('YT_USER_PROFILE')) == "administration") {
            $cond = 'activity_master.iCompanyId ="' . $this->config->item('YT_USER_COMPANY_ID') . '" AND ';
        } else {
            $cond = 'activity_master.iUserId ="' . $this->session->userdata('iUserId') . '" AND ';
        }

        // history data
        $fields = 'activity_master.*,DATE(activity_master.dtCreated) as date, convert_tz(activity_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username';
        $join = array(array('table' => 'user_master', 'condition' => 'user_master.iUserId = activity_master.iUserId', 'jointype' => 'left'));
        $cond .= 'activity_master.eItemType = "' . $type . '" AND activity_master.iItemId = "' . $id . '"';
        $order_by = 'dtCreated DESC';

        $reply = $this->model_support->getData('activity_master', $fields, $join, $cond, $order_by);
//       echo $query = 'SELECT activity_master.*, DATE(activity_master.dtCreated) AS DATE, CONVERT_TZ(activity_master.dtCreated, "ETC/GMT", "Asia/Calcutta") AS created_date, CONCAT(user_master.vSalutation, " ", user_master.vFirstName, " ", user_master.vMiddleName, " ", user_master.vLastName) AS username 
//FROM `activity_master` LEFT JOIN `user_master` ON `user_master`.`iUserId` = `activity_master`.`iUserId` 
//WHERE (activity_master.eItemType = "'.$type.'" AND activity_master.iItemId = '.$id.' ) 
//OR (activity_master.eItemType = "Task" AND activity_master.iItemId IN (SELECT iTaskId FROM task_master WHERE (eCallTo = "'.$type.'" AND iCallId = '.$id.') OR ( eRelatedTo = "'.$type.'" AND iRelatedId = '.$id.')))
//OR (activity_master.eItemType = "Event" AND activity_master.iItemId IN (SELECT iEventId FROM event_master WHERE (eCallTo = "'.$type.'" AND iCallId = '.$id.') OR ( eRelatedTo = "'.$type.'" AND iRelatedId = '.$id.')))
//OR (activity_master.eItemType = "Call" AND activity_master.iItemId IN (SELECT iCallId FROM call_master WHERE (eCallTo = "'.$type.'" AND iCallToId = '.$id.') OR (eRelatedTo = "'.$type.'" AND iRelatedId = '.$id.')))
//ORDER BY `dtCreated` DESC';
//        $reply = $this->model_support->query($query);
        $data['activitylist'] = $reply;

        $today = date('Y-m-d H:i:s');

        // upcoming data

        $upcomingquery = 'SELECT * FROM (
    SELECT task_master.iTaskId as id, task_master.vSubject as title, "task" as type, DATE(task_master.dtDue) as date, task_master.dtDue as activity_date, "blank" as todate, convert_tz(task_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username FROM task_master LEFT JOIN user_master ON task_master.iCreatedBy=user_master.iUserId WHERE eCallTo = "' . $type . '" AND task_master.isDelete != 1 AND task_master.iCallId = ' . $id . '
    UNION
    SELECT event_master.iEventId as id, event_master.vTitle as title,"event" as type, DATE(event_master.dtDue) as date, event_master.dtRepeatStartDate as activity_date, event_master.dtRepeatEndDate as todate, convert_tz(event_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username FROM event_master LEFT JOIN user_master ON event_master.iCreatedBy=user_master.iUserId WHERE eCallTo = "' . $type . '" AND event_master.isDelete != 1 AND event_master.iCallId = ' . $id . '
    UNION
    SELECT call_master.iCallId as id, call_master.vSubject as title, "call" as type, DATE(call_master.dtCallStart) as date, call_master.dtCallStart as activity_date, call_master.vCallDuration as todate, convert_tz(call_master.dtCreated,"ETC/GMT","' . $user_timezone . '") as created_date, CONCAT(user_master.vSalutation," ",user_master.vFirstName," ",user_master.vMiddleName," ",user_master.vLastName) as username FROM call_master LEFT JOIN user_master ON call_master.iCreatedBy=user_master.iUserId WHERE eCallTo = "' . $type . '"  AND call_master.isDelete != 1 AND call_master.iCallToId = ' . $id . '
    ) d WHERE activity_date > "' . $today . '" order by d.activity_date';
        $result = $this->model_support->query($upcomingquery);

        $data['upcominglist'] = $result;
        $this->load->view('history_upcoming', $data);
    }

    function updateviewdata() {
        $postvar = $this->input->post();
        $data = array();
        $postvar['value'] = trim($postvar['value']);
        $postvar['field'] = trim($postvar['field']);
        $postvar['tbl'] = trim($postvar['tbl']);
        $postvar['idfield'] = trim($postvar['idfield']);
        $postvar['idval'] = trim($postvar['idval']);

        //preparing db data
        $data[$postvar['field']] = $postvar['value'];
        //condition for update record
        $cond = $postvar['idfield'] . ' = ' . $postvar['idval'];
        $success = $this->model_support->update($postvar['tbl'], $data, $cond);
//        $data['vFromName'] = $data['vName'];
//        $data['vFromEmail'] = $data['vEmail'];
//        $data['vEmail'] = $this->config->item('EMAIL_ADMIN');
//        $success = $this->general->sendMail($data);  //   send mail
//        $this->session->set_flashdata("success", 'Your contact request sent successfully.');
        echo $success;
        exit;
        /* auther: Ravi Patel */
    }

    public function verification() {
        $this->load->model('user/model_user');
        $getdata = $this->input->get();
        $getvar = $this->general->strip_get_post($getvar);
        $email = $this->general->decryptData($getvar['d']);
        $fields = "*";
        $ext_cond = 'vEmail ="' . $email . '"';
        $reply = $this->model_user->getData($fields, array(), $ext_cond);
        if (is_array($reply) && count($reply) > 0) {
            $status = $reply[0]['eStatus'];
            if (strtolower($status) == "active") {
                $this->session->set_flashdata('failure', "Your account has already been verified. Please signin to continue");
                redirect('signin');
            } else if (strtolower($status) == "pending") {
                $this->load->view('content/terms_condition');
            }
        } else {
            echo "bad url";
        }
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

    function forbidden() {
        $this->load->view('forbidden');
    }

    public function auto_generate_invoice() {
        $fields = 'iUserPackageId,iUserId,iPackageId,vName,dtStartDate,dtExpireDate';
        $where = 'eStatus = "Active" and isDelete = 0 and DATE_FORMAT(dtExpireDate,"%Y-%m-%d" ) = "' . date('Y-m-d') . '"';
        $record = $this->model_support->getData('user_package', $fields, array(), $where);

        if (is_array($record) && count($record) > 0) {
            foreach ($record as $key => $value) {
                $iPackageId = $value['iPackageId'];
                $userid = $value['iUserId'];
                $pack_cond = 'iPackageId = "' . $iPackageId . '"';
                $package = $this->model_support->getData('package_master', '*', array(), $pack_cond);

                $user_cond = 'iUserId = "' . $userid . '"';
                $userdata = $this->model_support->getData('user_master', '*', array(), $user_cond);

                $data['iUserId'] = $userid;
                $data['iPackageId'] = $package[0]['iPackageId'];
                $data['vName'] = $package[0]['vName'];
                $data['ePackageFor'] = $package[0]['ePackageFor'];
                $data['vSpeedLimit'] = $package[0]['vSpeedLimit'];
                $data['eSpeedLimitType'] = $package[0]['eSpeedLimitType'];
                $data['ePackageType'] = $package[0]['ePackageType'];
                $data['eIsInstallationCharge'] = 'No';
                $data['eFUP'] = $package[0]['eFUP'];
                $data['eFUPLimitType'] = $package[0]['eFUPLimitType'];
                $data['vAfterFUP'] = $package[0]['vAfterFUP'];
                $data['eAfterFUPType'] = $package[0]['eAfterFUPType'];
                $data['vFUPLimit'] = $package[0]['vFUPLimit'];
                $data['tDescription'] = $package[0]['tDescription'];
                $data['fAmount'] = $package[0]['fAmount'];
                $data['fInstallationCharge'] = 0;
                $StartEnd = $this->package_startdate_enddate($package[0]['ePackageType']);
                $data['dtStartDate'] = $StartEnd['start'];
                $data['dtExpireDate'] = $StartEnd['end'];
                $data['dtCreated'] = $data['dtModify'] = date('Y-m-d H:i:s');
                $data['iCreatedBy'] = $data['iModifyBy'] = $this->session->userdata('iAdminId');
                $data['isDelete'] = 0;
                $userpackid = $this->model_support->insert('user_package', $data);

                $invoice_data['vInvoiceNo'] = $this->general->generateTransactionNumber();
                $invoice_data['iUserPackageId'] = $userpackid;
                $invoice_data['iUserId'] = $userid;
                $invoice_data['tDescription'] = $package[0]['tDescription'];
                $invoice_data['fAmount'] = $package[0]['fAmount'];
                $invoice_data['fInstallationCharge'] = 0;
                $package_charge = $package[0]['fAmount'];
                $semitotal = (0) + ($package[0]['fAmount'] != '') ? $package[0]['fAmount'] : 0;
                $total = $semitotal + (($semitotal * $this->config->item('SERVICE_TAX')) / 100);
                $roundTotal = round($total);
                $invoice_data['fTotalAmout'] = $roundTotal;
                $invoice_data['fRemainingAmount'] = $roundTotal;
                $invoice_data['dtCreated'] = date('Y-m-d H:i:s');


                $invoice_data['eStatus'] = ($total <= 0) ? 'Paid' : 'Unpaid';
                $invoiceid = $this->model_support->insert('invoice_master', $invoice_data);

                $update['eStatus'] = 'Inactive';
                $ext_cond = 'iUserId=' . $userid . ' and iUserPackageId !=' . $userpackid;
                $update_id = $this->model_support->update('user_package', $update, $ext_cond);

                $fields_user = '*';
                $cond = "iUserId='" . $userid . "'";
                $result = $this->model_support->getData('user_master', $fields_user, array(), $cond);
                $contrycond = 'iCountryId="' . $result[0]['iBillingCountry'] . '"';
                $country = $this->model_customer->getData_new('country', 'vCountry', $contrycond);

                $email = $result[0]['vEmail'];
                $name = $result[0]['vFirstName'] . " " . $result[0]['vLastName'];
                $this->load->model('tools/emailer');
                if ($userpackid > 0) {
                    $link = $this->config->item('site_url') . 'payment?id=' . $this->general->encryptData($invoiceid);
                    $emaildata['vEmail'] = $email;
                    $emaildata['name'] = $name;
                    $emaildata['packagename'] = $package[0]['vName'];
                    $emaildata['invoiceno'] = $invoice_data['vInvoiceNo'];
                    $emaildata['total'] = $total;
                    $emaildata['amount'] = $invoice_data['fTotalAmout'];
                    $emaildata['url'] = $link;
                    $emaildata['invoice_date'] = $invoice_data['dtCreated'];
                    $emaildata['address'] = $result[0]['vBillingAddress'] . " " . $result[0]['vBillingAddress2'];
                    $emaildata['city'] = $result[0]['vBillingCity'];
                    $emaildata['state'] = $result[0]['vBillingState'];
                    $emaildata['zip'] = $result[0]['vBillingZip'];
                    $emaildata['country'] = $country[0]['vCountry']; //$result[0][''];
                    $emaildata['packagecharge'] = $package_charge;
                    $emaildata['servicecharge'] = (($semitotal * $this->config->item('SERVICE_TAX')) / 100);
                    $emaildata['roundvalue'] = printf("%+d", ($roundTotal - $total));
                    $emaildata['startdate'] = $value['dtStartDate'];
                    $emaildata['enddate'] = $value['dtExpireDate'];
                    $emaildata['installationcharge'] = "0.00";


                    // date , customer name, address,Package Name , Package start & end date 
//                    $success = $this->general->send_email($emaildata,'SERVICE_INVOICE');
//                    if($result[0]['vMobile'] != ''){
//                        $sms = 'Your internet package is purchased successfully from VihaanYT.You You want to online payment '.$link;
//                        $this->general->send_sms($result[0]['vMobile'], $sms);
//                    }
                }
            }
        }
        return 1;
    }

    private function package_startdate_enddate($type, $date = '') {
        if ($date == '') {
            $date = date('Y-m-d H:i:s');
        }
        if ($type == 'Yearly') {
            $start = $date;
            $end = date('Y-m-d H:i:s', strtotime($data . '+ 1 year'));
        } elseif ($type == 'Half_Yearly') {
            $start = $date;
            $end = date('Y-m-d H:i:s', strtotime($data . '+ 6 month'));
        } elseif ($type == 'Quarterly') {
            $start = $date;
            $end = date('Y-m-d H:i:s', strtotime($data . '+ 3 month'));
        } else {
            $start = $date;
            $end = date('Y-m-d H:i:s', strtotime($data . '+ 1 month'));
        }
        $return['start'] = $start;
        $return['end'] = $end;
        return $return;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
