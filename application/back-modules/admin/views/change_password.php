<?php include APPPATH . '/back-modules/views/header.php'; ?>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>custom/my_account.js"></script>

<div>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->config->item('admin_site_url'); ?>account">Account</a></li>
        <li class="active">Change Password</li>
    </ol>
    <div class="col-md-6 text-right">
    </div>
</div>

<div class="common_whitebg">
    <div class="col-md-12">
        <form class="form-horizontal" id="password-form" action="<?php echo $this->config->item('site_url'); ?>admin/change_password_action" method="post">

            <div id="stickybutton" class="row sticky_div">
                <div class="col-md-12 text-center stick_btn">
                    <div class="Left-Head">
                        <h3>Change Password</h3>
                    </div>
                    <div class="submit-Btn martop_10">
                        <p>  
                            <button class="btn btn-success" value="save"><i class="fa fa-floppy-o"></i> Save</button>
                            <button class="btn btn-danger" value="cancel" onclick="cancelAction();
                                    return false;"><i class="fa fa-times"></i> Cancel</button>
                        </p>
                    </div>
                </div>                
            </div>

            <input type="hidden" id="iAdminId" name="iAdminId" <?php
            if (isset($admin_id)) {
                echo "value='" . $admin_id . "'";
            } else {
                echo "disabled";
            }
            ?>>
            <!-- Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-box-main mar-top">
                        <h4 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-unlock-alt"></i>Password Information<i class="fa fa-chevron-down pull-right text-grey"></i></h4>
                        <div class="collapse in" id="modinfo">
                            <div class="row">
                                <div class="col-md-6 mar-top">
                                    <div class="form-group">
                                        <label for="inputPasswordOld" class="col-sm-4 control-label"><span class="require">*</span>Old password:</label>
                                        <div class="col-sm-8">
                                            <input type="password" id="voldPassword" name="voldPassword" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNew" class="col-sm-4 control-label"><span class="require">*</span>New password:</label>
                                        <div class="col-sm-8">
                                            <input type="password" id="vPassword" name="vPassword" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordNew2" class="col-sm-4 control-label"><span class="require">*</span>Repeat new password:</label>
                                        <div class="col-sm-8">
                                            <input type="password" id="vPassword2" name="vPassword2" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <!-- // Column END -->
                            </div>
                        </div></div></div></div>

        </form>
    </div>
</div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>