<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class import_export extends MX_Controller {

    public $case;

    public function __construct() {
        parent::__construct();
        // $dat=array();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_imports');
        $this->load->model('content/model_support');
    }

    public function imports_list() {
        
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        $extra_message = '';
        switch ($getvar['cs']) {
            case 'lead':
                $tbl = 'lead_master';
                $mandatory_fields = 'Company, Last Name';
                break;
            case 'account':
                $tbl = 'account_master';
                $mandatory_fields = 'Name';
                break;
            case 'contact':
                $tbl = 'contact_master';
                $mandatory_fields = 'Last Name';
                break;
            case 'vendor':
                $tbl = 'vendor_master';
                $mandatory_fields = 'Name, Primary Representative';
                break;
            case 'vendor_representative':
                $tbl = 'vendor_representative';
                $mandatory_fields = 'Name, Vendor';
                break;
            case 'product':
                $tbl = 'product_master';
                $mandatory_fields = 'Name, Vendor, Primary Representative';
                $extra_message = 'For more than one <strong>Primary Representative</strong>, put (pipe) <strong style="color:red;">|</strong> sign to differentiate them.<br/>';
                break;
            case 'potential':
                $tbl = 'potential_master';
                $mandatory_fields = 'Name, Account, Closing Date, Stage';
                break;
            case 'user':
                $tbl = 'user_master';
                break;
            default:
                break;
        }
        $data['mandatory_fields'] = $mandatory_fields;
        $data['extra_message'] = $extra_message;
        
        $this->session->set_userdata('imode', $getvar['cs']);
        $this->session->set_userdata('case', $tbl);
        $this->load->view('import_file',$data);
    }

    public function import_csv() {
        $this->load->library('csvreader');
        $postvar = $this->input->post();
        $id = $this->session->userdata('iUserId');
        $cmpid = $this->session->userdata('iCompanyId');

        $result = $customfield_arr = array();
        $File = $_FILES['file'];

        if ($File['name'] != '') {
            $this->load->library('upload');
            $target_path = $this->config->item('upload_path') . 'temp/' . $cmpid;
            $this->general->createfolder($target_path);
            $file_name = $cmpid . '_' . date('YmdHis') . '.csv';
            //$file_name = $id . '_' . $File['name'];
            $temp_folder_path = $target_path . '/' . $file_name;

            move_uploaded_file($File['tmp_name'], $temp_folder_path);


            $result = $this->csvreader->parse_file($temp_folder_path); //path to csv file
            //exit;
            $modifiedval = '';
            $cond = "`TABLE_SCHEMA`='yt' AND `TABLE_NAME`='" . $this->session->userdata('case') . "'";
            $schemadata = $this->model_support->getData('`INFORMATION_SCHEMA`.`COLUMNS`', 'COLUMN_NAME', array(), $cond);
            foreach ($schemadata as $key => $value) {

                if ($key == 0)
                    continue;
                else {
                    $pos = substr($value['COLUMN_NAME'], 0, 1);
                    if ($pos == 'd' || $pos == 'i') {
                        if ($pos == 'i') {
                            $pos = substr($value['COLUMN_NAME'], 0, 2);

                            if ($pos == 'is' || $pos == 'iM' || $pos == 'iU' || $value['COLUMN_NAME'] == 'iCompanyId')
                                continue;
                        }
                        if ($pos == 'd' && $value['COLUMN_NAME'] != 'dtDOB' && $value['COLUMN_NAME'] != 'dtClosingDate') {
                            continue;
                        }
                    }
                }

                if (strpos($value['COLUMN_NAME'], 'Id') !== false)
                    $value['COLUMN_NAME'] = str_replace('Id', '', $value['COLUMN_NAME']);

                $modifiedval = 'f-' . $value['COLUMN_NAME'];
                $customfield_arr[] = $modifiedval;
            }
//            pr($pos);exit; 
            $query = "Select * from fields_master";
            $customfield = $this->model_imports->query($query);
            foreach ($customfield as $key => $customfield_Value) {
                $ct_field = $customfield_Value['vField'];
                $ct_type = explode(',', $customfield_Value['eContactType']);
                foreach ($ct_type as $ctKey => $ctvalue) {
                    $customfield_arr[] = 'd-v' . $ct_field . $ctvalue;
                }
            }
        }

        $data['csv_file_name'] = $file_name;
        $data['csvData'] = $result;
        $data['contactfield_arr'] = $customfield_arr;
        $this->load->view('view_csv', $data);
    }

    public function import_file_action() {
        $this->load->library('csvreader');
        $id = $this->session->userdata('iCompanyId');

        $file_name = $this->input->get_post('csv_file_name');
        $field_name = $this->input->get_post('importselect');
        $csv_field_name = $this->input->get_post('csv_field_name');
        $duplicate = $this->input->get_post('duplicate');

        $case = $this->session->userdata('case');

        switch ($case) {
            case 'lead_master':
                $mandatory_fields = array('vCompany', 'vLastName');
                break;
            case 'account_master':
                $mandatory_fields = array('vName');
                break;
            case 'contact_master':
                $mandatory_fields = array('vLastName');
                break;
            case 'vendor_master':
                $mandatory_fields = array('vName', 'iPrimaryRepId');
                break;
            case 'vendor_representative':
                $mandatory_fields = array('vName', 'iVendorId');
                break;
            case 'product_master':
                $mandatory_fields = array('iVendorId', 'iPrimaryRepId', 'vName');
                break;
            case 'potential_master':
                $mandatory_fields = array('vName', 'iAccountId', 'dtClosingDate', 'iStageId');
                break;
            default:
                break;
        }

        /*  @ author : Ravi Patel
         * /* Combine field which used in mapping with csv field and db field.
         * @key = db field
         * @value = csv field
         */

        $combine_field = array_combine($field_name, $csv_field_name);

        $field_array = $result = $customfield_arr = array();

        // Make array for dynamic field based on mapping with csv column. 
        $i = 0;
        foreach ($field_name as $key => $value) {
            if (strstr($value, 'd-v')) {
                $cur_value = $this->general->addSpaceInString(str_replace('d-v', '', $value));
                $field_array_contact_key[$i] = $value;
                $field_array[$i] = substr($cur_value, 0, strrpos($cur_value, ' '));
                $field_contact_type_array[$i] = substr($cur_value, strrpos($cur_value, ' ') + 1);
                $i++;

                // Check email mapping for where clause.
                $pattern = '/^d-vEmail*/';
                $flag = preg_match($pattern, $value, $matches);

                if ($flag) {
                    $matches_mail[] = $combine_field[$value];
                }

//                // Check phone mapping for where clause.
//                $pattern = '/^d-vPhone*/';
//                $flag = preg_match($pattern, $value, $matches);
//
//                if ($flag) {
//                    $matches_phone[] = $combine_field[$value];
//                }
            }
        }
        // path to csv file
        $temp_folder_path = $this->config->item('upload_path') . 'temp/' . $id . '/' . $file_name;
        $result = $this->csvreader->parse_file($temp_folder_path);
        $cond = "`TABLE_SCHEMA`='yt' AND `TABLE_NAME`='" . $this->session->userdata('case') . "'";
        $schemadata = $this->model_support->getData('`INFORMATION_SCHEMA`.`COLUMNS`', 'COLUMN_NAME', array(), $cond);
        $totalcount = $successcount = $skipcount = 0;
        
        // insert value in contact book which also consists contact_book_field into another iteration of for loop
        foreach ($result as $result_key => $val) {
            if ((is_array($matches_mail) && count($matches_mail) > 0)) {
//             || (is_array($matches_phone) && count($matches_phone) > 0)
                $email = '';
//                $phone = '';

                foreach ($matches_mail as $matches_mail_value) {
                    if ($val[$matches_mail_value] != '')
                        $email .= (($email != '') ? '" , "' : '') . $val[$matches_mail_value];
                }
                $email = ($email != '') ? '("' . $email . '")' : '("")';

//                foreach ($matches_phone as $matches_phone_value) {
//                    if($val[$matches_phone_value] != '')
//                        $phone .= (($phone != '') ? '" , "' : '') . $val[$matches_phone_value];
//                }
//                $phone = ($phone != '') ? '("' . $phone . '")' : '("")';
//                $send_value = $this->model_support->checkEmail($email);
            }

            if ($send_value[0]['tot'] > 0 && strtolower($duplicate) == 'skip') {
                continue;
            }

            $totalcount++;
            //pr($schemadata);
            foreach ($schemadata as $keynew => $valuenew) {

                $pos = substr($valuenew['COLUMN_NAME'], 0, 1);
                if ($pos == 'd' || $pos == 'i') {

                    if ($pos == 'i') {
                        $pos = substr($valuenew['COLUMN_NAME'], 0, 2);
                        if ($pos != 'is' && $pos != 'iM' && $valuenew['COLUMN_NAME'] != 'iCompanyId' && $pos != 'iU' && $pos != 'iN' && $keynew > 0) {
                            $fieldval = $valuenew['COLUMN_NAME'];
                            if ($pos == 'iP' || $pos == 'iC' || $pos == 'iB' || $pos == 'iS') {
                                if ($valuenew['COLUMN_NAME'] == 'iPrimaryRepId' && $case == 'vendor_master') {
//                                    $tblname = 'vendor_representative';
//                                    $fieldval = 'iRepId';
                                    //$primaryRepArray[] = trim($val['Primary Representative']);
                                } else if ($valuenew['COLUMN_NAME'] == 'iCountryId' || $valuenew['COLUMN_NAME'] == 'iShippingCountryId' || $valuenew['COLUMN_NAME'] == 'iBillingCountryId') {
                                    $tblname = 'country';
                                    $fieldval = 'iCountryId';
                                } else {
                                    $tblname = substr($valuenew['COLUMN_NAME'], 1);
                                    $tblname = strtolower(str_replace('Id', '_master', $tblname));
                                }
                            } else {
                                $tblname = substr($valuenew['COLUMN_NAME'], 1);
                                $tblname = strtolower(str_replace('Id', '_master', $tblname));
                            }

                            if ($this->db->table_exists($tblname)) {
                                $fieldtempname = 'f-' . $valuenew['COLUMN_NAME'];
                                $fieldtempname = str_replace('Id', '', $fieldtempname);

//                                pr($combine_field[$fieldtempname]);
//                                if ($fieldtempname == $combine_field[$fieldtempname]) {
//                                pr($val);
//                                pr($combine_field);
//                                pr($fieldtempname);
                                $dataval = trim($val[$combine_field[$fieldtempname]]);

                                if ($valuenew['COLUMN_NAME'] == 'iCountryId' || $valuenew['COLUMN_NAME'] == 'iShippingCountryId' || $valuenew['COLUMN_NAME'] == 'iBillingCountryId')
                                    $extracond = 'vCountry = "' . $dataval . '"';
                                else if ($valuenew['COLUMN_NAME'] == 'iIndustryId')
                                    $extracond = 'vName = "' . $dataval . '"';
                                else if ($valuenew['COLUMN_NAME'] == 'iVendorId')
                                    $extracond = 'vName = "' . $dataval . '"';
                                else if ($valuenew['COLUMN_NAME'] == 'iAccountId' || $valuenew['COLUMN_NAME'] == 'iVendorId')
                                    $extracond = 'vName = "' . $dataval . '" AND iCompanyId = "' . $id . '"';
                                else if ($valuenew['COLUMN_NAME'] == 'iContactId') {
                                    $dataval1 = trim($val[$combine_field['f-iAccount']]);
                                    $accountcond1 = 'vName = "' . $dataval1 . '" AND iCompanyId = "' . $id . '"';
                                    $datauser1 = $this->model_support->getData('account_master', 'iAccountId', array(), $accountcond1);
                                    if ($dataval != "")
                                        $extracond = 'CONCAT(vSalutation," ",vFirstName," ",vMiddleName," ",vLastName) like "%' . $dataval . '%" AND iAccountId = "' . $datauser1[0]['iAccountId'] . '" AND iCompanyId = "' . $id . '"';
                                    else
                                        $extracond = 'vLastName = "' . $dataval . '" AND iAccountId = "' . $datauser1[0]['iAccountId'] . '" AND iCompanyId = "' . $id . '"';
                                } else
                                    $extracond = 'vName = "' . $dataval . '"';
                                $data['iUserId'] = $this->session->userdata('iUserId');
                                $data['iCompanyId'] = $id;
                                $data['iCreatedBy'] = $this->session->userdata('iUserId');
                                $data['iModifyBy'] = $this->session->userdata('iUserId');
                                $data['dtCreated'] = date('Y-m-d h:i:s');
                                $data['dtModify'] = date('Y-m-d h:i:s');

                                if ($case == 'vendor_master' && $valuenew['COLUMN_NAME'] == 'iPrimaryRepId') {
                                    $data['iPrimaryRepId'] = 0;
                                } else {
                                    $datauser = $this->model_support->getData($tblname, $fieldval, array(), $extracond);
                                }

                                //echo trim($datauser[0][$fieldval]);
                                $data[$valuenew['COLUMN_NAME']] = trim($datauser[0][$fieldval]);
//                                   pr($data);
//                                } else {
//                                    continue;
//                                }
                            } else {
                                continue;
                            }

//                            pr($combine_field);
//                            pr($fieldtempname);exit;
//                            $dataval = $val[$combine_field[$fieldtempname]];
////                                                        pr($dataval);exit;
//                            $extracond = 'vFirstName = "' . $dataval . '" OR vLastName = "' . $dataval . '" OR vNickName = "' . $dataval . '"';
//                            $datauser = $this->model_support->getData('user_master', 'iUserId', array(), $extracond);
//                            $data['iUserId'] = $datauser[0]['iUserId'];
//                            pr($datauser);exit;
                        } else {
                            continue;
                        }
                    } else if ($pos == 'd' && $valuenew['COLUMN_NAME'] == "dtDOB") {
                        //echo "mansi".$val[$combine_field[$fieldtempname]];
                        $fieldtempname = 'f-' . $valuenew['COLUMN_NAME'];
                        if ($val[$combine_field[$fieldtempname]] != "") {
                            $data[$valuenew['COLUMN_NAME']] = $val[$combine_field[$fieldtempname]];
                        } else {
                            $data['dtDOB'] = "0000-00-00";
                        }
                    } else if ($pos == 'd' && $valuenew['COLUMN_NAME'] == "dtClosingDate") {
                        $fieldtempname = 'f-' . $valuenew['COLUMN_NAME'];
                        $data[$valuenew['COLUMN_NAME']] = $val[$combine_field[$fieldtempname]];
                    } else {
                        continue;
                    }
                } else {
                    $fieldtempname = 'f-' . $valuenew['COLUMN_NAME'];
                    $data[$valuenew['COLUMN_NAME']] = $val[$combine_field[$fieldtempname]];

                    if ($valuenew['COLUMN_NAME'] == "eStatus" && $val[$combine_field[$fieldtempname]] == NULL) {
                        unset($data['eStatus']);
                    }
                }
            }
//            $data['vFirstName'] = ;
//            $data['vLastName'] = $val[$combine_field['f-vLastName']];
//            $data['vEmail'] = $val[$combine_field['f-vEmail']];
//            $data['vTitle'] = $val[$combine_field['f-vTitle']];
//            $data['vCompany'] = $val[$combine_field['f-vCompany']];
//            $data['vVendorStatus'] = $val[$combine_field['f-vVendorStatus']];
//            $data['vContactSource'] = $val[$combine_field['f-vContactSource']];
//            $data['vNote'] = $val[$combine_field['f-vNote']];
//            $data['vImportSource'] = 'csv';
//            exit;

            $skipflag = 0;

            foreach ($mandatory_fields as $mfield) {
                if (($case == 'vendor_master' || $case == 'product_master') && $mfield == 'iPrimaryRepId') {
                    if (trim($val['Primary Representative']) == "") {
                        $skipflag = 1;
                    }
                } else {
                    if ($data[$mfield] == "") {
                        $skipflag = 1;
                        break;
                    }
                }
            }

           // pr($data);

            if ($skipflag == 0) {
                $successcount++;
                $succ = $this->model_support->insert($this->session->userdata('case'), $data);
                if ($case == 'vendor_master') {
                    $repdata['vName'] = trim($val['Primary Representative']);
                    $repdata['iVendorId'] = $succ;
                    $repdata['iUserId'] = $this->session->userdata('iUserId');
                    $repdata['iCompanyId'] = $id;
                    $repdata['iCreatedBy'] = $this->session->userdata('iUserId');
                    $repdata['iModifyBy'] = $this->session->userdata('iUserId');
                    $repdata['dtCreated'] = date('Y-m-d h:i:s');
                    $repdata['dtModify'] = date('Y-m-d h:i:s');
                    $primaryRepId = $this->model_support->insert('vendor_representative', $repdata);
                    $vendorData['iPrimaryRepId'] = $primaryRepId;
                    $vendorCond = 'iVendorId = "' . $succ . '"';
                    $this->model_support->update($case, $vendorData, $vendorCond);
                }

                if ($case == 'product_master') {
                    $vendorId = $data['iVendorId'];
                    $repName = trim($val['Primary Representative']);
                    $repArray = explode("|", $repName);
                    foreach ($repArray as $rname) {
                        $rname = trim($rname);
                        if ($rname != "") {
                            $repCond = 'iVendorId = "' . $vendorId . '" AND vName = "' . $rname . '"';
                            $datarep = $this->model_support->getData('vendor_representative', 'iRepId', array(), $repCond);
                            $repId = $datarep[0]['iRepId'];
                            if ($repId == "") {
                                $repdata['vName'] = $rname;
                                $repdata['iVendorId'] = $vendorId;
                                $repdata['iUserId'] = $this->session->userdata('iUserId');
                                $repdata['iCompanyId'] = $id;
                                $repdata['iCreatedBy'] = $this->session->userdata('iUserId');
                                $repdata['iModifyBy'] = $this->session->userdata('iUserId');
                                $repdata['dtCreated'] = date('Y-m-d h:i:s');
                                $repdata['dtModify'] = date('Y-m-d h:i:s');
                                $primaryRepId = $this->model_support->insert('vendor_representative', $repdata);
                                $prrepdata['iProductId'] = $succ;
                                $prrepdata['iRepId'] = $primaryRepId;
                                $succ1 = $this->model_support->insert('product_representative_association', $prrepdata);
                                unset($prrepdata);
                            } else {
                                $prrepdata['iProductId'] = $succ;
                                $prrepdata['iRepId'] = $repId;
                                $succ1 = $this->model_support->insert('product_representative_association', $prrepdata);
                                unset($prrepdata);
                            }
                        }
                    }

                    //$repId = $datarep[0]['iRepId'];
                    //$succ = $this->model_support->insert($this->session->userdata('case'), $data);
//                    $repdata['vName'] = trim($val['Primary Representative']);
//                    $repdata['iVendorId'] = $succ;
//                    $repdata['iUserId'] = $this->session->userdata('iUserId');
//                    $repdata['iCompanyId'] = $id;
//                    $repdata['iCreatedBy'] = $this->session->userdata('iUserId');
//                    $repdata['iModifyBy'] = $this->session->userdata('iUserId');
//                    $repdata['dtCreated'] = date('Y-m-d h:i:s');
//                    $repdata['dtModify'] = date('Y-m-d h:i:s');
//                    $primaryRepId = $this->model_support->insert('vendor_representative', $repdata);
//                    $vendorData['iPrimaryRepId'] = $primaryRepId;
//                    $vendorCond = 'iVendorId = "' . $succ . '"';
//                    $this->model_support->update($case, $vendorData, $vendorCond);
                }
            } else {
                $skipcount++;
            }
//            pr($succ);exit;
//            exit;
//            if ($send_value[0]['tot'] > 0 && strtolower($duplicate) == 'update') {
//                $contactid = $send_value[0]['iContactId'];
//                $this->db->where('iContactId', $contactid);
//                $this->db->update('contact_book', $data);
//            } else {
//                $this->db->insert('contact_book', $data);
//                $contactid = $this->db->insert_id();
//            }

            foreach ($field_array as $fval) {
                $$fval = 1;
            }

            $find_field_key = '';

            //inserting contact_book_field another iteration of for loop as defined above

            if ($contactid > 0) {

                if ($send_value[0]['tot'] > 0 && strtolower($duplicate) == 'update') {
                    $contactid = $send_value[0]['iContactId'];
                    $this->db->where('iContactId', $contactid);
                    $this->db->delete('contact_book_fields');
                    foreach ($val as $fkey => $fvalue) {
                        if ($fvalue != '') {
                            // get key from combine_field array base on csv column name
                            $csv_column_map_key = array_search($fkey, $combine_field);
                            // get key from combine_field array base on csv column name
                            $find_field_key = array_search($csv_column_map_key, $field_array_contact_key);
                            if ($find_field_key > -1) {

//                                $this->model_support->insert_custom_field($contactid, $field_array[$find_field_key], $fvalue, $field_contact_type_array[$find_field_key], $$field_array[$find_field_key] ++);
                            }
                        }
                    }
                } else {
                    foreach ($val as $fkey => $fvalue) {
                        if ($fvalue != '') {
                            // get key from combine_field array base on csv column name
                            $csv_column_map_key = array_search($fkey, $combine_field);
                            // get key from combine_field array base on csv column name
                            $find_field_key = array_search($csv_column_map_key, $field_array_contact_key);
                            if ($find_field_key > -1) {
                                $this->model_support->insert_custom_field($contactid, $field_array[$find_field_key], $fvalue, $field_contact_type_array[$find_field_key], $$field_array[$find_field_key] ++);
                            }
                        }
                    }
                }
            }
        }
        $this->session->unset_userdata('imode');
        $this->session->unset_userdata('case');
//        pr($this->session->userdata('case'));exit;
        if ($skipflag == 0) {
            $message = "Total Records - " . $totalcount . "<br>Successfully Imported Records - " . $successcount;
            $this->session->set_flashdata("success", $message);
        } else {
            $message = "Total Records - " . $totalcount . "<br>Successfully Imported Records - " . $successcount . "<br>Skipped Records - " . $skipcount;
            $this->session->set_flashdata("failure", $message);
        }
        if ($case == 'vendor_representative')
            redirect('representatives');
        else
            redirect(str_replace('_master', 's', $case));
    }

    public function exportFile() {

        $getvar = $this->input->get();

        $companyId = $this->config->item('YT_USER_COMPANY_ID');
        $userId = $this->session->userdata('iUserId');

        switch ($getvar['c']) {
            case 'lead':
                $tbl = 'lead_master';
                break;
            case 'account':
                $tbl = 'account_master';
                break;
            case 'contact':
                $tbl = 'contact_master';
                break;
            case 'vendor':
                $tbl = 'vendor_master';
                break;
            case 'vendor_representative':
                $tbl = 'vendor_representative';
                break;
            case 'product':
                $tbl = 'product_master';
                break;
            case 'potential':
                $tbl = 'potential_master';
                break;
            case 'task':
                $tbl = 'task_master';
                break;
            case 'event':
                $tbl = 'event_master';
                break;
            case 'call':
                $tbl = 'call_master';
                break;
            case 'activities':
                $tbl = 'activities';
                break;
            case 'user':
                $tbl = 'user_master';
                break;
            case 'mealplan':
                $tbl = 'mealplan_master';
                break;
            case 'hotel':
                $tbl = 'hotel_master';
                break;
            case 'cab':
                $tbl = 'cab_master';
                break;
            case 'visa':
                $tbl = 'visa_master';
                break;
            default:
                break;
        }

        $file_path = $this->config->item('upload_path') . 'queries/' . $companyId . '/' . $userId . '/' . $tbl . '.text';
        $f = fopen($file_path, 'r');
        $qry = fread($f, filesize($file_path));
        fclose($f);
        $pos = strrpos($qry, "LIMIT");
        if ($pos !== false) {
            $query = substr($qry, 0, $pos);
        }

        $filename = 'export' . $getvar['c'] . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        $griddata = $this->general->griddata($tbl);

        $field_arr = array();
        $skip_arr = array();
        foreach ($griddata['colstitle'] as $key => $value) {
            if ($key < count($griddata['colstitle']) - 1 && $value['searchable'] == 1)
                $field_arr[] = $value['title'];
            else
                $skip_arr[] = $key;
        }
        fputcsv($output, $field_arr);
        //fetch from database
        /* $id = $this->session->userdata('iCompanyId');
          if ($tbl == 'task_master' || $tbl == 'event_master' || $tbl == 'call_master') {
          if ($getvar['type'] == 'Lead' || $getvar['typed'] == 'Contact') {
          if ($tbl == 'call_master') {
          $cond = ($tbl . '.iCallToId ="' . $getvar['typed'] . '" AND ' . $tbl . '.eCallTo = "' . ucfirst($getvar['type']) . '" and ' . $tbl . '.isDelete!=1');
          } else {
          $cond = ($tbl . '.iCallId ="' . $getvar['typed'] . '" AND ' . $tbl . '.eCallTo = "' . ucfirst($getvar['type']) . '" and ' . $tbl . '.isDelete!=1');
          }
          } else {
          $cond = ($tbl . '.iRelatedId ="' . $getvar['typed'] . '" AND ' . $tbl . '.eRelatedTo = "' . ucfirst($getvar['type']) . '" and ' . $tbl . '.isDelete!=1');
          }
          } else {
          $cond = $tbl . '.iCompanyId = "' . $id . '" and ' . $tbl . '.eStatus = "Active" and ' . $tbl . '.isDelete!=1';
          }
          $fields = implode(',', $griddata['colshead']);
          $results = $this->model_support->getExportData($tbl, $fields, $griddata['join'], $cond); */
        $results = $this->model_support->query($query);

        /*         * **
         * author Ravi Patel
         * 
         * ** */
        foreach ($results as $result) {
            $rowarr = array_values($result);
            foreach ($skip_arr as $ks => $vs) {
                if ($ks < count($skip_arr) - 1)
                    unset($rowarr[$vs]);
            }
            //populating values for given column names
            fputcsv($output, $rowarr);
        }
        exit;
    }

    public function exportPDf($fields = '') {
        require APPPATH . "third_party/mpdf/mpdf.php";

        $mpdf = new mPDF();

        $getvar = $this->input->get();

        $companyId = $this->config->item('YT_USER_COMPANY_ID');
        $userId = $this->session->userdata('iUserId');

        switch ($getvar['c']) {
            case 'lead':
                $tbl = 'lead_master';
                break;
            case 'account':
                $tbl = 'account_master';
                break;
            case 'contact':
                $tbl = 'contact_master';
                break;
            case 'vendor':
                $tbl = 'vendor_master';
                break;
            case 'vendor_representative':
                $tbl = 'vendor_representative';
                break;
            case 'product':
                $tbl = 'product_master';
                break;
            case 'potential':
                $tbl = 'potential_master';
                break;
            case 'task':
                $tbl = 'task_master';
                break;
            case 'event':
                $tbl = 'event_master';
                break;
            case 'call':
                $tbl = 'call_master';
                break;
            case 'activities':
                $tbl = 'activities';
                break;
            case 'user':
                $tbl = 'user_master';
                break;
            case 'mealplan':
                $tbl = 'mealplan_master';
                break;
            case 'hotel':
                $tbl = 'hotel_master';
                break;
            case 'cab':
                $tbl = 'cab_master';
                break;
            case 'visa':
                $tbl = 'visa_master';
                break;
            default:
                break;
        }

        $file_path = $this->config->item('upload_path') . 'queries/' . $companyId . '/' . $userId . '/' . $tbl . '.text';
        $f = fopen($file_path, 'r');
        $qry = fread($f, filesize($file_path));
        fclose($f);
        $pos = strrpos($qry, "LIMIT");
        if ($pos !== false) {
            $query = substr($qry, 0, $pos);
        }

        $griddata = $this->general->griddata($tbl);
        $field_arr = array();
        $skip_arr = array();
        $html = '
                <h3 align="center">Export ' . $getvar['c'] . '</h3>
                <table border="1" cellspacing="0" cellpadding="5"><tr>';
        foreach ($griddata['colstitle'] as $key => $value) {
            if ($key < count($griddata['colstitle']) - 1 && $value['searchable'] == 1) {
                $field_arr[] = $value['title'];
                $html .= "<th>" . $value['title'] . "</th>";
            } else
                $skip_arr[] = $key;
        }
        $html .= '</tr>';
        /*         * **
         * author Ravi Patel
         * 
         * ** */
        /* $id = $this->session->userdata('iCompanyId');
          if ($tbl == 'task_master' || $tbl == 'event_master' || $tbl == 'call_master') {
          if ($getvar['type'] == 'Lead' || $getvar['type'] == 'Contact') {
          if ($tbl == 'call_master') {
          $cond = ($tbl . '.iCallToId ="' . $getvar['typed'] . '" AND ' . $tbl . '.eCallTo = "' . ucfirst($getvar['type']) . '" and ' . $tbl . '.isDelete!=1');
          } else {
          $cond = ($tbl . '.iCallId ="' . $getvar['typed'] . '" AND ' . $tbl . '.eCallTo = "' . ucfirst($getvar['type']) . '" and ' . $tbl . '.isDelete!=1');
          }
          } else {
          $cond = ($tbl . '.iRelatedId ="' . $getvar['typed'] . '" AND ' . $tbl . '.eRelatedTo = "' . ucfirst($getvar['type']) . '" and ' . $tbl . '.isDelete!=1');
          }
          } else {
          $cond = $tbl . '.iCompanyId = "' . $id . '" and ' . $tbl . '.eStatus = "Active"';
          }

          $fields = implode(',', $griddata['colshead']);
          $results = $this->model_support->getExportData($tbl, $fields, $griddata['join'], $cond); */
        $results = $this->model_support->query($query);
        foreach ($results as $result) {
            $rowarr = array_values($result);
            foreach ($skip_arr as $ks => $vs) {
                if ($ks < count($skip_arr) - 1)
                    unset($rowarr[$vs]);
            }
            $html .= "<tr><td>" . implode('</td><td>', $rowarr) . "</td>";
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html = "<html><body>$html</body></html>";
        $mpdf->WriteHTML($html, 2);
        $filename = 'export' . $getvar['c'] . '.pdf';
        $mpdf->Output($filename, 'D');
        exit;
    }

    function download_sample_file() {
        $getvar = $this->input->get();
        $filename = $getvar['cs'];
        $file = $this->config->item('site_path') . 'public/upload/sample_files/' . $filename . '.csv';
        header('Content-Description: File Transfer');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Length: ' . filesize($file));
//        header('Content-Type: application/force-download');
        ob_clean();
        flush();
        readfile($file);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */