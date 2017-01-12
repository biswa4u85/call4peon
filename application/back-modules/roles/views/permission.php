<?php
include APPPATH . '/back-modules/views/header.php';
?>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>custom/permission.js"></script>
<div class="row">
              <div class="col-lg-12">
                <div class="box">
                 <form id="permission_form" action="<?php echo $this->config->item('admin_site_url'); ?>roles/permission_action" method="post" role="form" class="form-horizontal margin-none" autocomplete="off" >
                  <header>
                    <div class="icons"><i class="fa fa-edit"></i></div>
                    <?php
         $mode = (isset($dataArr['mode']) && $dataArr['mode'] == 'edit') ? "edit" : "add";
        if (!isset($dataArr[0]['iRoleId']) && $mode == "add")
            echo '<h5><a href="' . $this->config->item('admin_site_url') . 'roles_permissions">Roles & Permissions</a></h5><h5 class="active">New Role</h5>';
        ?>
        <?php
        if (isset($dataArr[0]['iRoleId']) && $mode == "edit")
            echo '<h5><a href="' . $this->config->item('admin_site_url') . 'roles_permissions">Roles List</a></h5><h5 class="active">Edit Role</h5>';
        ?>
                    <div class="toolbar">
                         <button type="submit" class="btn btn-success btn-xs" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                         <button type="submit" class="btn btn-info btn-xs" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                         <button class="btn btn-danger btn-xs" value="cancel" onclick="cancelAction();
        return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                           
                    </div>
                  </header>  
<div class="body">
    
    
    
<div>
    <ol class="breadcrumb">
<li><a href="<?php echo $this->config->item('admin_site_url'); ?>account">Account</a></li>
  
        <?php
         $mode = (isset($dataArr['mode']) && $dataArr['mode'] == 'edit') ? "edit" : "add";
        if (!isset($dataArr[0]['iRoleId']) && $mode == "add")
            echo '<li><a href="' . $this->config->item('admin_site_url') . 'roles_permissions">Roles & Permissions</a></li><li class="active">New Role</li>';
        ?>
        <?php
        if (isset($dataArr[0]['iRoleId']) && $mode == "edit")
            echo '<li><a href="' . $this->config->item('admin_site_url') . 'roles_permissions">Roles List</a></li><li class="active">Edit Role</li>';
        ?>
     
    </ol>
    <div class="col-md-6 text-right">
    </div>
</div>
<div class="common_whitebg">
    <div class="col-md-12"> 
    <!-- Form -->
    <form id="permission_form" action="<?php echo $this->config->item('admin_site_url'); ?>roles/permission_action" method="post" role="form" class="form-horizontal margin-none" autocomplete="off" >
        
        <div id="stickybutton" class="row sticky_div">
                <div class="col-md-12 text-center stick_btn">
                    <div class="Left-Head">
                        <h3>Role & Permissions</h3>
                    </div>
                    <div class="submit-Btn martop_10">
                        <p>  
                            <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-success" value="save" ><i class="fa fa-floppy-o"></i> Save</button> 
                            <button class="btn btn-danger" value="cancel" onclick="cancelAction();
                                    return false;"><i class="fa fa-times"></i> Cancel</button>
                        </p>
                    </div>
                </div>                
            </div>
       
        <input type="hidden" class="form-control" id="iRoleId" name="iRoleId" value="<?php echo $dataArr[0]['iRoleId']; ?>"/>
        <input type="hidden" class="form-control" id="mode" name="mode" value="<?php echo $mode; ?>"/>
      
        
          <div class="row">
                <div class="col-md-12">
                    <div class="form-box-main">
                        <h4 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-user-secret"></i>Roles & Permissions<i class="fa fa-chevron-down pull-right text-grey"></i>
                        </h4>
                        <div class="form-inner collapse in" id="modinfo">
                            <div class="form-group">
                                <label for="vRole" class="col-sm-3 control-label"><span class="require">*</span>Role Name:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="vRole" name="vRole" placeholder="" value="<?php echo $dataArr[0]['vRole']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="vRoleCode" class="col-sm-3 control-label"><span class="require">*</span>Role Code:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="vRoleCode" name="vRoleCode" placeholder="" value="<?php echo $dataArr[0]['vRoleCode']; ?>" <?php echo ($mode == 'edit') ? 'readonly=readonly' : ''; ?> >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="vRoleCode" class="col-sm-3 control-label">Role Code:</label>
                                <div class="col-sm-4">
                                    <input type="radio" id="eStatus" name="eStatus" value="Active" <?php
                                        if ($dataArr[0]['eStatus'] == 'Active' || $dataArr[0]['eStatus'] == '') {
                                            echo "checked='true'";
                                        }
                                        ?>> Active
                                    <input type="radio" id="eStatus" name="eStatus" value="Inactive" <?php
                                        if ($dataArr[0]['eStatus'] == 'Inactive') {
                                            echo "checked='true'";
                                        }
                                        ?>> Inactive
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="eRoleType" class="col-sm-3 control-label">Role Type:</label>
                                <div class="col-sm-4">
                                    <?php $eRoleType = explode(',',$dataArr[0]['eRoleType']);
                                    //echo $eRoleType[1];
                                    
                                    ?>
                                    <input type="checkbox" id="eRoleType" name="eRoleType[]" value="Back"<?php
                                        if ($eRoleType[1] == 'Back') {
                                            echo "checked='true'";
                                        }
                                        ?>> Back
                                    <input type="checkbox" id="eRoleType" name="eRoleType[]" value="Front"<?php
                                        if ($eRoleType[0] == 'Front') {
                                            echo "checked='true'";
                                        }
                                        ?>> Front
                                </div>
                            </div>
                        </div>
                    </div>
                     </div>
               
            </div>
                   <!--  ############# module listing ###############-->
                   
                        <table class="table table-bordered table-striped cf">
                            <thead>                                
                                <tr>
                                    <th> # </th>                                
                                    <th> Modules</th>
                                    <th style="text-align:center"><input type="checkbox" id="chAllIsRead" name="chAllIsRead"> Read</th>                                
                                    <th style="text-align:center"><input type="checkbox" id="chAllIsWrite" name="chAllIsWrite"> Write</th>                                
                                    <th style="text-align:center"><input type="checkbox" id="chAllIsDelete" name="chAllIsDelete"> Delete</th>                                                  
                                </tr>                            
                            </thead>
                            <tbody>                               
                                <?php $j = 0; ?>
                                <?php for ($i = 0; $i < count($moduleList); $i++) { 
                                    /*$j = $j+1;
                                    if($moduleList[$i]['parent_name'].' List' == $moduleList[$i]['vModule']){
                                        $j = $j-1;
                                        continue;
                                    } */
                                    
                                    if ($mode == 'edit') {
                                        $getRow = $this->model_permission->getPermissionRow($dataArr[0]['iRoleId'], $moduleList[$i]['iModuleId']);
                                    }
                                    ?>
                                    <tr>
                                <input type="hidden" name="moduleArray[]" value="<?= $moduleList[$i]['iModuleId'] ?>"/>
                                <td><?php echo $i+1; ?></td>
                                <td><a href="javascript:void(0)"><?php echo $moduleList[$i]['vModule']; ?></a></td>


                                <td align="center"><input type="checkbox" id="chisRead[<?= $moduleList[$i]['iModuleId'] ?>]" name="chisRead[<?= $moduleList[$i]['iModuleId'] ?>]" class="chkallread" <?php
                                    if ($getRow[0][isRead] == '1') {
                                        echo 'checked = "checked"';
                                    }
                                    ?>> </td>
                                <td align="center"><input type="checkbox" id="chisWrite[<?= $moduleList[$i]['iModuleId'] ?>]" name="chisWrite[<?= $moduleList[$i]['iModuleId'] ?>]" class="chkallwrite" <?php
                                    if ($getRow[0][isWrite] == '1') {
                                        echo 'checked = "checked"';
                                    }
                                    ?>></td>
                                <td align="center"><input type="checkbox" id="chisDelete[<?= $moduleList[$i]['iModuleId'] ?>]" name="chisDelete[<?= $moduleList[$i]['iModuleId'] ?>]" class="chkalldelete" <?php
                                    if ($getRow[0][isDelete] == '1') {
                                        echo 'checked = "checked"';
                                    }
                                    ?>>		</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                        <!--  ############# module listing ###############-->
    </form>
</div>
</div>
<?php if ($dataArr[0]['iRoleId'] == '1') { ?>
    <script>
        $("#permission_form input, #permission_form select, #btn_submit").attr('disabled', true);
    </script>
<?php } 
?>
    <!--<script>$("#iRoleId, #mode").removeAttr('disabled');</script>-->
<?php include APPPATH . '/back-modules/views/footer.php'; ?> 

    
    
    
    
