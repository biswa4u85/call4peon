<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->general->checkSession('', 'back');
        $this->load->model('model_roles');
    }

    public function index() {
        $data['sublist'] = "roleslist";
//        $data['sublist'] = "notreq";
        $this->load->view('roles', $data);
    }

    public function chnge_permit() {
        $this->load->model('model_admin');
        $fields = "*";
        $ext_cond = 'iAdminId = ' . $this->session->userdata('iAdminId');
        $rply = $this->model_admin->getData($fields, array(), $ext_cond);
        $data['all'] = $rply;
        $this->load->view('chnge_permit', $data);
        // $this->template->build('user_mgmt');
    }

    public function roles_main() {
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        if ($postvar['type'] != 'ajax') {
            $this->general->check_permission('list', 'roles');
        }
        if ($getvar['id'] != '' && $getvar['m'] != '') {
            //delete
            $mode = (isset($getvar['m']) && $getvar['m'] != '') ? $this->general->decryptData($getvar['m']) : '';
            if ($mode == 'delete') {
                $iLeadId = (isset($getvar['id']) && $getvar['id'] != '') ? $this->general->decryptData($getvar['id']) : '';
                $resurl = basename($this->uri->uri_string);
                if ($getvar['call'] == 'ajax') {
                    $res = 1;
                } else {
                    $res = $this->general->check_permission('del', $resurl, 'ajax');
                }
                if ($res == 1) {
                    $id = urldecode($this->general->decryptData($getvar['id']));
                    $this->model_roles->delete($id);
                    $this->session->set_flashdata("success", "Data deleted successfully");
                    redirect('roles_permissions');
                }
            }
        }

        $this->load->model('model_roles');
        $fields = "*";
        $ext_cond = '';
        $rply = $this->model_roles->getData($fields, array(), $ext_cond);
        $data['dataArr'] = $rply;
//        $data['sublist'] = "roleslist";
        $data['sublist'] = "notreq";
        $this->load->view('roles', $data);
    }

    public function role_delete() {
        $this->load->model('model_roles');
        $getvar = $this->input->get();
        $id = urldecode($this->general->decryptData($getvar['id']));
        $where = "iRoleId = $id";
        $rply = $this->model_roles->delete($where);
        redirect('roles');
        exit;
    }

    public function permission() {
        $this->load->model('model_permission');
        $getvar = $this->input->get();
        $postvar = $this->input->post();
        if ($postvar['type'] != 'ajax') {
            $editpermission = $this->general->check_permission('form', 'role_add', 'ajax');
            if ($editpermission == 0) {
                redirect('forbidden');
            }
        }
        $id = urldecode($this->general->decryptData($getvar['id']));
        $mode = urldecode($this->general->decryptData($getvar['m']));
        if ($getvar != '' && $mode == 'edit') {
            $data['dataArr'] = $this->model_permission->getRole($id);
            $data['dataArr']['mode'] = 'edit';
        }
        $data['moduleList'] = $this->model_permission->moduleList();
        $this->load->view('permission', $data);
    }

    public function permission_action() {
        $this->load->model('model_permission');
        $this->load->model('model_roles');

        $postdata = $this->input->post();

        $postvar = $this->general->strip_get_post($postdata);

        $role['vRole'] = $postvar['vRole'];
        $role['vRoleCode'] = $postvar['vRoleCode'];
        $role['eRoleType'] = implode(',',$postvar['eRoleType']);
        $role['eStatus'] = $postvar['eStatus'];
        if ($postvar['mode'] == 'edit') {
            $roleId = $postvar['iRoleId'];
            $this->model_permission->updateRow('role_master', $role, "iRoleId=" . $roleId);
            for ($i = 0; $i < count($postvar['moduleArray']); $i++) {
                $existsModule = $this->model_permission->getPermissionRow($postvar['iRoleId'], $postvar['moduleArray'][$i]);
                $mmId = $postvar['moduleArray'][$i];
                if (!isset($postvar['chisRead'][$mmId]) && $postvar['chisRead'][$mmId] == false) {
                    $read = '0';
                } else {
                    $read = '1';
                }
                if (!isset($postvar['chisWrite'][$mmId]) && $postvar['chisWrite'][$mmId] == false) {
                    $write = '0';
                } else {
                    $write = '1';
                }
                if (!isset($postvar['chisDelete'][$mmId]) && $postvar['chisDelete'][$mmId] == false) {
                    $delete = '0';
                } else {
                    $delete = '1';
                }

                if (count($existsModule) > 0) {
                    $this->model_permission->updatePermissionRow($roleId, $postvar['moduleArray'][$i], $read, $write, $delete);
                } else {
                    $this->model_permission->insertPermissionRow($roleId, $postvar['moduleArray'][$i], $read, $write, $delete);
                }


                //######################## insert sub module code ######################## //

                $subModules = $this->model_permission->getSubModules($mmId);

                for ($j = 0; $j < count($subModules); $j++) {

                    $checkPremission = $this->model_permission->checkModulePermission($roleId, $subModules[$j]['iModuleId']);
                    if ($checkPremission != 1) {
                        $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], 0, 0, 0);
                    }

                    //  if (!in_array($subModules[$j]['iModuleId'], $moduleArray) ) {
                    $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], 0, 0, 0);
                    if ($write == 1) {
                        $module = substr($subModules[$j]['parent_name'], 0, strlen($subModules[$j]['parent_name']));
//                        pr($subModules[$j]['vModule'],1);
                        if ($subModules[$j]['vModule'] == 'Create ' . $module) {
                            $read1 = 1;
                            $delete1 = 0;
                            $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read1, $write, $delete1);
                        }
                    }
                    if ($read == 1) {
                        if ($subModules[$j]['parent_name'] . ' List' == $subModules[$j]['vModule']) {
                            $read = 1;
                            $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                        }
                        //  }
                        //   $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read,$write, $delete);
                    }
                }

                /*
                  for ($j = 0; $j < count($subModules); $j++) {
                  $checkPremission = $this->model_permission->checkModulePermission($roleId, $subModules[$j]['iModuleId']);
                  if ($checkPremission == true) {
                  $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  } else {
                  if ($read == 1 || $delete == 1) {
                  if ($subModules[$j]['parent_name'] . ' List' == $subModules[$j]['vModule']) {
                  $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  }
                  }

                  if ($write == 1) {
                  $module = substr($subModules[$j]['parent_name'], 0, strlen($subModules[$j]['parent_name']) - 1);
                  if ($subModules[$j]['vModule'] == 'Create ' . $module) {
                  if ($checkPremission == true) {
                  $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  } else {
                  $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  }
                  }
                  }
                  }
                  } */
                //######################## insert sub module code ######################## //

                /*    if ($read == 1 || $delete == 1) {
                  if ($subModules[$j]['parent_name'] . ' List' == $subModules[$j]['vModule']) {

                  if ($checkPremission == true) {
                  $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  } else {
                  $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  }
                  }
                  }
                  if ($write == 1) {

                  $module = substr($subModules[$j]['parent_name'], 0, strlen($subModules[$j]['parent_name']) - 1);

                  if ($subModules[$j]['vModule'] == 'Create ' . $module) {
                  if ($checkPremission == true) {
                  $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  } else {
                  $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  }
                  }
                  } */
            }
        } else {
            //insert
            $role['iCreatedBy'] = $this->session->userdata('iUserId');
            $role['dtCreated'] = date('Y-m-d H:i:s');

            $roleId = $this->model_roles->insert($role);
            $this->model_permission->insertDashboardPermissionRow($roleId);
            for ($i = 0; $i < count($postvar['moduleArray']); $i++) {
                $mmId = $postvar['moduleArray'][$i];
                // echo $mmId . "<br/>";
                $subModules = $this->model_permission->getSubModules($mmId);
                if (!isset($postvar['chisRead'][$mmId]) && $postvar['chisRead'][$mmId] == false) {
                    $read = '0';
                } else {
                    $read = '1';
                }
                if (!isset($postvar['chisWrite'][$mmId]) && $postvar['chisWrite'][$mmId] == false) {
                    $write = '0';
                } else {
                    $write = '1';
                }
                if (!isset($postvar['chisDelete'][$mmId]) && $postvar['chisDelete'][$mmId] == false) {
                    $delete = '0';
                } else {
                    $delete = '1';
                }

                $this->model_permission->insertPermissionRow($roleId, $postvar['moduleArray'][$i], $read, $write, $delete);

                $this->model_permission->updatePermissionRow($roleId, $postvar['moduleArray'][$i], $read, $write, $delete);

                for ($j = 0; $j < count($subModules); $j++) {
                    //  if (!in_array($subModules[$j]['iModuleId'], $moduleArray) ) {
                    $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], 0, 0, 0);
                    if ($write == 1) {
                        $module = substr($subModules[$j]['parent_name'], 0, strlen($subModules[$j]['parent_name']) - 1);
                        if ($subModules[$j]['vModule'] == 'Create ' . $module || $subModules[$j]['vModule'] == 'Pending Invoice') {
                            $read1 = 1;
                            $delete1 = 0;
                            $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read1, $write, $delete1);
                        }
                    }
                    if ($read == 1) {
                        if ($subModules[$j]['parent_name'] . ' List' == $subModules[$j]['vModule'] || $subModules[$j]['vModule'] == 'Pending Invoice') {
                            $read = 1;
                            $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                        }
                    }
                    //   }
                }

                /*   if ($read == 1 || $delete == 1) {
                  if ($subModules[$j]['parent_name'] . ' List' == $subModules[$j]['vModule']) {

                  $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  }
                  }
                  if ($write == 1) {
                  $checkPremission = $this->model_permission->checkModulePermission($roleId, $subModules[$j]['iModuleId']);
                  $module = substr($subModules[$j]['parent_name'], 0, strlen($subModules[$j]['parent_name']) - 1);

                  if ($subModules[$j]['vModule'] == 'Create ' . $module) {
                  if ($checkPremission == true) {
                  $this->model_permission->updatePermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  } else {
                  $this->model_permission->insertPermissionRow($roleId, $subModules[$j]['iModuleId'], $read, $write, $delete);
                  }
                  }
                  } */
            }
        }
        redirect('roles_permissions');
    }

    function checkRoles() {
        $this->load->model('model_permission');
        $postvar = $this->input->post();
        $getvar = $this->input->get();

        $ext_cond = '';
        if (isset($getvar['id']) && $getvar['id'] != '') {
            $ext_cond = "iRoleId <> '" . $getvar['id'] . "'";
        }
        echo $this->model_permission->checkDuplicate('role_master', 'vRoleCode', $postvar['vRoleCode'], $ext_cond);
        exit;
    }

}

/* End of file welcome.php */
                    /* Location: ./application/controllers/welcome.php */
                    