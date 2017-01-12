<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // $dat=array();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->general->checkSession();
        $this->load->model('model_admin');
    }

    public function login() {
        if ($this->session->userdata('iAdminId') != '') {
            redirect('dashboard');
        } else {
            $cookiearr = $this->cookie->read('userarray');
            $data['vUserName'] = '';
            $data['vPassword'] = '';
            $data['eRemember'] = '';

            if (is_array($cookiearr) && $cookiearr['nspl_username'] != '') {
                $data['vUserName'] = $cookiearr['nspl_username'];
                $data['vPassword'] = $cookiearr['nspl_password'];
                $data['eRemember'] = 'On';
            }
            $this->load->view('login', $data);
        }
    }

    public function login_action() {
        $this->load->helper('date');
        $postarr = $this->input->post();
        //set_cookie
        $this->general->checkSession();
        $this->load->library('cookie');

        if ($postarr['login-remember-me'] == 'on') {
            $cookiedata = array(
                'nspl_username' => $postarr['login-email'],
                'nspl_password' => $postarr['login-password']
            );
            $this->cookie->write('userarray', $cookiedata);
        } else {
            $cookiedata = array(
                'nspl_username' => '',
                'nspl_password' => ''
            );
            $this->cookie->write('userarray', $cookiedata);
        }
        
        //login-authentication
        $this->load->model('model_log_history');
        $this->load->model('model_admin');
        $rply = $this->model_admin->authenticate($postarr['login-email'], md5($postarr['login-password']));

        if ($rply['errorCode'] == 1) {

            if ($data['iLogId'] == '') {
                $data['iUserId'] = $this->session->userdata('iAdminId');
                $data['vSessionId'] = $this->general->encryptData($postarr['login-email'] . date('Y-m-d h:i:s'));
                $data['vIP'] = $this->input->ip_address();
                $data['eUserType'] = $rply['role'];
                $data['dLoginDate'] = date('Y-m-d H:i:s');
            }
            $this->model_log_history->insert($data);
            $this->session->set_flashdata('success', "Welcome to ".$this->config->item('CPANEL_TITLE').".");
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('failure', 'Username or password is incorrect.');
            redirect('login');
        }
    }

    public function logout() {
        $this->load->helper('date');
        $this->load->model('model_log_history');
        $this->load->model('model_admin');
        $fields = "";
        $query = "(select max(iLogId) as iLogId from log_history where iUserId = '" . $this->session->userdata('iAdminId') . "' and eUserType != 'Reporter')";
        $getval = $this->model_log_history->query($query);
        $id = $getval[0]['iLogId'];
        $ext_con = "iLogId = '" . $id . "'";
//        $ext_con = "iLogId in ";
        $data['dLogoutDate'] = date('Y-m-d H:i:s');
        $this->model_log_history->update($data, $ext_con);

        //admin lastaccess query
//        $ext_cond = 'iAdminId = "' . $this->session->userdata('iAdminId') . '"';
//        $lastAccess['dLastAccess'] = date('Y-m-d H:i:s');
//        $this->model_admin->update($lastAccess, $ext_cond);

        $this->session->sess_destroy();
        redirect('login');
    }

    public function dashboard() {
        $fields="shipment_master.vTitle', 'shipment_master.vContactNo', 'DATE_FORMAT(shipment_master.vPreferredDate,'%d-%b-%Y')', 'shipment_master.eStatus'";
        $ext_cond="shipment_master.eStatus ='Pending' AND shipment_master.iIsDeleted =0";
        $res=$this->model_admin->get_data($fields,'shipment_master',array(), $ext_cond);
//        echo $this->db->last_query();
        //pr($res);exit;
        $data['pending_shipment']= $res;
        $this->load->view('dashboard', $data);
    }

    public function admins() {
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('list', 'admins');
        }

        if ($getvar['id'] != '' && $getvar['m'] != '') {
            //delete
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            if ($mode == 'delete') {
                $iAdminId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                $ext_cond = "iAdminId =" . $iAdminId;
                $update['isDelete'] = "1";
                $update['iDeleteBy'] = $this->session->userdata('iAdminId');
                $this->model_admin->update($update, $ext_cond);
                $this->session->set_flashdata("success", "Data deleted successfully");
                redirect('admins');
            }
        }
        $data['sublist'] = "notreq";

        $this->load->view('admins_list', $data);
    }

    public function admin_add() {
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('form', 'admin_add');
        }


        $status = $this->general->getEnumValues("admin", "eStatus");
        $where = "eRoleType = 'Back'";
        $role = $this->model_admin->get_data("iRoleId,vRole", "role_master", "", $where);
//         echo $this->db->last_query();exit;
        $flaguserId = urldecode($this->general->decryptData($getvar['id']));
        if ($getvar != '') {
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            $fields = "*";
            $ext_cond = 'iAdminId ="' . $flaguserId . '"';
            $reply = $this->model_admin->getData($fields, array(), $ext_cond);
            $data['all'] = $reply;
            if ($getvar['p'] != '' && $this->general->decryptData($getvar['p']) == "view") {
                $frompage = "view";
            }
        } else {
            $mode = "add";
        }
        $data['role'] = $role;
        $data['status'] = $status;
        $data['mode'] = $mode;
        $data['parents'] = $parents;
//        pr($data);exit;
        $this->load->view('admin_add', $data);
    }

    public function admin_action() {
        $postvar = $this->input->post();
        $submit = $postvar['submit'][0];
        $id = $postvar['iAdminId'];
        $mode = $postvar['mode'];
        $pascheck = $postvar['chnagepassval'];
        unset($postvar['iAdminId']);
        unset($postvar['chnagepassval']);
        unset($postvar['submit']);
        unset($postvar['mode']);
        unset($postvar['vPassword2']);
        if ($postvar['vPassword'] != '') {
            $postvar['vPassword'] = md5($postvar['vPassword']);
        }
        if ($id != '' && $mode == 'edit') {
            if ($pascheck != '1') {
                unset($postvar['vPassword']);
            }
            $ext_cond = "iAdminId =" . $id;
            $postvar['iModifyBy'] = $this->session->userdata('iAdminId');
            $postvar['dtModify'] = date('Y-m-d H:i:s');
            $rply = $this->model_admin->update($postvar, $ext_cond);
        } else {
            $postvar['iCreatedBy'] = $this->session->userdata('iAdminId');
            $postvar['dtCreated'] = date('Y-m-d H:i:s');
            $postvar['iModifyBy'] = $this->session->userdata('iAdminId');
            $postvar['dtModify'] = date('Y-m-d H:i:s');
            $postvar['isDelete'] = 0;
            $rply = $this->model_admin->insert($postvar);
        }
        if ($submit == "savenew")
            redirect('admin_add');
        else
            redirect('admins');

        exit;
    }

    public function chnge_role_admin() {
        $this->load->model('model_admin');
        $postvar = $this->input->post();
        $ext_cond = 'iAdminId = "' . $postvar['iAdminId'] . '"';
        unset($postvar['iAdminId']);
        $rply = $this->model_admin->update($postvar, $ext_cond);
        echo $rply;
        exit;
    }

    public function forgotpassword() {
        $this->load->view('forgotpassword');
    }

    public function forgotpassword_action() {
        $this->load->model('model_admin');
        $postvar = $this->input->post();
        $vemail = $postvar['login_email'];
//        echo $vemail;exit;
        $user_exist = $this->model_admin->getForgotPassword($vemail);
        if (is_array($user_exist) && count($user_exist) > 0) {
            $onetimepass = $this->general->getRandomNumber('8');
            $this->db->set('vPassword', "md5('$onetimepass')", false);
            $this->db->where('iAdminId', $user_exist[0]['iAdminId']);
            $res = $this->db->update('admin');
            $this->load->model('tools/emailer');
            $user_exist[0]['onetimepass'] = $onetimepass;
            $success = $this->emailer->send_mail($user_exist[0], 'FORGOT_PASSWORD');
            if ($success == 1) {
                $this->session->set_flashdata('success', " We just sent you an email with instructions to reset your password.");
            } else {
                $this->session->set_flashdata('failure', "error in sending mail,please check again");
            }
        } else {
            $this->session->set_flashdata('failure', "Account does not exists");
        }
        redirect('login');
    }

    function changeStatus() {
        $postvar = $this->input->post();
        $table = $postvar['table'];
        $primaryField = $postvar['primaryField'];
        $id = $postvar['primaryId'];
        $st = $postvar['status'];
        $success = $this->model_admin->changeStatus($table, $primaryField, $id, $st);
//        if ($success == 1) {
//                $this->session->set_flashdata('success', "Status Successfully Changed.");
//            } else {
//                $this->session->set_flashdata('failure', "Status Not Changed.");
//            }
        echo $success;
        exit;
    }

    public function checkEmail() {
        $this->load->model('model_admin');
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        $tbl = '';

        if ($postvar['vEmail'] != '') {
            if ($getvar['tablename'] != '') {
                $tbl = $getvar['tablename'];
            }
            if ($getvar['id'] != '' || $getvar['id'] != 'undefined') {
                $ext_cond = "vEmail ='" . $postvar['vEmail'] . "' and iAdminId !='" . $getvar['id'] . "'";
            } else {
                $ext_cond = "vEmail ='" . $postvar['vEmail'] . "'";
            }
            $ext_cond.=" and isDelete != 1";

            echo $this->model_admin->getUserValidation('vEmail', $postvar['vEmail'], $tbl, $ext_cond);
            exit;
        }
        exit;
    }

    public function checkUser() {
        $this->load->model('model_admin');
        $postvar = $this->input->post();
        $getvar = $this->input->get();
        $tbl = '';
        if ($postvar['vUserName'] != '') {
            if ($getvar['tablename'] != '') {
                $tbl = $getvar['tablename'];
            }
            if ($getvar['id'] != '') {
                $ext_cond = "vUserName ='" . $postvar['vUserName'] . "' and iAdminId !=" . $getvar['id'];
            } else {
                $ext_cond = "vUserName ='" . $postvar['vUserName'] . "'";
            }
            $ext_cond.=" and isDelete != 1";

            echo $this->model_admin->getUserValidation('vUserName', $postvar['vUserName'], $tbl, $ext_cond);
            exit;
        }

        exit;
    }

    function verification() {
        $path = $this->config->item('site_path');
        include_once ($path . "application/back-modules/admin/views/verification.php");
        exit;
    }

    function verification_denied() {
        $path = $this->config->item('site_path');
        include_once ($path . "application/back-modules/admin/views/verification_denied.php");
        exit;
    }

    public function updateTheme() {
        $this->load->model('model_admin');

        $keyword = $this->input->post('theme');
        $admin_id = $this->session->userdata('iAdminId');
        $cond = "iAdminId = '$admin_id'";

        $data['vTheme'] = $keyword;
        $result = $this->model_admin->update($data, $cond);
        $this->session->set_userdata('theme', $keyword);
        echo true;
        exit;
    }

    function map() {
        $this->load->model('model_admin');

        $lat = $this->session->userdata('lat');
        $long = $this->session->userdata('long');
        $this->smarty->assign('data', json_encode($data));
        $this->smarty->assign('type', $type);
        $this->smarty->assign('lat', json_encode($lat));
        $this->smarty->assign('long', json_encode($long));
    }

    function setlatlong() {
        $postvar = $this->input->post();
        $flag = 0;
        if (!$this->session->userdata('lat') && $this->session->userdata('lat') == '') {
            $flag = 1;
        }
        $this->session->set_userdata("lat", $postvar['lat']);
        $this->session->set_userdata("long", $postvar['long']);
        echo $flag;
        exit;
    }

    public function system_setting() {
        $data['appearance'] = $this->model_admin->system_setting('Appearance');
        $data['social'] = $this->config->item('SOCIAL_ICONS');
        $this->load->view('system_setting', $data);
    }

    public function system_setting_action() {
        $postvar = $this->input->post();
        foreach ($postvar as $key => $value) {
            $this->model_admin->update_system_setting($key, $value);
        }
        redirect('system_setting');
    }

    public function my_profile() {
        $getvar = $this->input->get();
        $tbl = 'admin';
        $fields = "*";
        $data = array();
        $mode = 'edit';
        $ext_cond = 'iAdminId ="' . $this->session->userdata('iAdminId') . '"';
        $reply = $this->model_admin->getData($fields, $ext_cond, $join);
        $data['all'] = $reply;
        $data['admin_id'] = $reply[0]['iAdminId'];

        $data['mode'] = $mode;
        $this->load->view('my_profile', $data);
    }

//
    public function email_exists() {
        $postvar = $this->input->post();
//        pr($postvar);exit;
        $cond = 'vEmail = "' . trim($postvar['vEmail']) . '"';
        if (isset($postvar['Id']) && $postvar['Id'] != '')
            $cond.=' AND iAdminId != ' . $this->general->decryptData($postvar['Id']);
        $tbl = 'admin';
        $field = 'vEmail';
        $result = $this->model_admin->getData($field, $cond);
        if (is_array($result) && count($result) > 0)
            echo 'true';
        else
            echo 'false';
        exit;

//         pr($this->db->last_query());exit;
    }

//
//    public function password_exists() {
//        $postvar = $this->input->post();
//        $cond = 'iAdminId = ' . $this->session->userdata('iAdminId') . ' AND vPassword = "' . $this->general->encryptData(md5($postvar['old_password'])) . '"';
//        
//        $result = $this->model_admin->getData('count(*) as tot', [], $cond);
//        
//        if ($result[0]['tot'] == 1) {
//            //password found
////            echo 'true';
//            echo $result[0]['tot'];
//        } else {
//            //password is not found
//            echo $result[0]['tot'];
//        }
//        exit;
//    }
//
    public function image_delete() {
        $postvar = $this->input->post();
        $iAdminId = $postvar['admin_id'];

        $fields = "vImage";
        $ext_cond = 'iAdminId ="' . $iAdminId . '"';
        $reply = $this->model_admin->getData($fields, $ext_cond);
        $image = $reply[0]['vImage'];

        if ($image != '') {
            $img = 'admin/' . $iAdminId . '/' . $image;
            $img_path = $this->config->item('upload_path') . $img;
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }
        $ext_cond = "iAdminId ='" . $iAdminId . "'";
        $data['vImage'] = '';
        $this->model_admin->update($data, $ext_cond);
    }

    function account() {
        $this->load->view('account');
    }

    function my_account() {

        $getvar = $this->input->get();

        $id = $this->session->userdata('iAdminId');

        $fields = "*";
        $ext_cond = 'iAdminId ="' . $id . '"';
        $result = $this->model_admin->getData($fields, [], $ext_cond);
        $data['all'] = $result;
        $data['admin_id'] = $id;
        $this->load->view('my_account', $data);
    }

    public function my_account_action() {
        $postvar = $this->input->post();
        $tbl = "admin";
        $adminid = $this->session->userdata('iAdminId');
        if ($adminid > 0) {
            $cond = 'iAdminId = ' . $adminid;
            unset($postvar['admin_id']);
            unset($postvar['submit']);
            $postvar['dtModify'] = date('Y-m-d H:i:s');

            if (isset($_FILES['vImage']))
                $ImageFile = $_FILES['vImage'];
            if ($ImageFile['name'] != '') {
                $this->load->library('upload');
                $temp_folder_path = $this->config->item('upload_path') . 'admin/' . $adminid . '/';
//                echo $temp_folder_path;exit;
                $this->general->createfolder($temp_folder_path);

                $file_name = $adminid . '_' . date('YmdHis');
                $upload_config = array(
                    'upload_path' => $temp_folder_path,
                    'allowed_types' => "jpg|jpeg|gif|png", //*
                    'max_size' => 1028 * 1028 * 5,
                    'file_name' => $file_name,
                    'remove_space' => TRUE,
                    'overwrite' => True
                );

                $this->upload->initialize($upload_config);

                if ($this->upload->do_upload('vImage')) {
                    $file_info = $this->upload->data();
                    $uploadedFile = $file_info['file_name'];
                    $postvar['vImage'] = $uploadedFile;
                    $this->session->set_userdata("vImage", $uploadedFile);
                } else {
//                     echo $this->upload->display_errors();exit;
                }
            }
            $success = $this->model_admin->update($postvar, $cond);
//            echo $this->db->last_query();exit;
//            echo "Message=>".$success;exit;
            if ($success == 1) {
                $this->session->set_flashdata('success', "Record updated successfully");
            } else {
                $this->session->set_flashdata('failure', "error in updating data,please try again");
            }
        }

        redirect('account');
    }

    public function change_password() {
        $this->load->view('change_password');
    }

    public function checkPassword() {
        $postvar = $this->input->post();
        $id = $this->session->userdata('iAdminId');
        $pwd = md5($postvar['voldPassword']);
        $fields = "vPassword";
        $ext_cond = "iAdminId = '" . $id . "'";
        $getdata = $this->model_admin->getData($fields, array(), $ext_cond);
        $password = $getdata[0]['vPassword'];

        if ($pwd == $password) {
            echo "true";
        } else {
            echo "false";
        }
        exit;
    }

    public function change_password_action() {
        $postvar = $this->input->post();
        $getvar = $this->input->get();

        $ext_cond = 'iAdminId = "' . $this->session->userdata('iAdminId') . '"';
        unset($postvar['vPassword2']);
        unset($postvar['voldPassword']);

        $postvar['vPassword'] = stripslashes(md5($postvar['vPassword']));

        $this->model_admin->update($postvar, $ext_cond);
        $this->session->set_flashdata('success', 'Password updated successfully');

        redirect('account');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
