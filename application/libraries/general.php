<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

Class General {

    protected $CI;
    public $orderBook;

    function __construct() {
        $this->CI = & get_instance();
        $this->orderBook = array();
    }

    public static function encrypt_decrypt($action, $string) {
        $output = false;

        $key = '@2g';

// initialization vector
        $iv = md5(md5($key));

        if ($action == 'encrypt') {
            $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
            $output = str_replace('\0', '', addslashes(rtrim($output, "")));
        }

        return trim($output, "=");
    }

    function encrypt($sData, $sKey = '@2g') {
        $sResult = '';
        for ($i = 0; $i < strlen($sData); $i++) {
            $sChar = substr($sData, $i, 1);
            $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
            $sChar = chr(ord($sChar) + ord($sKeyChar));
            $sResult .= $sChar;
        }
        return $this->encode_base64($sResult);
    }

    function decrypt($sData, $sKey = '@2g') {
        $sResult = '';
        $sData = $this->decode_base64($sData);
        for ($i = 0; $i < strlen($sData); $i++) {
            $sChar = substr($sData, $i, 1);
            $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
            $sChar = chr(ord($sChar) - ord($sKeyChar));
            $sResult .= $sChar;
        }
        return $sResult;
    }

    function encode_base64($sData) {
        $sBase64 = trim(base64_encode($sData), '=');
        return strtr($sBase64, '+/', '-_');
    }

    function decode_base64($sData) {
        $sBase64 = strtr($sData, '-_', '+/');
        return base64_decode($sBase64);
    }

    function getRandomNumber($len = "15") {
        $better_token = strtoupper(md5(uniqid(rand(), true)));
        $better_token = substr($better_token, 1, $len);
        return $better_token;
    }

    public function getPostForm($post_data, $msg = "", $action = "") {
//pr($post_data);exit;
        $str = '<html>
            <form name="frmpost" action="' . $action . '" method=post>';
        if (is_array($post_data)) {
            $str .= "<br><input type='Hidden' name='frmpostdata' value='" . str_replace("'", "\u0027", json_encode($post_data)) . "'>";
        } else {
            $str .= '<br><input type="Hidden" name="frmpostdata" value="' . stripslashes($post_data) . '">';
        }
        $str .= '<input type="Hidden" name="frmpost_msg" value="' . $msg . '"><input type="Hidden" name="record_already_exists" value="1">
            </form>
            <script>
                document.frmpost.submit();
            </script>
            </html>';
        echo $str;
        exit;
    }

    function restorePost($post_str) {
        $post_arr = array();
        if ($post_str != '') {
            $post_arr = str_replace("\u0027", "'", $post_str);
            $post_arr = json_decode(stripslashes(htmlspecialchars_decode($post_arr)), true);
        }
        return $post_arr;
    }

    function getcopyrighttext() {
        $copyrighttext = str_replace("#CURRENT_YEAR#", date('Y'), $this->CI->systemsettings->getSettings('COPYRIGHTED_TEXT'));
        $copyrighttext = str_replace("#COMPANY_NAME#", $this->CI->systemsettings->getSettings('COMPANY_NAME'), $copyrighttext);
        return $copyrighttext;
    }

    function TimetoDate($text) {
        return date("M j, Y", $text);
    }

    function getTime($date, $format = '', $top = false) {
        if ($format == '') {
            $format = $this->CI->config->item('display_time_format');
        }
        if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00' && $date != '') {
            $user_time_zone = $this->CI->config->item('YT_USER_TIME_ZONE');
            $date = ($user_time_zone != '') ? $this->changetimefromUTC($date, $user_time_zone) : $date;
            return ($top) ? date($format, $date) : date($format, strtotime($date));
        } else {
            return '---';
        }
    }

    function getDateTime($date, $format = '', $top = false) {
        if ($format == '') {
            $format = $this->CI->config->item('display_date_time_format');
        }
        if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00' && $date != '') {
            $user_time_zone = $this->CI->config->item('YT_USER_TIME_ZONE');
            $date = ($user_time_zone != '') ? $this->changetimefromUTC($date, $user_time_zone) : $date;
            return ($top) ? date($format, $date) : date($format, strtotime($date));
        } else {
            return '---';
        }
    }

    function getDate($date, $format = '', $top = false) {
        if ($format == '') {
            $format = $this->CI->config->item('display_date_format');
        }
        if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00' && $date != '') {
//            $user_time_zone = $this->CI->config->item('YT_USER_TIME_ZONE');
//            $date = ($user_time_zone != '') ? $this->changetimefromUTC($date,$user_time_zone) : $date;
            return ($top) ? date($format, $date) : date($format, strtotime($date));
        } else {
            return '---';
        }
    }

    function file_upload($photopath = '', $vphoto = '', $vphoto_name = '', $vaildExt = '') {
        $msg = "";
        $vphotofile = '';
        if (!empty($vphoto_name) && is_file($vphoto)) {
// Remove Dots from File name
            $tmp = explode(".", $vphoto_name);
            for ($i = 0; $i < count($tmp) - 1; $i++) {
                $tmp1[] = $tmp[$i];
            }
            $file = implode("_", $tmp1);
            $ext = $tmp[count($tmp) - 1];
            $vaildExtArr = explode(",", strtoupper($vaildExt));
            if (trim($vaildExt) == "" || in_array(strtoupper($ext), $vaildExtArr)) {
//$vphotofile=$file.".".$ext;
                $vphotofile = $file . "_" . date("Ymdhis") . "." . $ext;
                $ftppath1 = $photopath . $vphotofile;
                if (!copy($vphoto, $ftppath1)) {
                    $vphotofile = '';
                    $msg = "Uploading file(s) is failed.!";
                } else {
                    $msg = "File(s) uploaded successfully.!";
                }
            } else {
                $vphotofile = '';
                $msg = "File extension is not valid, vaild ext. are  $vaildExt .!";
            }
        } else {
            $vphotofile = '';
            $msg = "Upload file path not found";
        }
        $ret[0] = $vphotofile;
        $ret[1] = $msg;
        return $ret;
    }

    function image_upload($photo, $path, $prefix = '', $filename = '') {
        $photo_name_str = base64_decode($photo);
        if ($filename == '') {
            $filename = date('Ymdhis') . rand() . '-image.jpg';
        }
        $filename_path = $path . $prefix . $filename;
        if (!$handle = fopen($filename_path, 'w')) {
            $filename = '';
            $msg = "Cannot open file ($filename)";
        }
// Write $somecontent to our opened file.
        if (fwrite($handle, $photo_name_str) === FALSE) {
            $filename = '';
            $msg = "Cannot write to file ($filename)";
        }
        @fclose($handle);
        return $filename;
    }
    
    public function getLatLngFromAddress($address) {

        $address = str_replace(" ", "+", $address);

        $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
        $json = json_decode($json);

        $res['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $res['lng'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        return $res;
    }
    
    function getAddressLatLng($myaddress) {
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
        //get the content from the api using file_get_contents
        $getmap = file_get_contents($url);
        //the result is in json format. To decode it use json_decode
        $googlemap = json_decode($getmap);
        //get the latitute, longitude from the json result by doing a for loop
        foreach ($googlemap->results as $res) {
            $address = $res->geometry;
            $latlng = $address->location;
            return $latlng;
            //$formattedaddress = $res->formatted_address;
        }
    }

    function strip_get_post($data = '') {
        if ($data == '') {
            $data = $this->get_post();
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->strip_get_post($value);
            } else {
                $data[$key] = strip_tags($value);
            }
        }
        return $data;
    }

    function get_post() {
        $get_arr = is_array($this->CI->input->get(null, true)) ? $this->CI->input->get(null, true) : array();
        $post_arr = is_array($this->CI->input->post(null, true)) ? $this->CI->input->post(null, true) : array();
        return $request_arr = array_merge($get_arr, $post_arr);
    }

    function createUploadFolderIfNotExists($folder_name = '', $folderIdWise = false, $id = 0) {
        if ($folder_name == "") {
            return false;
        }
        $upload_folder = $this->CI->config->item('upload_path') . $folder_name . DS;
        if (!is_dir($upload_folder)) {
            $oldUmask = umask(0);
            $res = @mkdir($upload_folder, 0777);
            @chmod($upload_folder, 0777);
            umask($oldUmask);
        }
        if ($folderIdWise && $id > 0) {
            $upload_folder_idWise = $this->CI->config->item('upload_path') . $folder_name . DS . $id . DS;
            if (!is_dir($upload_folder_idWise)) {
                $oldUmask = umask(0);
                $res = @mkdir($upload_folder_idWise, 0777);
                @chmod($upload_folder_idWise, 0777);
                umask($oldUmask);
            }
        }
        return true;
    }

    function createfolder($path) {
        $site_path = $this->CI->config->item('upload_path');
        $res = '';
        $pathfolder = @explode("/", str_replace($site_path, "", $path));
        $realpath = "";
        for ($p = 0; $p < count($pathfolder); $p++) {
            if ($pathfolder[$p] != '') {
                $realpath = $realpath . $pathfolder[$p] . "/";
                $makefolder = $site_path . "/" . $realpath;
                if (!is_dir($makefolder)) {
//                    $makefolder = @mkdir($makefolder, 0777);
//                    @chmod($makefolder, 0777);

                    $oldUmask = umask(0);
                    $res = @mkdir($makefolder, 0777);
                    @chmod($makefolder, 0777);
                    umask($oldUmask);
                }
            }
        }

        return $res;
    }

    function sendMail($data = array(), $type_format = "CONTACT_US") {

        if (is_array($data) && count($data) > 0) {

            $mailarr = $this->getSystemEmailData($type_format);

            $vAdminName = $mailarr[0]['vFromName'];
            $vAdminEmail = $mailarr[0]['vFromEmail'];
//$emailVarData = $this->getVariablesByTemplate($mailarr[0]['iEmailTemplateId']);
            $subject = $data['vSubject'];

            if ($subject == '') {
                $subject = $mailarr[0]['vEmailSubject'];
            }
            $exfindarray = $exreplacearray = $findarray = $replacearray = array();
            $i = 0;
            foreach ($data as $key => $val) {
                $findarray[] = $key;
                $replacearray[] = $val;
                $i++;
            }

            $tEmailMessage = stripslashes($mailarr[0]['tEmailMessage']);

            $site_logo = "<img src='" . $this->CI->config->item('site_url') . "images/admin/logo.gif'/>";

            if ($data['vEmail'] != '') {
                $to = $data['vEmail'];
            } else {
                $to = $this->CI->config->item('EMAIL_ADMIN');
            }
            $mailarr[0]['vEmailFooter'] = str_replace("#COMPANY_NAME#", $this->CI->config->item('COMPANY_NAME'), $mailarr[0]['vEmailFooter']);
            $admin_url = $this->CI->config->item("admin_url");
            $site_url = $this->CI->config->item("site_url");

            $findarray = array_merge($findarray, array("#COMPANY_NAME#", "#SITE_URL#", "#MAIL_FOOTER#", "#SITE_LOGO#"));
            $replacearray = array_merge($replacearray, array($this->CI->config->item('COMPANY_NAME'), $site_url, $mailarr[0]['vEmailFooter'], $site_logo));

            switch ($type_format) {
                case "CONTACT_US":
                    $exfindarray = array("#vName#", "#vFromEmail#", "#vPhone#", "#tComments#");
                    $exreplacearray = array($data['vName'], $data['vFromEmail'], $data['vPhone'], $data['tComments']);
                    break;
                case "ADMIN_REGISTER":
                    $exfindarray = array("#LOGIN_URL#");
                    $exreplacearray = array($admin_url);
                    break;
                case "FORGOT_PASSWORD":
                    $exfindarray = array("#LOGIN_URL#");
                    $exreplacearray = array($site_url);
                    break;
                case "NEWSLETTER":
                    $exfindarray = array("#LOGIN_URL#");
                    $exreplacearray = array($admin_url);
                    break;
            }

            $findarray = array_merge($findarray, $exfindarray);
            $replacearray = array_merge($replacearray, $exreplacearray);
            $body = str_replace($findarray, $replacearray, $tEmailMessage);

            $subject = str_replace($findarray, $replacearray, $subject);

            if ($type_format == 'FORGOT_PASSWORD') {
                $from = $vAdminName . "<" . $vAdminEmail . "> ";
            } else {
                if ($data['vFromEmail'] != "") {
                    $from = $data['vFromName'] . " < " . $data['vFromEmail'] . " >";
                    $from_name = $data['vFromName'];
                } else {
                    $from = $mailarr[0]['vFromName'] . " <" . $this->CI->config->item('EMAIL_ADMIN') . ">";
                    $from_name = 'admin';
                }
                if ($data['vCCEmail']) {
                    $cc = $data['vCCEmail'];
                }
                if ($data['vBCCEmail'] != "") {
                    $bcc = $data['vBCCEmail'];
                }
            }

            $this->CI->load->library('email');
            $this->CI->email->from($from, $from_name);
            $this->CI->email->to($to);
            if ($cc != "") {
                $this->CI->email->cc($cc);
            }
            if ($bcc != "") {
                $this->CI->email->bcc($bcc);
            }
            $this->CI->email->subject($subject);
            $this->CI->email->message($body);
            $success = $this->CI->email->send();
//echo "<br> $body <br> success".$success = $this->CI->email->send();exit;
            return $success;
#$success = $this->general->sendEmail($to, $subject, $vBody, $from, '', $cc, $bcc, $from_name);
        } else {
            return false;
        }
    }

    function encryptData($input) {
        $output = trim(base64_encode(base64_encode($input)), '==');
        $output = $this->encrypt($input);
//$output = $this->encrypt_decrypt('encrypt', $input);
        return $output;
    }

    function decryptData($input) {
        $output = base64_decode(base64_decode($input));
        $output = $this->decrypt($input);
//$output = $this->encrypt_decrypt('decrypt', $input);
        return $output;
    }

    function checkSession($d = '') {
        if (!$this->CI->session->userdata('expire') || $this->CI->session->userdata('expire') > time()) {
            $this->CI->session->set_userdata('start', time());
            $expire = $this->CI->session->userdata('start') + $this->CI->config->item('SESSION_TIMEOUT') * 60;
            $this->CI->session->set_userdata('expire', $expire);
            if ($d != '') {
                return 'true';
            }
        } else if ($this->CI->session->userdata('expire') > 0 && $this->CI->session->userdata('expire') < time()) {
            $this->CI->session->unset_userdata('expire', '');
            $this->CI->session->set_flashdata('failure', 'Session time out..');
            if ($d != '') {
                if ($this->CI->config->item('is_admin') == 1) {
                    return 'admin_timeout';
                } else {
                    return 'timeout';
                }
            } else {
                if ($this->CI->config->item('is_admin') == 1) {
                    redirect('logout');
                } else {
                    redirect('signout');
                }
            }
        }
    }

//    function checkSession() {
//        if (!$this->CI->session->userdata('expire') || $this->CI->session->userdata('expire') > time()) {
//            $this->CI->session->set_userdata('start', time());
//            $expire = $this->CI->session->userdata('start') + 1 * 3;
//            $this->CI->session->set_userdata('expire', $expire);
//            } else if ($this->CI->session->userdata('expire') > 0 && $this->CI->session->userdata('expire') < time()) {
//            $this->CI->session->unset_userdata('expire', '');
//            $this->CI->session->set_flashdata('failure', 'Session time out..');
//            
////            redirect('signout');
//        }
//    }

    function checkSessionfront() {
        if (!$this->CI->session->userdata('expire') || $this->CI->session->userdata('expire') > time()) {
            $this->CI->session->set_userdata('start', time());
            $expire = $this->CI->session->userdata('start') + $this->CI->config->item('SESSION_TIMEOUT') * 60;
            $this->CI->session->set_userdata('expire', $expire);
        } else if ($this->CI->session->userdata('expire') < time()) {
            $this->CI->session->unset_userdata('expire', '');
            $this->CI->session->set_flashdata('failure', 'Session time out..');
            redirect('signout');
        }
    }

    function getPagePermission($roleid, $moduleurl, $type = "list") {
        $this->CI->load->model('roles/model_permission');
        $permissionGrant = $this->CI->model_permission->getPagePermission($roleid, $moduleurl, $type);
//        pr($permissionGrant,1);
//        $read_arr = explode(',', $permissionGrant[0]['isRead']);
//        $write_arr = explode(',', $permissionGrant[0]['isWrite']);
//        $delete_arr = explode(',', $permissionGrant[0]['isDelete']);
//        pr($write_arr);exit;
        $isAllowed = 1;
        if (count($permissionGrant) > 0 && ((($type == 'list' || $type == 'view') && $permissionGrant[0]['isRead'] == 1) || ($type == 'form' && $permissionGrant[0]['isWrite'] == 1) || ($type == 'del' && $permissionGrant[0]['isDelete'] == 1))) {
            $isAllowed = 1;
        } else {
            $isAllowed = 0;
        }
        return $isAllowed;
    }

    function getPageDeletePermission($iRoleId, $selfurl, $type = "list") {
        $this->CI->load->model('new_user/model_permission');
        $permissionGrant = $this->CI->model_permission->getPageDeletePermission($iRoleId, $selfurl, $type);
        $isAllowed = true;
        if (count($permissionGrant) > 0 && ($type == 'list' && $permissionGrant[0]['isDelete'] == '1')) {
            return $isAllowed;
        } else {
            return 0;
        }
    }

    function addSpaceInString($keyword, $replace = false) {
//$wResult = preg_match_all('/(^I|[[:upper:]]{2,}|[[:upper:]][[:lower:]]*|[[:lower:]]+|\d+|#)/u', $keyword, $matches);
        $wResult = preg_match_all('/(^[[:upper:]]{2,}|[[:upper:]][[:lower:]]*|[[:lower:]]+|\d+|#)/u', $keyword, $matches);
        if ($replace) {
            return implode('_', $matches[0]);
        } else {
            return implode(' ', $matches[0]);
        }
    }

    function truncate($string, $limit, $link = '', $break = ".", $pad = "...") {
        $link = (($link != '') ? " <a data-href='$link' onclick='urlParse(this)'>more...</a>" : '');
// return with no change if string is shorter than $limit        
        if (strlen($string) <= $limit)
            return $string . $link;

// is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad . $link;
            }
        } else {
            $string = substr($string, 0, $limit) . $pad . $link;
        }

        return $string;
    }

    function checkTimeout() {

//         pr($this->CI->session->userdata('expire'));exit;
        if (!$this->CI->session->userdata('expire') || $this->CI->session->userdata('expire') > time()) {
            $this->CI->session->set_userdata('start', time());
            $expire = $this->CI->session->userdata('start') + 1 * 5;
            $this->CI->session->set_userdata('expire', $expire);
            return $this->CI->session->userdata('start') . '   ' . $this->CI->session->userdata('expire');
        } else if ($this->CI->session->userdata('expire') > 0 && $this->CI->session->userdata('expire') < time()) {
            $this->CI->session->unset_userdata('expire', '');
            $this->CI->session->set_flashdata('failure', 'Session time out..');
            return 'timeout';
//            redirect('signout');
        }
    }

    function getFrontPanelMenu($iParentId = '', $location = "Header", $excludemenu = '') {
        $userId = $this->CI->session->userdata('iUserId');
        $user_parentId = $this->CI->config->item('YT_USER_PARENT_ID');
        $user_roleId = $this->CI->config->item('YT_USER_ROLE_ID');

        $iParentId = ($iParentId == '') ? 0 : $iParentId;
        $this->CI->db->select();
        $this->CI->db->where("m.iParentId", "$iParentId");
        $this->CI->db->where("m.eMenuType", 'Front');
        $this->CI->db->from("module_master AS m");
        if (strtolower($this->CI->config->item('YT_USER_PROFILE')) == "standard" && $excludemenu != 'activities') {
            $this->CI->db->join("user_permission AS up", "m.iModuleId = up.iModuleId");
            $this->CI->db->where("up.iUserRoleId", $user_roleId);
            $this->CI->db->where("(up.isRead = 1 || up.isWrite = 1 || up.isDelete = 1) and m.eStatus =", 'Active');
        } else {
            $this->CI->db->where("m.eStatus", 'Active');
        }
        $this->CI->db->order_by("iSequenceOrder");
        $menu_data = $this->CI->db->get()->result_array();
//echo $this->CI->db->last_query()."<br/>";
        return $menu_data;
    }

    function griddata($param, $type = '') {

        $user_timezone = $this->CI->config->item('YT_USER_TIME_ZONE');
        $user_dateformat = $this->CI->config->item('YT_USER_MYSQL_DATE_FORMAT');
        $timeFormat = $this->CI->config->item('YT_USER_TIME_FORMAT');

        $user_timeformat = ($timeFormat == "12") ? " %h:%i %p" : " %h:%i:%s";

        switch (trim($param)) {

            case 'user_master':
                /* User master */
                $columnArr = array('user_master.iUserId', 'user_master.iCompanyId', 'user_master.iParentId', 'concat(user_master.vSalutation, " ", user_master.vFirstName, " ", user_master.vMiddleName, " ", user_master.vLastName) as name', 'user_master.eProfile', 'user_master.eStatus', 'user_role_master.vRole as role', 'user_master.vNickName', 'user_master.vUserName', 'department_master.vDepartment as department', 'user_master.vEmail', 'user_master.eGender', 'user_master.vPhoneMobile', 'user_master.vPhoneWork', 'user_master.vPhoneOther', 'user_master.vFax', 'user_master.vStreet', 'user_master.vCity', 'user_master.vZip', 'user_master.vState', 'country.vCountry as country');

                $columnHeaderArr[] = array('name' => 'user_master.iUserId', 'title' => 'Potential Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'user_master.iCompanyId', 'title' => 'Company Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'user_master.iParentId', 'title' => 'User Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'name', 'title' => 'Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'user_master.eProfile', 'title' => 'Profile', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'user_master.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'role', 'title' => 'Role', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'user_master.vNickName', 'title' => 'Nick Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vUserName', 'title' => 'User Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'department', 'title' => 'Department', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vEmail', 'title' => 'Email', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'eGender', 'title' => 'Gender', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vPhoneMobile', 'title' => 'Mobile No', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vPhoneWork', 'title' => 'Phone (Work)', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vPhoneOther', 'title' => 'Phone (Other)', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vFax', 'title' => 'Fax', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vStreet', 'title' => 'Street', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vCity', 'title' => 'City', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vZip', 'title' => 'Zip', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'user_master.vState', 'title' => 'State', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'country', 'title' => 'Country', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'user_master '; /* Table name */
                $griddata['join'][] = array('tbl' => 'user_role_master', 'cond' => 'user_role_master.iUserRoleId = user_master.iUserRoleId', 'type' => 'left'); /* Join Table name(leave blank if no join) */
                $griddata['join'][] = array('tbl' => 'department_master', 'cond' => 'department_master.iDepartmentId = user_master.iUserId', 'type' => 'left'); /* Join Table name(leave blank if no join) */
                $griddata['join'][] = array('tbl' => 'country', 'cond' => 'country.iCountryId = user_master.iCountryId', 'type' => 'left'); /* Join Table name(leave blank if no join) */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */

                $orderListArr[] = array('value' => 'all_users', 'label' => 'All Users');
                $orderListArr[] = array('value' => 'my_users', 'label' => 'My Users');
                $orderListArr[] = array('value' => 'new_last_week_users', 'label' => 'New Last Week');
                $orderListArr[] = array('value' => 'new_this_week_users', 'label' => 'New This Week');
                $orderListArr[] = array('value' => 'recently_created_users', 'label' => 'Recently Created Users');
                $orderListArr[] = array('value' => 'recently_modified_users', 'label' => 'Recently Modified Users');
                $griddata['order_list'] = $orderListArr; /* Table order by */

                $griddata['show_order_list'] = 1;

                /* view url for popup view window in listing or it same as delete url */
                $griddata['view_url'] = $this->CI->config->item('site_url') . 'user_view';
                $griddata['edit_url'] = $this->CI->config->item('site_url') . 'user_edit';
                $griddata['delete_url'] = $this->CI->config->item('site_url') . 'change_owner';

                $griddata['type'] = 'User';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'user_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'users', 'ajax');
                $viewpermission = $this->check_permission('list', users, 'ajax');
                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            default:
                break;
        }
//pr($griddata);exit;
        return $griddata;
    }

    function admin_griddata($param, $type = '') {
        switch (trim($param)) {

            case 'role_master':

                $columnArr = array('role_master.iRoleId', 'role_master.vRole', 'role_master.vRoleCode', 'role_master.eRoleType', 'role_master.eStatus');

                $columnHeaderArr[] = array('name' => 'role_master.iRoleId', 'title' => 'Role Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'role_master.vRole', 'title' => 'Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'role_master.vRoleCode', 'title' => 'Role Code', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true, "visible" => true);
                $columnHeaderArr[] = array('name' => 'role_master.eRoleType', 'title' => 'Role Type', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true, "visible" => true);
                $columnHeaderArr[] = array('name' => 'role_master.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);

                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'role_master'; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;


                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'role_edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'roles_permissions';

                $griddata['type'] = 'Role';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'role_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'roles', 'ajax');

                $viewpermission = $this->check_permission('list', 'roles', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'module_master':
                /* module Master */
                $columnArr = array('module_master.iModuleId', 'module_master.vModule', 'module_master.iParentId', 'module_master.iSequenceOrder', 'module_master.vMenuDisplay', 'module_master.eMenuType', 'module_master.vMainMenuCode', 'module_master.vSelectedMenu', 'module_master.eStatus');

                $columnHeaderArr[] = array('name' => 'module_master.iModuleId', 'title' => 'Module Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'module_master.vModule', 'title' => 'Module', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'module_master.iParentId', 'title' => 'Parent Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'module_master.iSequenceOrder', 'title' => 'SequenceOrder', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'module_master.vMenuDisplay', 'title' => 'MenuDisplay', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'module_master.eMenuType', 'title' => 'MenuType', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true, "visible" => true);
                $columnHeaderArr[] = array('name' => 'module_master.vMainMenuCode', 'title' => 'MainMenuCode', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'module_master.vSelectedMenu', 'title' => 'SelectedMenu', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'module_master.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'module_master '; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;


                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'module_edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'modules';

                $griddata['type'] = 'Module';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'module_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'modules', 'ajax');
                $viewpermission = $this->check_permission('list', 'modules', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'admin':
                /* Admin */
                $columnArr = array('admin.iAdminId', 'admin.vName', 'admin.vEmail', 'admin.vUserName', 'admin.iRoleId', 'admin.eStatus');

                $columnHeaderArr[] = array('name' => 'admin.iAdminId', 'title' => 'Admin Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'admin.vName', 'title' => 'Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'admin.vEmail', 'title' => 'Email', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'admin.vUserName', 'title' => 'User Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'admin.iRoleId', 'title' => 'Role Id', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'admin.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'admin '; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'admin-edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'admins';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'admin_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'admins', 'ajax');
                $viewpermission = $this->check_permission('list', 'admins', 'ajax');
                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'system_email':
                /* Admin */
                $columnArr = array('system_email.iEmailTemplateId', 'system_email.vEmailCode', 'system_email.vEmailTitle', 'system_email.vFromName', 'system_email.vFromEmail', 'system_email.vBccEmail', 'system_email.vEmailSubject', 'system_email.eStatus');

                $columnHeaderArr[] = array('name' => 'system_email.iEmailTemplateId', 'title' => 'Email Template Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'system_email.vEmailCode', 'title' => 'Email Code', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'system_email.vEmailTitle', 'title' => 'Email Title', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'system_email.vFromName', 'title' => 'From Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'system_email.vFromEmail', 'title' => 'From Email', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'system_email.vBccEmail', 'title' => 'Bcc', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'system_email.vEmailSubject', 'title' => 'Email Subject', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => false, "visible" => false);
                $columnHeaderArr[] = array('name' => 'system_email.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'system_email '; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'email_edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'emails';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'email_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'emails', 'ajax');
                $viewpermission = $this->check_permission('list', 'emails', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'user_master':
                /* User master */
                $columnArr = array('user_master.iUserId', 'concat(user_master.vFirstName, " ", user_master.vLastName) as name', 'user_master.vEmail', 'user_master.vContactNo');

                $columnHeaderArr[] = array('name' => 'user_master.iUserId', 'title' => 'User Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'name', 'title' => 'Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'user_master.vEmail', 'title' => 'Email', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'user_master.vContactNo', 'title' => 'Contact No', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'user_master ';
                $griddata['colshead'] = $columnArr;
                $griddata['colstitle'] = $columnHeaderArr;
                $griddata['show_order_list'] = 0;

                /* view url for popup view window in listing or it same as delete url */
                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'user-edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'users';

                $griddata['type'] = 'User';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'user-add', 'ajax');
//                pr($editpermission,1);
                $deletepermission = $this->check_permission('del', 'users', 'ajax');
                $viewpermission = $this->check_permission('list', 'users', 'ajax');
                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'vehicle_master':
                /* User master */
                $columnArr = array('vehicle_type_master.iVehicleTypeId', 'vehicle_type_master.vType', 'vehicle_type_master.vIcon');

                $columnHeaderArr[] = array('name' => 'vehicle_type_master.iVehicleTypeId', 'title' => 'Vehicle Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'vehicle_type_master.vType', 'title' => 'Type', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'vehicle_type_master.vIcon', 'title' => 'Number', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'vehicle_type_master ';
                $griddata['colshead'] = $columnArr;
                $griddata['colstitle'] = $columnHeaderArr;
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'vehicle-edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'vehicles';

                $griddata['type'] = 'User';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'vehicle', 'ajax');
                $deletepermission = $this->check_permission('del', 'vehicles', 'ajax');
                $viewpermission = $this->check_permission('list', 'vehicles', 'ajax');
                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                break;
            case 'shipment_master':
                /* User master */
                $columnArr = array('shipment_master.iShipmentId', 'shipment_master.vTitle', 'shipment_master.vContactNo', 'DATE_FORMAT(shipment_master.vPreferredDate,"%d-%b-%Y")');

                $columnHeaderArr[] = array('name' => 'shipment_master.iShipemetId', 'title' => 'Shipment Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'vTitle', 'title' => 'Title', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'shipment_master.vContactNo', 'title' => 'Contact No', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'shipment_master.vPreferredDate', 'title' => 'Preffered Date', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'shipment_master ';
                $griddata['colshead'] = $columnArr;
                $griddata['colstitle'] = $columnHeaderArr;
                $griddata['show_order_list'] = 0;

                /* view url for popup view window in listing or it same as delete url */
                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'shipment-edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'shipments';

                $griddata['type'] = 'User';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'shipment-add', 'ajax');
                $deletepermission = $this->check_permission('del', 'shipments', 'ajax');
                $viewpermission = $this->check_permission('list', 'shipments', 'ajax');
                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                break;

            case 'location_master':
                /* User master */
                $columnArr = array('location_master.iLocationId', '(select vCountry from country where country.iCountryId=location_master.iCountryId) as country', '(select vStateName from states where states.iStateId=location_master.iStateId) as state', '(select vCityName from city where city.iCityId=location_master.iCityId) as city', '(select vAreaName from area where area.iAreaId=location_master.iAreaId) as area', 'location_master.vLandmark');

                $columnHeaderArr[] = array('name' => 'shipment_master.iLocationId', 'title' => 'Location Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'country', 'title' => 'Country', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'state', 'title' => 'State', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'city', 'title' => 'City', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'area', 'title' => 'Area', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'shipment_master.vLandmark', 'title' => 'Landmark', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Action', 'title' => 'Action', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'location_master ';
                $griddata['colshead'] = $columnArr;
                $griddata['colstitle'] = $columnHeaderArr;
                $griddata['show_order_list'] = 0;

                /* view url for popup view window in listing or it same as delete url */
                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('admin_site_url') . 'location-edit';
                $griddata['delete_url'] = $this->CI->config->item('admin_site_url') . 'locations';

                $griddata['type'] = 'User';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'location-add', 'ajax');
                $deletepermission = $this->check_permission('del', 'locations', 'ajax');
                $viewpermission = $this->check_permission('list', 'locations', 'ajax');
                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                break;
            case 'country':
                /* Admin */
                $columnArr = array('country.iCountryId', 'country.vCountry', 'country.vCountryCode', 'country.vCountryCodeISO_3', 'country.vInternetCode', 'country.eStatus');

                $columnHeaderArr[] = array('name' => 'country.iCountryId', 'title' => 'Country Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'country.vCountry', 'title' => 'Country', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country.vCountryCode', 'title' => 'Country Code', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country.vCountryCodeISO_3', 'title' => 'ISO_3', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country.vInternetCode', 'title' => 'Internet Code', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'country '; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('other_site_url') . 'country_edit';
                $griddata['delete_url'] = $this->CI->config->item('other_site_url') . 'countries';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'country_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'countries', 'ajax');
                $viewpermission = $this->check_permission('list', 'countries', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'states':
                /* Admin */
                $columnArr = array('states.iStateId', 'states.vStateName', '(select vCountry from country where country.iCountryId=states.iCountryId) as country', 'states.eStatus');

                $columnHeaderArr[] = array('name' => 'states.iStateId', 'title' => 'State Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'states.vStateName', 'title' => 'State', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country', 'title' => 'Country', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'states.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'states'; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('other_site_url') . 'state_edit';
                $griddata['delete_url'] = $this->CI->config->item('other_site_url') . 'states';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'state_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'states', 'ajax');
                $viewpermission = $this->check_permission('list', 'states', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'city':
                /* Admin */
                $columnArr = array('city.iCityId', 'city.vCityName', '(select vStateName from states where states.iStateId=city.iStateId) as State', '(select vCountry from country where country.iCountryId=city.iCountryId) as country', 'city.eStatus');

                $columnHeaderArr[] = array('name' => 'city.iCityId', 'title' => 'City Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'city.vCityName', 'title' => 'City Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'State', 'title' => 'State', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country', 'title' => 'Country', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'city.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'city'; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('other_site_url') . 'city_edit';
                $griddata['delete_url'] = $this->CI->config->item('other_site_url') . 'cities';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'city_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'cities', 'ajax');
                $viewpermission = $this->check_permission('list', 'cities', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'area':
                /* Admin */
                $columnArr = array('area.iAreaId', 'area.vAreaName', '(select vCityName from city where city.iCityId=area.iCityId) as city', '(select vStateName from states where states.iStateId=area.iStateId) as State', '(select vCountry from country where country.iCountryId=area.iCountryId) as country', 'area.eStatus');

                $columnHeaderArr[] = array('name' => 'area.iAreaId', 'title' => 'Area Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'area.vAreaName', 'title' => 'Area Name', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'City', 'title' => 'City', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'State', 'title' => 'State', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'country', 'title' => 'Country', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'area.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'area'; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('other_site_url') . 'area_edit';
                $griddata['delete_url'] = $this->CI->config->item('other_site_url') . 'area';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'area_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'areas', 'ajax');
                $viewpermission = $this->check_permission('list', 'areas', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            case 'page_settings':
                /* Admin */
                $columnArr = array('page_settings.iPageId', 'page_settings.vPageTitle', 'page_settings.vPageCode', 'page_settings.eType', 'page_settings.eStatus');

                $columnHeaderArr[] = array('name' => 'page_settings.iPageId', 'title' => 'Area Id', "visible" => false, 'searchable' => false, 'orderable' => false, 'sortable' => false);
                $columnHeaderArr[] = array('name' => 'page_settings.vPageTitle', 'title' => 'Page Title', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'page_settings.vPageCode', 'title' => 'Page Code', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'page_settings.eType', 'title' => 'Type', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'page_settings.eStatus', 'title' => 'Status', 'searchable' => true, 'orderable' => true, 'sortable' => true, 'selected' => true);
                $columnHeaderArr[] = array('name' => 'Actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false, 'sortable' => false);
                /* table headers shown by title and data for result key */

                $griddata['tbl'] = 'page_settings'; /* Table name */

                $griddata['colshead'] = $columnArr; /* Table column header names */
                $griddata['colstitle'] = $columnHeaderArr; /* Table column header names */
                $griddata['show_order_list'] = 0;

                $griddata['view_url'] = "javascript:void(0)";
                $griddata['edit_url'] = $this->CI->config->item('other_site_url') . 'page_edit';
                $griddata['delete_url'] = $this->CI->config->item('other_site_url') . 'pages';

                $griddata['type'] = 'Admin';

                /* permissioin code */
                $editpermission = $this->check_permission('form', 'page_add', 'ajax');
                $deletepermission = $this->check_permission('del', 'pages', 'ajax');
                $viewpermission = $this->check_permission('list', 'pages', 'ajax');

                $griddata['options'] = array('add' => $editpermission, 'edit' => $editpermission, 'delete' => $deletepermission, 'view' => $viewpermission);
                /* end permissioin code */
                break;
            default:
                break;
        }
//        pr($griddata,1);
        return $griddata;
    }

    function check_permission($type = "list", $selfurl = '', $call = '') {
        if ($call == 'ajax') {
            if ($this->CI->config->item('YT_ADMIN_ROLE_ID') != 1) {
                return $this->getPagePermission($this->CI->config->item('YT_ADMIN_ROLE_ID'), $selfurl, $type);
            } else {
                return 1;
            }
        } else {
            if ($this->CI->config->item('YT_ADMIN_ROLE_ID') != 1) {
                $selfurl = basename($_SERVER['REQUEST_URI']);
                if ($selfurl == 'forbidden') {
                    return 1;
                }
                $isAllowed = $this->getPagePermission($this->CI->config->item('YT_ADMIN_ROLE_ID'), $selfurl, $type);
                if (!$isAllowed) {
                    redirect('forbidden');
                }
            } else {
                return 1;
            }
//            if ($this->CI->config->item('YT_ADMIN_PARENT_ID') != 0 && strtolower($this->CI->config->item('YT_ADMIN_PROFILE')) == "standard") {
//                $selfurl = basename($_SERVER['REQUEST_URI']);
//                if ($selfurl == 'forbidden') {
//                    return 1;
//                }
//                $isAllowed = $this->getPagePermission($this->CI->config->item('YT_USER_ROLE_ID'), $selfurl, $type);
//                if (!$isAllowed) {
//                    redirect('forbidden');
//                }
//            } else {
//                return 1;
//            }
        }
    }

    function checkVirusInFile($file) {
        $return = array('success' => 'false', 'err' => 'We doubt your file is affected by Virus or do not proper extension');
        $allowed_types = array(
            /* images extensions */
            'jpeg', 'bmp', 'png', 'gif', 'tiff', 'jpg',
            /* audio extensions */
            'mp3', 'wav', 'midi', 'aac', 'ogg', 'wma', 'm4a', 'mid', 'orb', 'aif',
            /* movie extensions */
            'mov', 'flv', 'mpeg', 'mpg', 'mp4', 'avi', 'wmv', 'qt',
            /* document extensions */
            'txt', 'pdf', 'ppt', 'pps', 'xls', 'doc', 'xlsx', 'pptx', 'ppsx', 'docx', 'csv'
        );
        $mime_type_black_list = array(
# HTML may contain cookie-stealing JavaScript and web bugs
            'text/html', 'text/javascript', 'text/x-javascript', 'application/x-shellscript',
            # PHP scripts may execute arbitrary code on the server
            'application/x-php', 'text/x-php', 'text/x-php',
            # Other types that may be interpreted by some servers
            'text/x-python', 'text/x-perl', 'text/x-bash', 'text/x-sh', 'text/x-csh',
            'text/x-c++', 'text/x-c',
                # Windows metafile, client-side vulnerability on some systems
# 'application/x-msmetafile',
# A ZIP file may be a valid Java archive containing an applet which exploits the
# same-origin policy to steal cookies      
# 'application/zip',
        );
        $file_name = $file['name'];
        pathinfo($file_name, PATHINFO_EXTENSION);
        $tmp_file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!strlen($tmp_file_extension) || (!$allow_all_types &&
                !in_array($tmp_file_extension, $allowed_types))) {
            return $return;
        }
        $finfo = new finfo(FILEINFO_MIME, MIME_MAGIC_PATH);

        if ($finfo) {
            $mime = $finfo->file($file_name_tmp);
        } else {
            $mime = $file_type;
        }

        $mime = explode(" ", $mime);
        $mime = $mime[0];

        if (substr($mime, -1, 1) == ";") {
            $mime = trim(substr($mime, 0, -1));
        }
        $rs = in_array($mime, $mime_type_black_list) == false;
        if ($rs == 1) {
            $return['success'] = 'true';
            $return['err'] = '';
        }
//echo "come<pre>"; print_r($return);die;
//return (in_array($mime, $mime_type_black_list) == false);
        return $return;
    }

    function checkVirus($ImageFile, $redircturl = '', $ajax = '') {
        if ($redircturl == '') {
            $redircturl = basename($_SERVER['REQUEST_URI']);
        }
        if ($ImageFile != '') {
            $vrsRes = $this->checkVirusInFile($ImageFile);
            if ($vrsRes['success'] == 'true') {
                return true;
            } else {
                $alert = array('Failure' => array('message' => $vrsRes['err'], 'class' => 'alert-danger'));
                $this->CI->session->set_userdata("errorsocialAlert", $alert);
                echo $this->CI->config->item('site_url') . $redircturl;
                exit;
            }
        } else {
            return true;
        }
    }

    function changetimefromUTC($date_time, $timezone = '') {
        $timezone = ($timezone == '') ? $this->CI->config->item('YT_USER_TIME_ZONE') : $timezone;
        $changetime = new DateTime($date_time, new DateTimeZone('UTC'));
        $changetime->setTimezone(new DateTimeZone($timezone));
        return $changetime->format('Y-m-d H:i:s');
    }

    function changetimefromUserTime($date_time, $timezone = '') {
        $timezone = ($timezone == '') ? $this->CI->config->item('YT_USER_TIME_ZONE') : $timezone;
        $changetime = new DateTime($date_time, new DateTimeZone($timezone));
        $changetime->setTimezone(new DateTimeZone('UTC'));
        return $changetime->format('Y-m-d H:i:s');
    }

    function getCurrentDateTime($format = '') {
        if ($format == '') {
            $format = $this->CI->config->item('display_date_time_format');
        }
        $date = $this->getDateTime(date('Y-m-d H:i:s'), $format);
        return $date;
    }

    function getEnumValues($table, $field) {
        $type = $this->CI->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field
                        }'")->row(0)->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    function getSetValues($table, $field) {
        $type = $this->CI->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field
                        }'")->row(0)->Type;
        preg_match("/^set\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    function getPagingIds($module, $field, $activity_type = '') {
        $companyId = $this->CI->config->item('YT_USER_COMPANY_ID');
        $userId = $this->CI->session->userdata('iUserId');

        $file_path = $this->CI->config->item('upload_path') . 'queries/' . $companyId . '/' . $userId . '/' . $module . '.text';
        $f = fopen($file_path, 'r');
        $query = fread($f, filesize($file_path));
        fclose($f);
        $pos = strrpos($query, "LIMIT");
        if ($pos !== false) {
            $newQuery = substr($query, 0, $pos);
        }
        $getvar = $this->CI->input->get();
        $data = $this->CI->model_support->query($newQuery);
        for ($i = 0; $i < count($data); $i++) {
            $id = $data[$i][$field];
            $current_act_type = ($module == "activities") ? $data[$i]['act_type'] : '';

            if ($id == $this->decryptData($getvar['id']) && $current_act_type == $activity_type) {

                if ($module == "activities") {
                    $from_act_type = $data[$i - 1]['act_type'];
                    $to_act_type = $data[$i + 1]['act_type'];
                }

                $pid = urlencode($this->encryptData($data[$i - 1][$field]));
                $nid = urlencode($this->encryptData($data[$i + 1][$field]));
                $ids['pid'] = $pid;
                $ids['nid'] = $nid;
                $ids['current_act'] = $current_act_type;
                $ids['from_view_page'] = strtolower(substr($from_act_type, 0, -1)) . '_view';
                $ids['to_view_page'] = strtolower(substr($to_act_type, 0, -1)) . '_view';
                break;
            }
        }
        return $ids;
    }

    function getUserName($userId) {
        $this->CI->db->select('CONCAT(vSalutation, " ", vFirstName, " ", vMiddleName, " ", vLastName) as name', FALSE);
        $this->CI->db->from('user_master');
        $this->CI->db->where('iUserId', $userId);
        $array = $this->CI->db->get('country')->result_array();
        return $array[0]['name'];
    }

    function changeDateTimeFormat($date_time) {
        if ($date_time != '') {
            $dateFormat = $this->CI->config->item('YT_USER_DATE_FORMAT');
            $timeFormat = $this->CI->config->item('YT_USER_TIME_FORMAT');

            $time_format = ($timeFormat == "12") ? " h:i A" : " H:i:s";
            $formated_datetime = date($dateFormat . $time_format, strtotime($date_time));
        } else {
            $formated_datetime = ' ---';
        }
        return $formated_datetime;
    }

    function changeDateFormat($date, $date_format = '') {
        if ($date != '') {
            $dateFormat = ($date_format == '') ? $this->CI->config->item('YT_USER_DATE_FORMAT') : $date_format;
            $formated_date = date($dateFormat, strtotime($date));
        } else {
            $formated_date = ' ---';
        }
        return $formated_date;
    }

    function changeTimeFormat($time, $time_format = '') {
        if ($time != '') {
            $timeFormat = ($time_format == '') ? $this->CI->config->item('YT_USER_TIME_FORMAT') : $time_format;
            $time_format = ($timeFormat == "12") ? "h:i A" : "H:i:s";
            $formated_time = date($time_format, strtotime($time));
        } else {
            $formated_time = ' ---';
        }

        return $formated_time;
    }

    function getNameSource($type = '', $id = '') {
        $this->CI->load->model('content/model_support');
        $fields = $table = $where = '';
        $result['name'] = '';
        switch (strtolower($type)) {
            case 'lead':
                $fields = 'trim(CONCAT(lead_master.vSalutation," ",lead_master.vFirstName," ",lead_master.vMiddleName," ",lead_master.vLastName)) as source_name';
                $table = "lead_master";
                $where = "lead_master.iLeadId = '$id'";
                break;
            case 'contact':
                $fields = 'trim(CONCAT(contact_master.vSalutation," ",contact_master.vFirstName," ",contact_master.vMiddleName," ",contact_master.vLastName)) as source_name';
                $table = "contact_master";
                $where = "contact_master.iContactId = '$id'";
                break;
            case 'account':
                $fields = 'trim(vName) as source_name';
                $table = "account_master";
                $where = "account_master.iAccountId = '$id'";
                break;
            case 'vendor':
                $fields = 'trim(vName) as source_name';
                $table = "vendor_master";
                $where = "vendor_master.iVendorId = '$id'";
                break;
        }
        if ($fields != '' && $table != '' && $where != '') {
            $query = "Select $fields from $table where $where";
            $data = $this->CI->model_support->query($query);
            $result['source_name'] = $data[0]['source_name'];
        }
        return $result;
    }

    function relatedModules($module, $type, $page = '') {
        $ext_cond = '';

        switch ($type) {
            case "Lead":
                $tbl = "lead_master";
                $field = "iLeadId,CONCAT(vFirstName,' ',vLastName) as vFirstName";
                $fieldlist = array("iLeadId", "vFirstName");
                $id = ($page == 'participants_list') ? 'Lead' : 'iCallId';
                if ($module == "call") {
                    $id = 'iCallToId';
                }
                $ext_cond = ' AND (eConverted = "No" OR eConverted is NULL)';
                break;
            case "Contact":
                $tbl = "contact_master";
                $field = "iContactId,CONCAT(vFirstName,' ',vLastName) as vFirstName";
                $fieldlist = array("iContactId", "vFirstName");
                $id = ($page == 'participants_list') ? 'Contact' : 'iCallId';
                if ($module == "call") {
                    $id = 'iCallToId';
                }
                break;
            case "Account":
                $tbl = "account_master";
                $field = "iAccountId,vName";
                $fieldlist = array("iAccountId", "vName");
                $id = "iRelatedId";
                break;
            case "Potential":
                $tbl = "potential_master";
                $field = "iPotentialId,vName";
                $fieldlist = array("iPotentialId", "vName");
                $id = "iRelatedId";
                break;
            case "Vendor":
                $tbl = "vendor_master";
                $field = "iVendorId,vName";
                $fieldlist = array("iVendorId", "vName");
                $id = ($page == 'participants_list') ? 'Vendor' : 'iRelatedId';
                break;
            case "Representative":
                $tbl = "vendor_representative";
                $field = "iRepId,vName";
                $fieldlist = array("iRepId", "vName");
                $id = "iRelatedId";
                break;
            case "Product":
                $tbl = "product_master";
                $field = "iProductId,vName";
                $fieldlist = array("iProductId", "vName");
                $id = "iRelatedId";
                break;
            case "Case":
                $tbl = "case_master";
                $field = "iCaseId,vSubject";
                $fieldlist = array("iCaseId", "vSubject");
                $id = "iRelatedId";
                break;
            case "User":
                $tbl = "user_master";
                $field = "iUserId,CONCAT(vFirstName,' ',vLastName) as vFirstName";
                $fieldlist = array("iUserId", "vFirstName");
                $id = "User";
                break;
        }

        $postArr['tbl'] = $tbl;
        $postArr['field'] = $field;
        $postArr['fieldlist'] = $fieldlist;
        $postArr['id'] = $id;
        $postArr['ext_cond'] = $ext_cond;

        return $postArr;
    }

    function getFileType($ext) {
        $file_type = 'other';

        /* archive extensions */
        $archive_types = array('zip', 'tar', 'tar.gz');

        /* audio extensions */
        $audio_types = array('mp3', 'wav', 'midi', 'aac', 'ogg', 'wma', 'm4a', 'mid', 'orb', 'aif');

        /* excel/csv extensions */
        $excel_types = array('xls', 'xlsx', 'csv');

        /* images extensions */
        $image_types = array('jpeg', 'bmp', 'png', 'gif', 'jpg');

        /* pdf extensions */
        $pdf_types = array('pdf');

        /* power point extensions */
        $ppt_types = array('ppt', 'pptx', 'pps', 'ppsx');

        /* text extensions */
        $text_types = array('txt');

        /* movie extensions */
        $video_types = array('mov', 'flv', 'mpeg', 'mpg', 'mp4', 'avi', 'wmv', 'qt', '3gp');

        /* word extensions */
        $doc_types = array('doc', 'docx');

        /* document extensions */
//$document_types = array('txt', 'pdf', 'ppt', 'pps', 'xls', 'doc', 'xlsx', 'pptx', 'ppsx', 'docx', 'csv');

        if (in_array(strtolower($ext), $archive_types)) {
            $file_type = 'Archive';
        } else if (in_array(strtolower($ext), $audio_types)) {
            $file_type = 'Audio';
        } else if (in_array(strtolower($ext), $excel_types)) {
            $file_type = 'Excel';
        } else if (in_array(strtolower($ext), $image_types)) {
            $file_type = 'Image';
        } else if (in_array(strtolower($ext), $pdf_types)) {
            $file_type = 'PDF';
        } else if (in_array(strtolower($ext), $ppt_types)) {
            $file_type = 'Powerpoint';
        } else if (in_array(strtolower($ext), $text_types)) {
            $file_type = 'Text';
        } else if (in_array(strtolower($ext), $video_types)) {
            $file_type = 'Video';
        } else if (in_array(strtolower($ext), $doc_types)) {
            $file_type = 'Word';
        }
        return $file_type;
    }

    function getFullName($module, $id) {
        if ($module == "Contact") {
            $tbl = 'contact_master';
            $idfield = 'iContactId';
        } else if ($module == "User") {
            $tbl = 'user_master';
            $idfield = 'iUserId';
        } else if ($module == "Lead") {
            $tbl = 'lead_master';
            $idfield = 'iLeadId';
        }

        $where = $idfield . " = " . $id;
        $this->CI->db->select('CONCAT(vSalutation, " ", vFirstName, " ", vMiddleName, " ", vLastName) as name', FALSE);
        $this->CI->db->from($tbl);
        $this->CI->db->where($where);
        $array = $this->CI->db->get()->result_array();
        $fullName = trim($array[0]['name']);
        return $fullName;
    }

    function messageTime($time) {
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = strtotime($this->getCurrentDateTime());

        $difference = $now - $time;

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        if ($j > 1) {
            $return = date('d M', $time);
        } else {
            $return = date('h:i a', $time);
        }
        return $return;
    }

    function getDetails($type, $id) {

        $viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view'));
        $tbl = '';

        switch ($type) {
            case "Lead":
                $tbl = "lead_master";
                $idField = "iLeadId";
                $nameField = "CONCAT(vFirstName,' ',vLastName) as name, iUserId";
                $icon = "fa-sitemap";
                break;
            case "Contact":
                $tbl = "contact_master";
                $idField = "iContactId";
                $nameField = "CONCAT(vFirstName,' ',vLastName) as name, iUserId";
                $icon = "fa-book";
                break;
            case "Account":
                $tbl = "account_master";
                $idField = "iAccountId";
                $nameField = "vName as name, iUserId";
                $icon = "fa-bank";
                break;
            case "Potential":
                $tbl = "potential_master";
                $idField = "iPotentialId";
                $nameField = "vName as name, iUserId";
                $icon = "fa-puzzle-piece";
                break;
            case "Vendor":
                $tbl = "vendor_master";
                $idField = "iVendorId";
                $nameField = "vName as name, iUserId";
                $icon = "fa-male";
                break;
            case "Representative":
                $tbl = "vendor_representative";
                $idField = "iRepId";
                $nameField = "vName as name, iUserId";
                $icon = "fa-users";
                break;
            case "Product":
                $tbl = "product_master";
                $idField = "iProductId";
                $nameField = "vName as name, iUserId";
                $icon = "fa-cubes";
                break;
            case "Case":
                $tbl = "case_master";
                $idField = "iCaseId";
                $nameField = "vSubject as name, iUserId";
                $icon = "fa-tag";
                break;
            case "User":
                $tbl = "user_master";
                $idField = "iUserId";
                $nameField = "CONCAT(vFirstName,' ',vMiddleName,' ',vLastName) as name, iUserId as iUserId";
                $icon = "fa-user";
                break;
            case "Task":
                $tbl = "task_master";
                $idField = "iTaskId";
                $nameField = "vSubject as name, iCreatedBy as iUserId";
                $viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view')) . '&f=' . urlencode($this->encryptData('activities'));
                $icon = "fa-tasks";
                break;
            case "Event":
                $tbl = "event_master";
                $idField = "iEventId";
                $nameField = "vTitle as name, iCreatedBy as iUserId";
                $viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view')) . '&f=' . urlencode($this->encryptData('activities'));
                $icon = "fa-calendar-o";
                break;
            case "Call":
                $tbl = "call_master";
                $idField = "iCallId";
                $nameField = "vSubject as name, iCreatedBy as iUserId";
                $viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view')) . '&f=' . urlencode($this->encryptData('activities'));
                $icon = "fa-phone";
                break;
            case "Feed":
                $tbl = "activity_master";
                $idField = "iActivityId";
                $nameField = "tMessage as name, iUserId";
//$viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view')) . '&f=' . urlencode($this->encryptData('activities'));
                break;
            case "PackageType":
                $tbl = "package_type_master";
                $idField = "iPackageTypeId";
                $nameField = "vPackageType as name, iPackageTypeId as iUserId";
//$viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view')) . '&f=' . urlencode($this->encryptData('activities'));
                break;
            case "Transport":
                $tbl = "package_transport";
                $idField = "iPackageTransportId";
                $nameField = "(select vName from cab_master where cab_master.iCabId=package_transport.iCabId) as name, iPackageTransportId as iUserId";
//$viewUrl = strtolower($type) . '_view?id=' . urlencode($this->encryptData($id)) . '&m=' . urlencode($this->encryptData('view')) . '&f=' . urlencode($this->encryptData('activities'));
                break;
        }

        if ($tbl != '') {
            $ext_cond = $idField . " = '" . $id . "'";
            $reply = $this->CI->model_support->getData($tbl, $nameField, array(), $ext_cond);
            $data['name'] = $reply[0]['name'];
        }
        $data['viewurl'] = $viewUrl;
        $data['icon'] = $icon;
        if ($type == "User") {
            $data['iUserId'] = $id;
        } else {
            $data['iUserId'] = $reply[0]['iUserId'];
        }
        return $data;
    }

    function getCustomizeModules() {
//$excludeModules = array('Dashboard', 'Feed', 'Activities', 'Messages', 'Cases');
        $this->CI->db->select('iModuleId,vModule');
        $this->CI->db->from('module_master');
        $this->CI->db->where('iParentId', '0');
//$this->CI->db->where('eStatus', 'Active');
        $this->CI->db->where('eMenuType', 'Front');
        $this->CI->db->where('vModule != ', 'Dashboard');
        $this->CI->db->where('vModule != ', 'Feed');
        $this->CI->db->where('vModule != ', 'Activities');
        $this->CI->db->where('vModule != ', 'Messages');
        $this->CI->db->where('vModule != ', 'Cases');
        $this->CI->db->where('vModule != ', 'Tasks');
        $this->CI->db->where('vModule != ', 'Events');
        $this->CI->db->where('vModule != ', 'Calls');
        $this->CI->db->order_by('iSequenceOrder');
        $data = $this->CI->db->get()->result_array();
        return $data;
    }

//    function getSections($companyid, $moduleid) {
//        $this->CI->db->select('sc.*, msc.iModuleSettingsCustomizationId, msc.iSectionColumn, msc.vFields, msc.iSequenceOrder as fieldorder, ( SELECT  COUNT(*) FROM module_settings_customization as msc WHERE sc.iSectionCustomizationId = msc.iSectionCustomizationId) AS "fieldcount",  (SELECT  COUNT(*) FROM module_settings_customization as msc WHERE sc.iSectionCustomizationId = msc.iSectionCustomizationId AND msc.iSectionColumn = "1" AND msc.eStatus = "Active") AS "col1count", (SELECT  COUNT(*) FROM module_settings_customization as msc WHERE sc.iSectionCustomizationId = msc.iSectionCustomizationId AND msc.iSectionColumn = "2" AND msc.eStatus = "Active") AS "col2count"');
//        $this->CI->db->from('section_customization as sc');
//        $this->CI->db->join('module_settings_customization as msc', 'sc.iSectionCustomizationId = msc.iSectionCustomizationId', 'left');
//        $this->CI->db->where('sc.iCompanyId', $companyid);
//        $this->CI->db->where('sc.iModuleId', $moduleid);
//        $this->CI->db->where('sc.isDelete != ', '1');
//        $this->CI->db->where('sc.eStatus', 'Active');
//        $this->CI->db->where('msc.eStatus', 'Active');
//        $this->CI->db->order_by('sc.iSequenceOrder, msc.iSectionColumn, msc.iSequenceOrder');
//        //$this->CI->db->group_by('sc.iSectionId');
//        $data = $this->CI->db->get()->result_array();
//        $this->CI->db->last_query();
//        return $data;
//    }

    function getSections($companyid, $moduleid, $packagetypeid = '') {
        $this->CI->db->select('sc.*');
        $this->CI->db->from('section_customization as sc');
        $this->CI->db->where('sc.iCompanyId', $companyid);
        $this->CI->db->where('sc.iModuleId', $moduleid);
        $this->CI->db->where('sc.isDelete != ', '1');
        if ($packagetypeid != '') {
            $this->CI->db->where('sc.iPackageTypeId', $packagetypeid);
        }
//$this->CI->db->where('sc.eStatus', 'Active');
        $this->CI->db->order_by('sc.iSequenceOrder');
//$this->CI->db->group_by('sc.iSectionId');
        $data = $this->CI->db->get()->result_array();
        $this->CI->db->last_query();
        return $data;
    }

    function getSectionColumns($sectionid, $packagetypeid = '') {
        $this->CI->db->select('*, (SELECT COUNT(*) FROM module_settings_customization as msc WHERE msc.iSectionCustomizationId = "' . $sectionid . '" AND msc.eStatus = "Active" AND msc.isVisible = "1" AND msc.isRemove = "0") AS "fieldcount",  (SELECT  COUNT(*) FROM module_settings_customization as msc WHERE msc.iSectionCustomizationId = "' . $sectionid . '" AND msc.iSectionColumn = "1" AND msc.eStatus = "Active" AND msc.isVisible = "1" AND msc.isRemove = "0") AS "col1count", (SELECT  COUNT(*) FROM module_settings_customization as msc WHERE msc.iSectionCustomizationId = "' . $sectionid . '" AND msc.iSectionColumn = "2" AND msc.eStatus = "Active" AND msc.isVisible = "1" AND msc.isRemove = "0") AS "col2count"');
        $this->CI->db->from('module_settings_customization');
        $this->CI->db->where('iSectionCustomizationId', $sectionid);
        $this->CI->db->where('isDelete != ', '1');
        $this->CI->db->where('eStatus', 'Active');
        $this->CI->db->where('isVisible', '1');
        $this->CI->db->where('isRemove', '0');
        if ($packagetypeid != '') {
            $this->CI->db->where('iPackageTypeId', $packagetypeid);
        }
        $this->CI->db->order_by('iSequenceOrder');
        $data = $this->CI->db->get()->result_array();
        return $data;
    }

    function getRemovedColumns($moduleid) {
        $this->CI->db->select('*');
        $this->CI->db->from('module_settings_customization');
        $this->CI->db->where('iModuleId', $moduleid);
        $this->CI->db->where('isDelete != ', '1');
        $this->CI->db->where('isRemove', '1');
        $this->CI->db->order_by('iSequenceOrder');
        $data = $this->CI->db->get()->result_array();
        return $data;
    }

    function getFieldLabel($field, $module = '') {
        $prefix = substr($field, 0, 2);
        if ($prefix == 'dt') {
            $skipCharNum = 2;
        } else {
            $skipCharNum = 1;
        }

        if ($field != "iUserId") {
            $field = $this->addSpaceInString(substr($field, $skipCharNum));
            $originalArray = array('I ', ' Id');
            $replaceArray = array('I', '');
            $field = str_replace($originalArray, $replaceArray, $field);
        } else {
            $field = $module . " Owner";
        }
        return $field;
    }

    function getModuleId($modulename) {
        $this->CI->db->select('*');
        $this->CI->db->from('module_master');
        $this->CI->db->where('vModule', $modulename);
        $data = $this->CI->db->get()->result_array();
        $moduleid = $data[0]['iModuleId'];
        return $moduleid;
    }

    function getFieldHtml($column) {
//pr($column);
        $requiredclass = '';

        if ($column['isMandatory'] == "1") {

            $requiredclass = 'requiredField';
        }
        if ($column['iCustomFieldId'] != "0") {
            $column['vFields'] = 'CU[' . $column['iCustomFieldId'] . ']';
//  if(isset($column['value'])) {

            if ($column['mode'] == "edit") {
                $fields = 'tFieldValue';
                $ext_cond = 'iModuleCustomFieldId = "' . $column['iCustomFieldId'] . '" AND iModuleId = "' . $column['moduleid'] . '" AND iPackageTypeId = "' . $column['packagetypeid'] . '" AND iItemId = "' . $column['packageid'] . '" AND isDelete != "1" AND eStatus = "Active"';
                $fieldvaluedata = $this->CI->model_support->getData('module_custom_fields_value', array(), $ext_cond);
                $column['value'] = $fieldvaluedata[0]['tFieldValue'];
            }

            $fields = '*';
            $ext_cond = 'iModuleCustomFieldId = "' . $column['iCustomFieldId'] . '" AND isDelete != "1" AND eStatus = "Active"';
            $modulecustomdata = $this->CI->model_support->getData('module_custom_fields', $fields, array(), $ext_cond);
            $customfieldOptions = $modulecustomdata[0]['tOptions'];
            $customfieldOptionsArr = explode("|", $customfieldOptions);
            $customfieldDefaultvalue = $modulecustomdata[0]['vDefaultValue'];
        }

        $moduleArray = array('Package' => 'package_master:iPackageId:vPackageName', 'Country' => 'country:iCountryId:vCountry', 'Currency' => 'country:iCountryId:CONCAT(vCurrencyName," (",vCountry,")") as currencyname', 'Account' => 'account_master:iAccountId:vName', 'PackageType' => 'package_type_master:iPackageTypeId:vPackageType');

        switch ($column['eType']) {

            case "Text":
                $field = '<input type="text" class="form-control ' . $requiredclass . '" id="' . $column['vFields'] . '" name="' . $column['vFields'] . '" placeholder="" value="' . $column['value'] . '" >';
                break;

            case "Textarea":
                $field = '<textarea class="form-control ' . $requiredclass . '" rows="3" id="' . $column['vFields'] . '" name="' . $column['vFields'] . '">' . $column['value'] . '</textarea>';
                break;

            case "Select":
                $options = '<option value="">-None-</option>';
                if ($column['iCustomFieldId'] != "0") {
                    if (!isset($column['mode'])) {
                        $checkvalue = $customfieldDefaultvalue;
                    } else {
                        $checkvalue = $column['value'];
                    }

                    foreach ($customfieldOptionsArr as $cvalue) {
                        $options .= '<option value="' . $cvalue . '" ' . ($cvalue == $checkvalue ? 'Selected' : '') . '>' . $cvalue . '</option>';
                    }
                } else {
                    if (substr($column['vFields'], 0, 1) === 'e') {
                        $enumValues = $this->getEnumValues($column['table'], $column['vFields']);

                        foreach ($enumValues as $evalue) {
                            $options .= '<option value="' . $evalue . '" ' . ($evalue == $column['value'] ? 'Selected' : '') . '>' . $evalue . '</option>';
                        }
                    } else if ($column['eModule'] != "") {

                        if ($column['eModule'] == "User") {
                            $options = '';
                            $ownerlist = $this->CI->model_support->getOwnerList();
                            if ($column['vFields'] != "iUserId" && $column['vFields'] != "iPassonToId") {
                                $options .= '<option value="">-None-</option>';
                            }
                            foreach ($ownerlist as $o) {
                                if (isset($column['value'])) {
                                    $options .= '<option value="' . $o['iUserId'] . '" ' . ($o['iUserId'] == $column['value'] ? 'Selected' : '') . ' >' . $o['ownername'] . '</option>';
                                } else {
                                    if (($column['vFields'] == "iUserId" || $column['vFields'] == "iPassonToId") && $o['iUserId'] == $this->CI->session->userdata('iUserId')) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    $options .= '<option value="' . $o['iUserId'] . '" ' . $selected . ' >' . $o['ownername'] . '</option>';
                                }
                            }
                        } else {

                            if (array_key_exists($column['eModule'], $moduleArray)) {
                                $values = explode(":", $moduleArray[$column['eModule']]);
                                $table = $values[0];
                                $fieldid = $values[1];
                                $fieldvalue = $values[2];

                                $ext_cond = 'isDelete != "1" AND eStatus = "Active"';

                                $fields = $fieldid . ',' . $fieldvalue;

                                $data = $this->CI->model_support->getData($table, $fields, array(), $ext_cond);

                                $fieldvalue_arr = explode('as', $fieldvalue);
                                $fieldvalue = isset($fieldvalue_arr[1]) ? trim($fieldvalue_arr[1]) : trim($fieldvalue_arr[0]);

                                foreach ($data as $key => $value) {
//pr($value);
                                    $options .= '<option value="' . $value[$fieldid] . '" ' . ($value[$fieldid] == $column['value'] ? 'Selected' : '') . '>' . $value[$fieldvalue] . '</option>';
                                }
                            }
                        }
                    } else {
                        $options = '<option value="">-None-</option>';
                    }
                }
                $field = '<select class="form-control ' . $requiredclass . '" name="' . $column['vFields'] . '" id="' . $column['vFields'] . '">' . $options . '</select>';
                break;

            case "Multiselect":
                if ($column['iCustomFieldId'] != "0") {
                    if (!isset($column['mode'])) {
                        $checkvalue = $customfieldDefaultvalue;
                    } else {
                        $checkvalue = $column['value'];
                    }

                    foreach ($customfieldOptionsArr as $cvalue) {
                        $options .= '<option value="' . $cvalue . '" ' . ($cvalue == $checkvalue ? 'Selected' : '') . '>' . $cvalue . '</option>';
                    }
                } else if ($column['eModule'] != "") {

                    if (array_key_exists($column['eModule'], $moduleArray)) {
                        $values = explode(":", $moduleArray[$column['eModule']]);
                        $table = $values[0];
                        $fieldid = $values[1];
                        $fieldvalue = $values[2];

                        $ext_cond = 'isDelete != "1" AND eStatus = "Active"';

                        $fields = $fieldid . ',' . $fieldvalue;

                        $data = $this->CI->model_support->getData($table, $fields, array(), $ext_cond);

                        foreach ($data as $key => $value) {
                            $options .= '<option value="' . $value[$fieldid] . '" ' . ($value[$fieldid] == $column['value'] ? 'Selected' : '') . '>' . $value[$fieldvalue] . '</option>';
                        }
                    }
                } else {
                    $options = '<option value="">-None-</option>';
                }
                $field = '<select class="form-control ' . $requiredclass . '" multiple="multiple" name="' . $column['vFields'] . '[]" id="' . $column['vFields'] . '">' . $options . '</select>';
                break;

            case "Select with group":
                $options = '<option value="">-None-</option>';
                if ($column['iCustomFieldId'] != "0") {
                    if (!isset($column['mode'])) {
                        $checkvalue = $customfieldDefaultvalue;
                    } else {
                        $checkvalue = $column['value'];
                    }

                    $selectgroupOptionsArr = explode("||", $customfieldOptions);
                    foreach ($selectgroupOptionsArr as $svalue) {
                        $selectoptionArr = explode("|", $svalue);
                        $count = count($selectoptionArr);
                        foreach ($selectoptionArr as $sekey => $sevalue) {

                            if ($sekey == '0') {
                                $options .= '<optgroup label="' . $sevalue . '">';
                            } else {
                                $options .= '<option value="' . $sevalue . '" ' . ($sevalue == $checkvalue ? 'Selected' : '') . '>' . $sevalue . '</option>';
                            }

                            if ($sekey + 1 == $count) {
                                $options .= '</optgroup>';
                            }
                        }
                    }
                }
                $field = '<select class="form-control ' . $requiredclass . '" name="' . $column['vFields'] . '" id="' . $column['vFields'] . '">' . $options . '</select>';
                break;
            case "Multiselect with group":
                $options = '<option value="">-None-</option>';
                if ($column['iCustomFieldId'] != "0") {
                    if (!isset($column['mode'])) {
                        $checkvalue = $customfieldDefaultvalue;
                    } else {
                        $checkvalue = $column['value'];
                    }

                    $selectgroupOptionsArr = explode("||", $customfieldOptions);
                    foreach ($selectgroupOptionsArr as $svalue) {
                        $selectoptionArr = explode("|", $svalue);
                        $count = count($selectoptionArr);
                        foreach ($selectoptionArr as $sekey => $sevalue) {

                            if ($sekey == '0') {
                                $options .= '<optgroup label="' . $sevalue . '">';
                            } else {
                                $options .= '<option value="' . $sevalue . '" ' . ($sevalue == $checkvalue ? 'Selected' : '') . '>' . $sevalue . '</option>';
                            }

                            if ($sekey + 1 == $count) {
                                $options .= '</optgroup>';
                            }
                        }
                    }
                }
                $field = '<select class="form-control ' . $requiredclass . '" name="' . $column['vFields'] . '[]" id="' . $column['vFields'] . '" multiple="multiple">' . $options . '</select>';
                break;
            case "Radio":
                $field = '';
                break;
            case "Checkbox":
                $field = '<div class="make-switch" data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                         <input type="hidden" name="' . $column['vFields'] . '" value="No">
                              <input type="checkbox" name="' . $column['vFields'] . '" id="' . $column['vFields'] . '" value="Yes" ' . ($column['value'] == "Yes" ? 'checked=""' : '') . '></div>';
                break;
            case "Date":
                $date = ($column['value'] == '0000-00-00' || $column['value'] == "") ? "" : $this->changeDateFormat($column['value'], 'm/d/Y');
                $field = '<input type="text" id="' . $column['vFields'] . '" name="' . $column['vFields'] . '" class="form-control datepicker ' . $requiredclass . '" readonly="readonly" value="' . $date . '" >
                              <span class="input-group-addon"><i class="fa fa-close"></i></span>';
                $div_class = "input-group  customdate date";
                break;
            case "Time":
                $field = '<input type="text" id="' . $column['vFields'] . '" name="' . $column['vFields'] . '" class="form-control timepicker ' . $requiredclass . '" >
                              ';
                $div_class = "input-group customtime bootstrap-timepicker";
                break;
            case "DateTime":
                $field = '';
                break;
            case "Date Range":
                $fromdate = ($column['value'] == '0000-00-00' || $column['value'] == "") ? "" : $this->changeDateFormat($column['value'], 'm/d/Y');
                $todate = ($column['all_values']['dtToDate'] == '0000-00-00' || $column['value'] == "") ? "" : $this->changeDateFormat($column['all_values']['dtToDate'], 'm/d/Y');
                if ($fromdate != "" && $todate != "") {
                    $date = $fromdate . " - " . $todate;
                } else {
                    $date = "";
                }
//$todate = ($column['value'] == '0000-00-00') ? "" : $this->changeDateFormat($column['value'], 'm/d/Y');
                $field = '<input type="text" id="' . $column['vFields'] . '" name="' . $column['vFields'] . '" class="form-control clsdaterangepicker ' . $requiredclass . '" readonly="readonly" value="' . $date . '" >';
// $div_class = "input-group  customdate date";
                break;
            default:
                break;
        }

        $return['field'] = $field;
        $return['class'] = $div_class;
        return $return;
    }

    function arrayRecursiveDiff($aArray1, $aArray2) {
        $aReturn = array();

        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue != $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }

        return $aReturn;
    }

    public function getColumn($tbl = '') {
        $type = $this->CI->db->query("SHOW COLUMNS FROM {$tbl}")->result_array();
        return $type;
    }

    function getBackPanelMenu($iParentId = '', $location = "Header", $excludemenu = '') {
        $adminId = $this->CI->session->userdata('iAdminId');
        $admin_parentId = $this->CI->config->item('YT_ADMIN_PARENT_ID');
        $admin_roleId = $this->CI->config->item('YT_ADMIN_ROLE_ID');

        $iParentId = ($iParentId == '') ? 0 : $iParentId;
        $this->CI->db->select();
        $this->CI->db->where("m.iMenuParentId", "$iParentId");
//        $this->CI->db->where("m.iParentId", "$iParentId");
        $this->CI->db->where("m.eMenuType", 'Back');
        if ($iParentId > 0) {
            $this->CI->db->where("m.DisplayAsSubMenu", '1');
        } else {
            $this->CI->db->where("m.DisplayAsMenu", '1');
        }
        $this->CI->db->from("module_master AS m");
//        if (strtolower($this->CI->config->item('YT_ADMIN_PROFILE')) == "standard" && $excludemenu != 'activities') {
        $this->CI->db->join("permission AS up", "m.iModuleId = up.iModuleId");
        $this->CI->db->where("up.iRoleId", $admin_roleId);
        $this->CI->db->where("(up.isRead = 1 || up.isWrite = 1 || up.isDelete = 1) and m.eStatus =", 'Active');
//        } else {
        $this->CI->db->where("m.eStatus", 'Active');
//        }
        $this->CI->db->order_by("iSequenceOrder");
        $menu_data = $this->CI->db->get()->result_array();
//echo $this->CI->db->last_query()."====<br/>";
        return $menu_data;
    }

//    function getBackPanelMenu($iParentId = '', $location = "Header", $excludemenu = '') {
//        $iParentId = ($iParentId == '') ? 0 : $iParentId;
//        $this->CI->db->select();
//        $this->CI->db->where("m.iParentId", "$iParentId");
//        $this->CI->db->where("m.eMenuType", 'Back');
//        $this->CI->db->from("module_master AS m");
//        $this->CI->db->where("m.eStatus", 'Active');
//        $this->CI->db->order_by("iSequenceOrder");
//        $menu_data = $this->CI->db->get()->result_array();
//        //echo $this->CI->db->last_query()."<br/>";
//        return $menu_data;
//    }

    function checkModulePermission($moduleId) {
        $companyId = $this->CI->config->item('YT_USER_COMPANY_ID');

        $this->CI->db->select('*');
        $this->CI->db->where("m.iCompanyId", "$companyId");
        $this->CI->db->where("m.iModuleId", "$moduleId");
        $this->CI->db->from("company_module_master AS m");
        $module_data = $this->CI->db->get()->result_array();

        if (count($module_data) == 0) {
            $permission = 0;
        } else {
            $permission = 1;
        }
        return $permission;
    }

    function generateTransactionNumber() {
        $tran_no = substr(str_replace('.', '', strtoupper(uniqid(rand(3)))), 6, 6);
        return $tran_no;
    }

    function send_email($data, $type) {
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $this->CI->load->library('email');
        $this->CI->load->model('tools/emailer');
        $this->CI->email->clear(TRUE);
        $email = $data['vEmail'];

        $filename = $data['invoiceno'] . '_' . date('YmdHis') . '_' . uniqid() . '.pdf';

        $this->CI->email->from($this->CI->config->item('USE_SMTP_SERVERUSERNAME'), "VihaanYT");
        $this->CI->email->to($email);
        $template = $this->CI->emailer->getEmailContent($type);

        $tEmailMessage = $template[0]['tEmailMessage'];
        $display = 'none';
        if ($data['amount'] > $this->CI->config->item('MINIMUM_AMOUNT')) {
            $display = 'block';
        }
        $findarray = array('#NAME#', '#COPY_RIGHTS#', '#PAYMENT_LINK#');
        $replacearray = array($data['name'], $this->CI->systemsettings->getSettings('COPYRIGHTED_TEXT'), $data['url']);

        $emailmsg = str_replace($findarray, $replacearray, $tEmailMessage);



        $pdfbody = '
<html>
    <head>
        <style>
            p { margin:0px; padding:0px; line-height:22px; }
        </style>
    </head>
    <body>
        <div style="font-family:Arial;font-size:11px;color:#000;margin:0px;padding:0px">
            <div width="100%" valign="middle" style="border-top:solid 0px #FFF;padding:8pt 0;font-size:20px;font-weight:bold;text-align:center;">SERVICE INVOICE</div>
            <table width="100%" border="0" style="margin:0 auto;border:1px solid #000;" cellpadding="0" cellspacing="0">  
                <tr>
                    <td width="100%" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="60%" valign="top" style="border-bottom:1px solid #000;border-right:1px solid #000;padding:8pt;line-height:20px">
                                    <strong>' . $this->CI->config->item('COMPANY_NAME') . '</strong>
                                    <p>' . strtoupper($this->CI->config->item('COMPANY_ADDRESS')) . ',<br>' . strtoupper($this->CI->config->item('COMPANY_CITY')) . '<br>CIN NO. ' . $this->CI->config->item('CIN_NO') . '</p>
                                </td>
                                <td width="31%" rowspan="2" valign="top" style="height:300px;border-bottom:1px solid #000;">
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%" >
                                        <tr>
                                            <td valign="top"  style="width:50%;border-bottom:1px solid #000;border-right:1px solid #000;padding:8pt;">
                                                <p>Invoice No.<br><b>' . $data['invoiceno'] . '</b></p>
                                            </td>
                                            <td valign="top" style="width:50%;border-bottom:1px solid #000;padding:8pt;">
                                                <p>Dated<br><b>' . $this->systemDateFormat($data['invoice_date']) . '</b></p>
                                            </td>
                                        </tr>
                                        <tr align="center" style="font-size:20px;text-align:center;" cellspacing="10px">
                                            <td colspan="2" rowspan="2" valign="center" style="text-align:center;">
                                                <br><br>
                                                <a href="' . $data['url'] . '" target="_blank" style="color:yellow">Pay Now </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="60%" valign="top" style="border-bottom:1px solid #000;border-right:1px solid #000;padding:8pt;line-height:20pxpadding-top:8pt">
                                    <p style="font-size:12px">Buyer:</p>
                                    <strong>' . $data['name'] . '</strong>
                                    <p>' . $data['address'] . ',<br>' . $data['city'] . ' ' . $data['zip'] . ' , ' . $data['state'] . '(' . strtoupper($data['country']) . ').</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="100%" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="59%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-bottom:1px solid #000;border-right:1px solid #000">Description of Goods</td>
                                <td width="31%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-bottom:1px solid #000">Amount</td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-right:1px solid #000">' . $data['packagename'] . '<br><p style="font-weight:normal">From ' . $this->systemDateFormat($data['startdate']) . ' to ' . $this->systemDateFormat($data['enddate']) . '</p></td>
                                <td width="30%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;text-align: right;padding-right:5pt;">' . $data['packagecharge'] . '</td>
                            </tr>
                            <tr>
                                <td width="60%" style="height:50px;font-size:15px;padding-left:11pt;border-right:1px solid #000;"></td>
                                <td width="30%"></td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-right:1px solid #000;padding-right:8pt;text-align: right;">INSTALLATION CHARGE</td>
                                <td width="30%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;text-align: right;padding-right:5pt;">' . $data['installationcharge'] . '</td>
                            </tr>
                            <tr>
                                <td width="60%" style="font-size:15px;padding-left:11pt;border-right:1px solid #000;"></td>
                                <td width="30%"></td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-right:1px solid #000;padding-right:8pt;text-align: right;">SERVICE TAX ' . $this->CI->config->item('SERVICE_TAX') . ' %</td>
                                <td width="30%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;text-align: right;padding-right:5pt;border-bottom:1px solid #000;">' . $data['servicecharge'] . '</td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="font-size:15px;padding-left:11pt;border-right:1px solid #000;text-align: right;padding-right:8pt;"></td>
                                <td width="30%" height="40" valign="middle" style="font-size:15px;padding-left:11pt;text-align: right;padding-right:5pt;">' . $data['total'] . '</td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-right:1px solid #000;padding-right:8pt;text-align: right;">' . $data['creditdebitLable'] . '</td>
                                <td width="30%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;text-align: right;padding-right:5pt;">' . $data['creditdebitValue'] . '</td>                                
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;border-right:1px solid #000;padding-right:8pt;text-align: right;"><span style="text-align:left;font-weight:normal; font-style:italic;">Less:</span> ROUND OFF</td>
                                <td width="30%" height="40" valign="middle" style="font-weight:bold;font-size:15px;padding-left:11pt;text-align: right;padding-right:5pt;">' . $data['roundvalue'] . '</td>                                
                            </tr>
                            <tr>
                                <td width="60%" style="height: 80px;border-right:1px solid #000;"></td>
                                <td width="30%"></td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="middle" style="text-align:right;font-weight:normal;font-size:16px;padding-right:5pt;border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000">Total</td>
                                <td width="30%" height="40" valign="middle" style="font-weight:bold;text-align:right;font-weight:bold;font-size:20px;border-top:1px solid #000;padding-right:5pt;border-bottom:1px solid #000">' . $data['amount'] . '</td>
                            </tr>
                            <tr>
                                <td width="60%" height="40" valign="top" style="text-align:left;font-weight:normal;font-size:15px;padding-left:5px"><p>Amount Chargable (in words)</p>
                                    <p><strong>' . ucwords($this->amountToWords($data['amount'])) . '<br>
                                            Only</strong></p>
                                </td>
                                <td width="30%" height="40" valign="top" style="text-align:right;font-weight:bold;font-size:15px;padding-right:5pt;font-style:italic">E. &amp; O.E</td>
                            </tr>
                        </table>                            
                    </td>
                </tr>
                <tr>
                    <td width="100%" height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td width="100%">
                        <table  width="100%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="60%">
                                    <table  width="100%"  border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="font-weight:normal;font-size:15px;padding-left:8pt">Company&#39;s Service Tax No. : <strong>' . $this->CI->config->item('SERVICE_TAX_NO') . '</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:normal;font-size:15px;padding-left:8pt">Company&#39;s Pan No. : <strong>' . $this->CI->config->item('PAN_NO') . '</strong></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="40%">&nbsp;</td>
                            </tr>
                        </table>                            
                    </td>
                </tr>
                <tr>
                    <td width="100%">
                        <table  width="100%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="35%">
                                    <table  width="100%"  border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="font-weight:normal;font-size:15px;padding-left:8pt">Declaration</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:normal;font-size:15px;padding-left:8pt">We declare that this invoice shows the actual price of the
                                                goods described and that all particulars are true and
                                                correct.
                                            </td>
                                        </tr>
                                    </table>                                        
                                </td>
                                <td width="65%">
                                    <table border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid #000;border-left:1px solid #000;width:100%">
                                        <tr>
                                            <td style="text-align:right;padding:8pt;font-weight:bold;font-size:14px">for ' . $this->CI->config->item('COMPANY_NAME') . '</td>
                                        </tr>
                                        <tr>
                                            <td height="50" style="text-align:right;"> </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right;padding:8pt;font-weight:normal;font-size:15px">Authorised Signatory</td>
                                        </tr>
                                    </table>                                        
                                </td>
                            </tr>
                        </table>                            
                    </td>
                </tr>
            </table>
            <div style="text-align: center;">
                <span width="100%" align="center" style="text-align:center;line-height:24px;font-size:14px;padding-top:20px;padding-bottom:20px;">SUBJECT TO AHMEDABAD JURISDICTION<br>
                        This is a Computer Generated Invoice</span>
            </div>
        </div>
    </body>
</html>
';
        $attach = $this->CI->config->item('upload_path') . "invoices/" . $filename;
        if (!file_exists($attach)) {
            $mpdf = new mPDF();
            $html = $pdfbody;
//            $mpdf->SetTitle("SERVICE INVOICE");
//            $mpdf->SetDisplayMode(80);
            $mpdf->WriteHTML($html);
            $temp_folder_path = $this->CI->config->item('upload_path') . "invoices";
            $this->createfolder($temp_folder_path);
            $path = $temp_folder_path . '/';
            $mpdf->Output($path . $filename);
        }
        $this->CI->email->subject("SERVICE INVOICE");
        $this->CI->email->message($emailmsg);
        $this->CI->email->attach($attach);
        $success = $this->CI->email->send();
//        pr($this->CI->email->print_debugger());
        return 1;
    }

    public function amountToWords($amount = "0", $major = "Rupees", $minor = "Paisa") {
        $number = number_format($amount, 2);
        list($rupee, $pence) = explode('.', $number);
        $words = " $major";
//        $words = " $major $pence $minor";
        if ($rupee == 0)
            $words = "Zero $words";
        else {
            $groups = explode(',', $rupee);
            $groups = array_reverse($groups);
            for ($index = 0; $index < count($groups); $index++) {
                if (($index == 1) && (strpos($words, 'hundred') === false) && ($groups[0] != '000'))
                    $words = ' and ' . $words;
                $words = $this->makeWord($groups[$index], $index) . $words;
            }
        }
        return $words;
        exit;
    }

    function makeWord($n, $index) {
        $units = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
        $teens = array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
        $tens = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
        $mag = array('', 'thousand', 'million', 'billion', 'trillion');

        $res = '';
        $na = str_pad("$n", 3, "0", STR_PAD_LEFT);

        if ($na == '000')
            return '';
        if ($na{0} != 0) {

            $res = ' ' . $units[$na{0}] . ' hundred';
        }
        if (($na{1} == '0') && ($na{2} == '0')) {
            return $res . ' ' . $mag[$index];
        }
        $res .= $res == '' ? '' : ' and';

        $t = (int) $na{1};
        $u = (int) $na{2};
        switch ($t) {
            case 0: $res .= ' ' . $units[$u];
                break;
            case 1: $res .= ' ' . $teens[$u];
                break;
            default:$res .= ' ' . $tens[$t] . ' ' . $units[$u];
                break;
        }
        $res .= ' ' . $mag[$index];
        return $res;
    }

    function systemDateFormat($date, $date_format = '') {
        if ($date != '') {
            $dateFormat = ($date_format == '') ? $this->CI->config->item('YT_DATE_FORMAT') : $date_format;
            $formated_date = date($dateFormat, strtotime($date));
        } else {
            $formated_date = ' ---';
        }
        return $formated_date;
    }

    public function send_sms($receiverno = '', $msg = '') {
        $wordcount = str_word_count($msg);
        if ($receiverno == '' || $msg == "" || $wordcount < 2) {
            return 0;
        }
//http://sms.rapidtechnologysolution.com//httpapi/smsapi?uname=vihaan1&password=vihaan@123&sender=VIHAAN&receiver=9724077474&route=T&msgtype=1&sms=hi tsting sms
        //Minimum 2 words required.
        $message = urlencode($msg);
        $apiurl = $this->CI->config->item('SMS_API_URL');
        $username = $this->CI->config->item('SMS_USER_NAME');
        $password = $this->CI->config->item('SMS_PASSWORD');
        $sender = $this->CI->config->item('SMS_SENDER');
        $route = $this->CI->config->item('SMS_ROUTE');
        $msgtype = $this->CI->config->item('SMS_MSG_TYPE');

        $url = $apiurl . '?uname=' . $username . '&password=' . $password . '&sender=' . $sender . '&receiver=' . $receiverno . '&route=' . $route . '&msgtype=' . $msgtype . '&sms=' . $message;
        /* $postData = array(
          'uname' => $username,
          'password' => $password,
          'sender' => $sender,
          'receiver' => $receiverno,
          'route' => $route,
          'msgtype' => $msgtype,
          'sms' => $message
          ); */
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_POST => true,
//            CURLOPT_POSTFIELDS => $postData
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }

}
