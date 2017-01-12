<?php include APPPATH . '/back-modules/views/header.php'; ?>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/css/select2.css"/>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/js/select2.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/admin.js"></script>
<div class="row">
              <div class="col-lg-12">
                <div class="box">
                 <form class="form-horizontal formclass" id="AdminForm" name="AdminForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>admin/admin_action">
                  <header>
                    <div class="icons"><i class="fa fa-edit"></i></div>
                    <h5><?php echo (!isset($all[0]['iAdminId']) && $mode == "add") ? 'Add Admin' : ucfirst($mode) . ' Admin'; ?></h5>
                    <div class="toolbar">
                         <button type="submit" class="btn btn-success btn-xs" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                         <button type="submit" class="btn btn-info btn-xs" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                         <button class="btn btn-danger btn-xs" value="cancel" onclick="cancelAction();
        return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                           
                    </div>
                  </header>
                    
                    
<div class="body">
<?php if (isset($all[0]['iAdminId'])) { ?>
                <input type="hidden" id="chnagepassval" name="chnagepassval" value="">
            <?php } ?>
            <input type="hidden" id="iAdminId" name="iAdminId" <?php
            if (isset($all[0]['iAdminId'])) {
                echo "value='" . $all[0]['iAdminId'] . "'";
            }
            ?>>
            <input type="hidden" id="mode" name="mode" <?php
            echo "value='" . $mode . "'";
            ?>>

            <?php
            if (isset($iAdminId) && isset($frompage) && $frompage == "view") {
                echo '<input type="hidden" id="frompage" name="frompage" value="' . $frompage . '"  >';
            }
            ?>

            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <div class="form-group">
                                                <label for="vName" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="vName" name="vName" placeholder=""<?php
                                                    if (isset($all[0]['iAdminId'])) {
                                                        echo "value='" . $all[0]['vName'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="vNameErr" class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="iRoleId" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Role:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="iRoleId" name="iRoleId" <?php echo ($mode != "add" && ($this->session->userdata('iAdminId')==$all[0]['iAdminId'] || $this->session->userdata('iRoleId')!=1)?'disabled':'')?>>
                                                        <?php
                                                        foreach ($role as $rolek => $rolev) {
                                                            echo '<option value="' . $rolev['iRoleId'] . '" ' . ($rolev['iRoleId'] == $all[0]['iRoleId'] ? 'Selected' : '') . ' >' . $rolev['vRole'] . '</option>';
                                                        }
                                                        ?>    
                                                    </select>
                                                </div>                                                    
                                            </div>
                                            <div class="form-group">
                                                <label for="eStatus" class="col-sm-4 control-label">Status:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="eStatus" name="eStatus" <?php echo ($mode != "add" && ($this->session->userdata('iAdminId')==$all[0]['iAdminId'] || $this->session->userdata('iRoleId')!=1)?'disabled':'')?>>
                                                        <option value="Active" selected="selected">Active</option>    
                                                        <option value="Inactive">Inactive</option>    
                                                    </select>
                                                </div>                                                    
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <div class="form-group">
                                                <label for="vEmail" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Email:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="vEmail" name="vEmail" placeholder=""<?php
                                                    if (isset($all[0]['iAdminId'])) {
                                                        echo "value='" . $all[0]['vEmail'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="vEmailErr" class="help-block"></span>
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="vUserName" class="col-sm-4 control-label"><sup class="text-danger">*</sup>UserName:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="vUserName" name="vUserName" placeholder=""<?php
                                                    if (isset($all[0]['iAdminId'])) {
                                                        echo "value='" . $all[0]['vUserName'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="vUserNameeErr" class="help-block"></span>
                                            </div>
                                            <div id="changpassbtndiv">
                                                <div class="form-group">    
                                                    <label for="vUserName" class="col-sm-4 control-label"></label>
                                                    <div class="col-sm-8">
                                                        <button type="button" class="btn btn-sm btn-success" id="changpassbtn" name="changpassbtn"><i class="fa fa-floppy-o"></i> Change Password</button>
                                                        <button type="button" class="btn btn-sm btn-success" id="cancelpassbtn" name="cancelpassbtn"><i class="fa fa-floppy-o"></i> Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="passdiv">
                                                <div class="form-group">
                                                    <label for="vPassword" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control requiredview" id="vPassword" name="vPassword" placeholder="">
                                                    </div>
                                                    <span id="vPasswordErr" class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="vPassword2" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Conform Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control requiredview" id="vPassword2" name="vPassword2" placeholder="">
                                                    </div>
                                                    <span id="vPasswordErr" class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
    
</div>
                 </form>
                </div>
                  </div>
    </div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>