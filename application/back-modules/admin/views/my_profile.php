<?php // echo $this->config->item('admin_url') . 'admin/my_profile_action';exit;?>
<?php include APPPATH . '/back-modules/views/header.php'; ?>
<div class="common_whitebg">
    <div class="col-md-12"> 
        <form class="form-horizontal formclass" id="adminForm" name="adminForm" method="POST" action="<?php echo $this->config->item('admin_url') . 'admin/'; ?>my_profile_action" enctype="multipart/form-data" data-permit=true onsubmit="return false">

            <div id="stickybutton" class="row sticky_div">
                <div class="col-md-12 text-center stick_btn">
                    <div class="Left-Head">
                        <h3>My Profile </h3>
                    </div>
                    <div class="submit-Btn martop_10">
                        <p>  
                            <button type="submit" class="btn btn-success" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>  
                        </p>
                    </div>
                </div>                
            </div>
            <input type="hidden" id="admin_id" name="admin_id" <?php
            if (isset($admin_id)) {
                echo "value='" . $this->general->encryptData($admin_id) . "'";
            }
            ?>>
            <input type="hidden" id="mode" name="mode" <?php
            echo "value='" . $mode . "'";
            ?>>
            <div id="sortable">
                <div class="row">
                    <div class="col-md-12 handle">
                        <div class="form-box-main">
                            <!--<h4 data-toggle="" >Admin Information </h4>-->
                            <div class="collapse in" id="modinfo">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-inner">
                                            <div class="form-group">
                                                <label for="first_name" class="col-sm-2 control-label">Name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control " id="first_name" name="first_name" placeholder=""<?php
                                                    if (isset($admin_id)) {
                                                        echo "value='" . $all[0]['vName'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">Email:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control " id="email" name="email" placeholder=""<?php
                                                    if (isset($admin_id)) {
                                                        echo "value='" . $all[0]['vEmail'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                            </div>
                                            <div class="form-group" <?= (!isset($admin_id)) ? 'style="display:none"' : '' ?>>
                                                <label class="col-sm-2 control-label"></label>
                                                <div class="col-sm-8">
                                                    <button type="button" class="btn btn-info hideonchange" value="" id="changepass" name="changepass" title="Change password"><i class="fa fa-key"></i></button> 
                                                    <button type="button" class="btn btn-info" value="" id="cancelbtn" name="cancelbtn"  style="display:none"><i class="fa fa-times"></i></button> 
                                                </div>
                                            </div>
                                            <div class="changepassdiv" <?= (isset($admin_id) && $admin_id != '' ) ? 'style="display:none"' : '' ?>>

                                                <div class="form-group">
                                                    <label for="old_password" class="col-sm-2 control-label">Old Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control " id="old_password" name="old_password" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="col-sm-2 control-label">Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control " id="password" name="password" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password2" class="col-sm-2 control-label">Confirm Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control " id="password2" name="password2" placeholder="">
                                                    </div>
                                                </div>
                                            </div>    


                                            <div class="form-group">
                                                <label for="profile_image" class="col-sm-2 control-label">Profile Image:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control " id="profile_image" name="profile_image" class="changeimage" <?= (isset($all[0]['vProfileImage']) && $all[0]['vProfileImage'] != '' ) ? 'style="display:none"' : 'style="display:block"' ?> accept="image/*">
                                                    <img src="<?= ($all[0]['vImage'] != '') ? $this->config->item('upload_url') . 'admin/' . $admin_id . '/' . $all[0]['vImage'] : '' ?>" <?= (isset($all[0]['vImage']) && $all[0]['vImage'] != '' ) ? 'style="display:block"' : 'style="display:none"' ?> height="100" class="imgclass"/>
                                                </div>
                                            </div>

                                            <div class="form-group" <?= (isset($admin_id) && isset($all[0]['vImage']) && $all[0]['vImage'] != '') ? 'style="display:block"' : 'style="display:none"' ?>>
                                                <label for="" class="col-sm-2 control-label"></label>
                                                <div class="col-sm-8">
                                                    <button type="button" class="btn btn-success hideonchange" value="" id="changeimage" name="changeimage" ><i class="fa fa-repeat"></i></button>
                                                    <button type="button" id="Deleteimg" title="Delete" class="btn btn-danger" onclick="deleteimg()"><i class="fa fa-trash-o"></i></button>
                                                    <button type="button" class="btn btn-info" value="" id="cancelimgbtn" name="cancelimgbtn"  style="display:none"><i class="fa fa-times"></i></button> 
                                                </div>
                                            </div>
                                            <!--                                            <div class="form-group">
                                                                                            <label for="first_name" class="col-sm-2 control-label">Address1:</label>
                                                                                            <div class="col-sm-8">
                                                                                                <textarea class="form-control" id="vAddress1" name="vAddress1"><?php
                                            if (isset($admin_id)) {
                                                echo $all[0]['vAddress1'];
                                            }
                                            ?></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="first_name" class="col-sm-2 control-label">Address2:</label>
                                                                                            <div class="col-sm-8">
                                                                                                <textarea class="form-control" id="vAddress2" name="vAddress2"><?php
                                            if (isset($admin_id)) {
                                                echo $all[0]['vAddress2'];
                                            }
                                            ?></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="status" class="col-sm-2 control-label">Country:</label>
                                                                                            <div class="col-sm-8">
                                                                                                <select class="form-control" name="vCountry" id="vCountry">
                                                                                                    <option value="India" selected>India</option>
                                                                                                    <option value="Other">Other</option>
                                                                                                </select>          
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="first_name" class="col-sm-2 control-label">State:</label>
                                                                                            <div class="col-sm-8">
                                                                                                <input type="text" class="form-control " id="vState" name="vState" placeholder=""<?php
                                            if (isset($admin_id)) {
                                                echo "value='" . $all[0]['vState'] . "'";
                                            }
                                            ?>>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="first_name" class="col-sm-2 control-label">vCity:</label>
                                                                                            <div class="col-sm-8">
                                                                                                <input type="text" class="form-control " id="vCity" name="vCity" placeholder=""<?php
                                            if (isset($admin_id)) {
                                                echo "value='" . $all[0]['vCity'] . "'";
                                            }
                                            ?>>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="first_name" class="col-sm-2 control-label">vZipcode:</label>
                                                                                            <div class="col-sm-8">
                                                                                                <input type="text" class="form-control " id="vZipcode" name="vZipcode" placeholder=""<?php
                                            if (isset($admin_id)) {
                                                echo "value='" . $all[0]['vZipcode'] . "'";
                                            }
                                            ?>>
                                                                                            </div>
                                                                                        </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>
<script src="<?= $this->config->item('js_url') ?>admin/admin.js"></script>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>