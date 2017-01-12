<?php include APPPATH . '/back-modules/views/header.php'; ?>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/shipment.js"></script>
<div class="row">
              <div class="col-lg-12">
                <div class="box">
                 <form class="form-horizontal formclass" id="shipmentForm" name="shipmentForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>shipment/shipment_add_action" enctype="multipart/form-data">
                  <header>
                    <div class="icons"><i class="fa fa-edit"></i></div>
                    <h5><?php echo (!isset($all[0]['iShipmentId']) && $mode == "add") ? 'Add Shipment' : ucfirst($mode) . ' Shipment'; ?></h5>
                    <div class="toolbar">
                         <button type="submit" class="btn btn-success btn-xs" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                         <button type="submit" class="btn btn-info btn-xs" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                         <button class="btn btn-danger btn-xs" value="cancel" onclick="cancelAction();
        return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                           
                    </div>
                  </header>
                    
                    
<div class="body">
                                    <input type="hidden" id="iShipmentId" name="iShipmentId" <?php
                                    if (isset($all[0]['iShipmentId'])) {
                                        echo "value='" . $all[0]['iShipmentId'] . "'";
                                    }
                                    ?>>
                                    <input type="hidden" id="mode" name="mode" <?php
                                    echo "value='" . $mode . "'";
                                    ?>>
                                    
                                        
                                            <div class="row">
               <div class="col-lg-12">
                <div class="box ui-sortable-handle" style="position: relative;">
                  <header>
                    <h5 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Shipment Information <i class="fa fa-chevron-down pull-right text-grey"> </i></h5>
                  </header>
                  <div class="body collapse in" id="modinfo">
                      <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-inner">
                                                                        <div class="form-group">
                                                                            <label for="title" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Shipment Title:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="title" name="title" placeholder=""<?php
                                                                                if (isset($all[0]['vTitle'])) {
                                                                                    echo "value='" . $all[0]['vTitle'] . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="titleErr" class="help-block"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="description" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Shipment Description:</label>
                                                                            <div class="col-sm-8">
                                                                                <textarea class="form-control requiredview" id="description" name="description" placeholder=""><?php
                                                                                    if (isset($all[0]['tDescription'])) {
                                                                                        echo $all[0]['tDescription'];
                                                                                    }
                                                                                    ?></textarea>
                                                                            </div>
                                                                            <span id="descriptionErr" class="help-block"></span>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="vehicle" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Vehicle:</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control" id="vehicle" name="vehicle">
                                                                                    <option value="0">--None--</option>
                                                                                    <?php foreach ($vehicleTypes as $key => $value) {
                                                                                        ?>   
                                                                                        <option value="<?php echo $value['iVehicleTypeId'] ?>" <?php echo ($value['iVehicleTypeId'] == $all[0]['iVehicleId']) ? "selected" : '' ?>><?php echo $value['vType'] ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>                                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="prefferedDate" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Preffered Date:</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                            <input class="form-control" type="text" value="12-02-2012" readonly>
                            <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
                                                                                </div>
                                                                                
                                                                                <input type="text" class="form-control datepicker requiredview" id="prefferedDate" name="prefferedDate" placeholder=""<?php
                                                                                if (isset($all[0]['vPreferredDate'])) {
                                                                                    echo "value='" . date_format(date_create($all[0]['vPreferredDate']), "d-M-Y") . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="prefferedDateErr" class="help-block"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>                             
                                                                <div class="col-md-6">
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
                                                                            <label for="lastName" class="col-sm-4 control-label">Last Name:</label>
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
                                                                            <label for="contactNo" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Contact No:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="contactNo" name="contactNo" placeholder=""<?php
                                                                                if (isset($all[0]['vContactNo'])) {
                                                                                    echo "value='" . $all[0]['vContactNo'] . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="contactnoErr" class="help-block"></span>
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
                                                            </div>
                  </div>
                </div>
               </div>
                    
               <div class="col-lg-12">
                <div class="box ui-sortable-handle" style="position: relative;">
                  <header>
                    <h5 data-toggle="collapse" href="#imgs" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Shipment Images <i class="fa fa-chevron-down pull-right text-grey"> </i></h5>
                  </header>
                  <div class="body collapse in" id="imgs">
                      <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-inner">
                                                                        <div class="form-group">
                                                                            <label for="shipImages" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Image(s):</label>
                                                                            <div class="col-sm-8">
                                                                                <input style="margin-top: 5px;" type="file" name="shipImages[]" id="shipImages" multiple="multiple"/>
                                                                            </div>
                                                                            <span id="pickupAddressErr" class="help-block"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="col-md-12">
                                                                            <?php
                                                                            if (count($images) > 0) {
                                                                                foreach ($images as $key => $value) {
                                                                                    $file = $this->config->item('upload_path') . 'shipments/' . $all[0]['iShipmentId'] . '/' . $value['vName'];
                                                                                    if (file_exists($file)) {
                                                                                        ?>
                                                                                        <div class="col-md-4">
                                                                                            <img src="<?php echo $this->config->item('upload_url') . 'shipments/' . $all[0]['iShipmentId'] . '/' . $value['vName']; ?>" height="100" width="100"/>
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
                   
                                                <div class="col-lg-12">
               <div class="row">
                   <div class="col-md-6">
      
                <div class="box ui-sortable-handle" style="position: relative;">
                  <header>
                    <h5 data-toggle="collapse" href="#pickups" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Pickup Details <i class="fa fa-chevron-down pull-right text-grey"> </i></h5>
                  </header>
                  <div class="body collapse in" id="pickups">
                      <div class="form-inner">
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="pickupAddress" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Address:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="pickupAddress" name="pickupAddress" placeholder=""<?php
                                                                                if (isset($all[0]['vPickupAddress'])) {
                                                                                    echo "value='" . $all[0]['vPickupAddress'] . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="pickupAddressErr" class="help-block"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="pickupArea" class="col-sm-4 control-label">Area:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="pickupArea" name="pickupArea" placeholder=""<?php
                                                                                if (isset($all[0]['vPickupArea'])) {
                                                                                    echo "value='" . $all[0]['vPickupArea'] . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="pickupAreaErr" class="help-block"></span>
                                                                        </div>
                                                                    </div>
                    </div>
    
               </div>
                 </div>
                                                <div class="col-md-6">
                                                    
                                                   
                <div class="box" style="position: relative;">
                  <header>
                    <h5 data-toggle="collapse" href="#drops" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Drop Details <i class="fa fa-chevron-down pull-right text-grey"> </i></h5>
                  </header>
                  <div class="body collapse in" id="drops">
                      <div class="form-inner">
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="dropAddress" class="col-sm-4 control-label"><sup class="text-danger">*</sup>Address:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="dropAddress" name="dropAddress" placeholder=""<?php
                                                                                if (isset($all[0]['vDropAddress'])) {
                                                                                    echo "value='" . $all[0]['vDropAddress'] . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="dropAddressErr" class="help-block"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="dropArea" class="col-sm-4 control-label">Area:</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control requiredview" id="dropArea" name="dropArea" placeholder=""<?php
                                                                                if (isset($all[0]['vDropArea'])) {
                                                                                    echo "value='" . $all[0]['vDropArea'] . "'";
                                                                                }
                                                                                ?>>
                                                                            </div>
                                                                            <span id="dropAreaErr" class="help-block"></span>
                                                                        </div>
                                                                    </div>
                  </div>
                </div>
               
                      
     
                                                </div>
                                            </div>
                      
                    
</div>

                                            </div>
                                            

<div class="clearfix"></div>
    </div>
</form>
</div>
</div></div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>