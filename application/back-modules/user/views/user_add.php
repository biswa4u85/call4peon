<?php include APPPATH . '/back-modules/views/header.php'; ?>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/css/select2.css"/>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/js/select2.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/user.js"></script>
<div class="row">
              <div class="col-lg-12">
                <div class="box">
                 <form class="form-horizontal formclass" id="userForm" name="userForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>user/user_add_action" enctype="multipart/form-data">
                  <header>
                    <div class="icons"><i class="fa fa-edit"></i></div>
                    <h5><?php echo (!isset($all[0]['iTransporterId']) && $mode != "edit") ? 'Create Peons' : ucfirst($mode) . ' Peons'; ?></h5>
                    <div class="toolbar">
                         <button type="submit" class="btn btn-success btn-xs" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                         <button type="submit" class="btn btn-info btn-xs" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                         <button class="btn btn-danger btn-xs" value="cancel" onclick="cancelAction();
        return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                           
                    </div>
                  </header>  
<div class="body">
    <input type="hidden" id="iUserId" name="iUserId" <?php
            if (isset($all[0]['iUserId'])) {
                echo "value='" . $all[0]['iUserId'] . "'";
            }
            ?>>
            <input type="hidden" id="mode" name="mode" <?php
            echo "value='" . $mode . "'";
            ?>>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
                    <div class="col-md-12 handle">
                        <div class="box ui-sortable-handle" style="position: relative;">
                            <header>
                            <h5 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Transporter Information <i class="fa fa-chevron-down pull-right text-grey"> </i>
                            </h5>
                            </header>
                            <div class="body collapse in" id="modinfo">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-inner">
                                            <div class="form-group">
                                                <label for="firstName" class="col-sm-4 control-label"><sup class="text-danger">*</sup>First Name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="firstName" name="firstName" placeholder=""<?php
                                                    if (isset($all[0]['vFirstName'])) {
                                                        echo "value='" . $all[0]['vFirstName'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="firstNameErr" class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastName" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Last Name:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="lastName" name="lastName" placeholder=""<?php
                                                    if (isset($all[0]['vLastName'])) {
                                                        echo "value='" . $all[0]['vLastName'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="lastNameErr" class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Email:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="email" name="email" placeholder=""<?php
                                                    if (isset($all[0]['vEmail'])) {
                                                        echo "value='" . $all[0]['vEmail'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="emailErr" class="help-block"></span>
                                            </div>
                                            <div id="changpassbtndiv" style="<?php echo ($mode == "edit") ? "display:block" : "display:none"; ?>">
                                                <div class="form-group">
                                                    <div class="col-sm-8 pull-right">
                                                        <button type="button" class="btn btn-sm btn-success" id="changpassbtn" name="changpassbtn"><i class="fa fa-floppy-o"></i> Change Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="change_pass_div" style="<?php echo ($mode == "edit") ? "display:none" : "display:block" ?>">
                                                <div class="form-group">
                                                    <label for="password" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control requiredview" id="password" name="password" placeholder="">
                                                    </div>
                                                    <span id="passwordErr" class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password2" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Conform Password:</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control requiredview" id="password2" name="password2" placeholder="">
                                                    </div>
                                                    <span id="passwordErr" class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="contactNo" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Contact No:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="contactNo" name="contactNo" placeholder=""<?php
                                                    if (isset($all[0]['vContactNo'])) {
                                                        echo "value='" . $all[0]['vContactNo'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="contactNoErr" class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="bussinessType" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Bussiness Type:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="bussinessType" name="bussinessType">
                                                        <option value="Individual" <?php echo (!empty($all[0]['eBusinessType']) && $all[0]['eBusinessType'] == "Individual") ? "selected" : '' ?>>Individual</option>
                                                        <option value="Business" <?php echo (!empty($all[0]['eBusinessType']) && $all[0]['eBusinessType'] == "Business") ? "selected" : '' ?>>Business</option>
                                                    </select>
                                                </div>
                                                <span id="bussinessTypeErr" class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Status:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="Active" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Active") ? "selected" : '' ?>>Active</option>
                                                        <option value="Inactive" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Inactive") ? "selected" : '' ?>>Inactive</option>
                                                        <option value="Pending" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Pending") ? "selected" : '' ?>>Pending</option>
                                                    </select>
                                                </div>                                                    
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6 ">
                                        <div class="form-inner">
                                            <div class="form-group">
                                                <label for="address" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Address:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control requiredview" id="address" name="address" placeholder=""<?php
                                                    if (isset($all[0]['tAddress'])) {
                                                        echo "value='" . $all[0]['tAddress'] . "'";
                                                    }
                                                    ?>>
                                                </div>
                                                <span id="addressErr" class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="area" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Area/Landmarks:</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control requiredview" id="area" name="area" placeholder=""><?php
                                                        if (isset($all[0]['vArea'])) {
                                                            echo $all[0]['vArea'];
                                                        }
                                                        ?></textarea>
                                                </div>
                                                <span id="areaErr" class="help-block"></span>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="image" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Driving Licence:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="dlimg" id="dlimg" <?php if ($all[0]['vDl'] == "") { echo 'required=""'; }  ?>/> 
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <?php
                                                        if ($all[0]['vDl'] != "") {
                                                            $file = $this->config->item('upload_path') . 'users/' . $all[0]['iUserId'] . '/' . $all[0]['vDl'];
                                                            if (file_exists($file)) {
                                                                ?>
                                                                <div class="col-md-2 pull-left">
                                                                    <img src="<?php echo $this->config->item('upload_url') . 'users/' . $all[0]['iUserId'] . '/' . $all[0]['vDl']; ?>" height="100" width="100"/>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="image" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Any ID Proof:</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="idimg" id="idimg" <?php if ($all[0]['vIdimg'] == "") { echo 'required=""'; }  ?>/> 
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <?php
                                                        if ($all[0]['vIdimg'] != "") {
                                                            $file = $this->config->item('upload_path') . 'users/' . $all[0]['iUserId'] . '/' . $all[0]['vIdimg'];
                                                            if (file_exists($file)) {
                                                                ?>
                                                                <div class="col-md-2 pull-left">
                                                                    <img src="<?php echo $this->config->item('upload_url') . 'users/' . $all[0]['iUserId'] . '/' . $all[0]['vIdimg']; ?>" height="100" width="100"/>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <div class="col-lg-12">
        <div class="box ui-sortable-handle" style="position: relative;">
                        <header>
                        <h5 data-toggle="collapse" href="#vehinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Vehicle Information <i class="fa fa-chevron-down pull-right text-grey"> </i>
                        </h5>
                        </header>
                        <div class="body collapse in" id="vehinfo">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <div class="form-group">
                                            <label for="type" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Vehicle Type:</label>
                                            <div class="col-sm-8">
                                                <?php // pr($vehicleTypes, 1); ?>
                                                <select class="form-control" id="vehicleId" name="vehicleId">
                                                    <option value="0">--None--</option>
                                                    <?php
                                                    foreach ($vehicleTypes as $key => $value) {
                                                        ?>   
                                                        <option value="<?php echo $value['iVehicleTypeId'] ?>" <?php echo ($value['iVehicleTypeId'] == $all[0]['iVehicleId']) ? "selected" : '' ?>><?php echo $value['vType'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <span id="typeErr" class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="standingpoint" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Standing Point:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control requiredview" id="standingPoint" name="standingPoint" placeholder=""<?php
                                                if (isset($all[0]['tStandingPoint'])) {
                                                    echo "value='" . $all[0]['tStandingPoint'] . "'";
                                                }
                                                ?>>
                                                <!--<label class="pull-right"><input type="checkbox"/> Same as User Address</label>-->
                                            </div>
                                            <span id="numberErr" class="help-block"></span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <div class="form-group">
                                            <label for="number" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Vehicle Number:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control requiredview" id="number" name="number" placeholder=""<?php
                                                if (isset($all[0]['vNumber'])) {
                                                    echo "value='" . $all[0]['vNumber'] . "'";
                                                }
                                                ?>>
                                            </div>
                                            <span id="numberErr" class="help-block"></span>
                                        </div>
                                    </div> 
                                </div>
                            </div>                                                    
                        </div>    
                    </div>
    </div>
    <div class="col-lg-12">
        <div class="box ui-sortable-handle" style="position: relative;">
            <header>
                                <h5 data-toggle="collapse" href="#vehImginfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Vehicle Images <i class="fa fa-chevron-down pull-right text-grey"> </i>
                                </h5>
            </header>
                                <div class="body collapse in" id="vehImginfo">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-inner">
                                                <div class="form-group">
                                                    <label for="images" class="col-sm-4 control-label">Select File(s):</label>
                                                    <div class="col-sm-8" style="margin-top: 5px">
                                                        <input type="file" name="vehImages[]" id="vehImages" multiple="multiple"/>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-inner">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <?php
                                                        if (count($images) > 0) {
                                                            foreach ($images as $key => $value) {
                                                                    
                                                                $file = $this->config->item('upload_path') . 'vehicles/' . $all[0]['iUserId'] . '/' . $value['vName'];
                                                                if (file_exists($file)) {
                                                                    ?>
                                                                    <div class="col-md-4">
                                                                        <img src="<?php echo $this->config->item('upload_url') . 'vehicles/' . $all[0]['iUserId'] . '/' . $value['vName']; ?>" height="100" width="100"/>
                                                                        <a href="javascript:void(0)" class="text-danger " onclick="delete_file(this)" data-bind="<?php echo $value['iImageId'] ?>"><i class="fa fa-trash"></i></a>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>                                                    
                                                </div>
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
</div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>