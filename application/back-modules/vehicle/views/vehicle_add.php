<?php include APPPATH . '/back-modules/views/header.php'; ?>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/css/select2.css"/>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/js/select2.js"></script>

<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/vehicle.js"></script>
<div class="col-md-12 his_upc">
    <div class="row">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#Mdetail" role="tab" data-toggle="tab">
                    <i class="fa fa-user" style="padding-right: 10px;border-right: 1px solid #d1d1d1;margin-right: 10px;"></i> Vehicle Information
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade active in" id="Mdetail" style="max-height: none;">
                <div class="panel-wrapper collapse in" style="height: auto;">
                    <div>

                        <div class="common_whitebg">
                            <div class="col-md-12"> 
                                <form class="form-horizontal formclass" id="vehicleForm" name="vehicleForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>vehicle/vehicle_add_action" enctype="multipart/form-data">

                                    <div id="stickybutton" class="row sticky_div">
                                        <div class="col-md-12 text-center stick_btn">
                                            <div class="Left-Head">
                                                <h3><?php echo (!isset($all[0]['iVehicleId']) && $mode == "add") ? 'Add Vehicle' : ucfirst($mode) . ' Vehicle'; ?></h3>
                                            </div>
                                            <div class="submit-Btn marbottom_10 martop_10">    
                                                <button type="submit" class="btn btn-success" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                                                <button type="submit" class="btn btn-info" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                                                <button class="btn btn-danger" value="cancel" onclick="cancelAction();
                                                        return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                            </div>
                                        </div>                
                                    </div>
                                    <input type="hidden" id="iVehicleId" name="iVehicleId" <?php
                                    if (isset($all[0]['iVehicleId'])) {
                                        echo "value='" . $all[0]['iVehicleId'] . "'";
                                    }
                                    ?>>
                                    <input type="hidden" id="mode" name="mode" <?php
                                    echo "value='" . $mode . "'";
                                    ?>>
                                    <div class="col-md-12">
                                        <div id="sortable">
                                            <div class="row">
                                                <div class="col-md-6 handle">
                                                    <div class="form-box-main">
                                                        <h4 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Vehicle Information <i class="fa fa-chevron-down pull-right text-grey"> </i>
                                                        </h4>
                                                        <div class="collapse in" id="modinfo">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-inner">
                                                                        <div class="form-group">
                                                                            <label for="user" class="col-sm-4 control-label"><sup class="text-danger">*</sup>User:</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="user" name="user">
                                                                                    <option value="0">--None--</option>
                                                                                    <?php foreach ($users as $key => $value) { ?>
                                                                                        <option value="<?php echo $value['iUserId']; ?>" <?php echo ($value['iUserId'] == $all[0]['iUserId']) ? "selected" : '' ?> ><?php echo $value['vFirstName']; ?></option>
                                                                                    <?php }
                                                                                    ?>
                                                                                </select>
                                                                            </div>                                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="type" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Vehicle Type:</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="type" name="type">
                                                                                    <option value="0">--None--</option>
                                                                                    <?php foreach ($vehicleTypes as $key => $value) { ?>
                                                                                        <option value="<?php echo $value['iVehicleTypeId']; ?>" <?php echo ($value['iVehicleTypeId'] == $all[0]['iVehicleTypeId']) ? "selected" : '' ?> ><?php echo $value['vType']; ?></option>
                                                                                    <?php }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <span id="typeErr" class="help-block"></span>
                                                                        </div>
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
                                                                        <div class="form-group">
                                                                            <label for="standingpoint" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Standing Point:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="standingPoint" name="standingPoint" placeholder=""<?php
                                                                                if (isset($all[0]['tStandingPoint'])) {
                                                                                    echo "value='" . $all[0]['tStandingPoint'] . "'";
                                                                                }
                                                                                ?>>
                                                                                <label class="pull-right"><input type="checkbox"/> Same as User Address</label>
                                                                            </div>
                                                                            <span id="numberErr" class="help-block"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="status" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Status:</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="status" name="status">
                                                                                    <option value="Active" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Active") ? "selected" : '' ?>>Active</option>
                                                                                    <option value="Inactive" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Inactive") ? "selected" : '' ?>>Inactive</option>
                                                                                </select>
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


                                        <div id="sortable">
                                            <div class="row">
                                                <div class="col-md-6 handle">
                                                    <div class="form-box-main">
                                                        <h4 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Vehicle Images <i class="fa fa-chevron-down pull-right text-grey"> </i>
                                                        </h4>
                                                        <div class="collapse in" id="modinfo">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-inner">
                                                                        <div class="form-group">
                                                                            <label for="images" class="col-sm-4 control-label">Select File(s):</label>
                                                                            <div class="col-sm-8" style="margin-top: 5px">
                                                                                <input type="file" name="images[]" id="images" multiple="multiple"/>
                                                                            </div>                                                    
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-12">
                                                                                <?php
                                                                                if (count($images) > 0) {
                                                                                    foreach ($images as $key => $value) {
                                                                                        $file = $this->config->item('upload_path') . 'vehicles/' . $all[0]['iVehicleId'] . '/' . $value['vName'];
                                                                                        if (file_exists($file)) {
                                                                                            ?>
                                                                                            <div class="col-md-4">
                                                                                                <img src="<?php echo $this->config->item('upload_url') . 'vehicles/' . $all[0]['iVehicleId'] . '/' . $value['vName']; ?>" height="100" width="100"/>
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
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APPPATH . '/back-modules/views/footer.php'; ?>