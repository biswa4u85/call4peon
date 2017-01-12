<?php include APPPATH . '/front-modules/views/header.php'; ?>
<div class="nav-wrapper"><!--main navigation-->
				<div class="container">
					<!--Main Menu HTML Code-->
					<nav class="wsmenu slideLeft clearfix">
						<div class="logo pull-left"><a href="index.php" title="Responsive Slide Menus"><img src="<?php echo $this->config->item('front_assets_url'); ?>images/logo.png" alt="" /></a></div>
					</nav>
				</div>
			</div><!--main navigation end-->
		</div><!-- header end -->
<!--================================PAGE TITLE==========================================-->
		<div class="page-title-wrap bgorange-1 padding-top-30 padding-bottom-30"><!-- section title -->
			<h4 class="white">CHECK OUR CHARGES</h4>
		</div><!-- section title end -->

                
<div class="sc-page padding-top-70 padding-bottom-70"><!--sc-page-->
				<div class="container">
                                <div class="col-md-6 col-sm-6 col-xs-12"><!-- sidebar column 1 -->
<div class="sidebar sidebar-wrap">
							<div class="sidebar-widget shadow-1">
								<div class="sidebar-widget-title">
									<h5><span class="bgred-1"></span>SEARCH LISTINGS</h5>
								</div>
                                                            <script type="text/javascript" src="<?php echo $this->config->item('front_assets_url'); ?>js/shipment.js"></script>
<form id="shipmentForm" name="shipmentForm" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12"><div class="headtext">Shipment Information</div></div>
            <div class="col-md-6">
                <div class="form-inner">
                    <div class="form-group">
                        <input type="text" class="form-control requiredview" id="title" name="title" placeholder="Shipment Title">
                        <span id="titleErr" class="help-block"></span>
                    </div>
                    <div class="form-group">
                            <textarea class="form-control requiredview" id="description" name="description" placeholder="Shipment Description"></textarea>
                            <span id="descriptionErr" class="help-block"></span>
                    </div>

                    <div class="form-group">
                            <select class="form-control" id="vehicle" name="vehicle">
                                <option value="0">Vehicle</option>
                                <?php foreach ($vehicleTypes as $key => $value) {
                                    ?>   
                                    <option value="<?php echo $value['iVehicleTypeId'] ?>" <?php echo ($value['iVehicleTypeId'] == $all[0]['iVehicleId']) ? "selected" : '' ?>><?php echo $value['vType'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span id="descriptionErr" class="help-block"></span>
                    </div>
                    <div class="form-group">
                            <input type="text" class="form-control datepicker requiredview" id="prefferedDate" name="prefferedDate" placeholder="Preffered Date">
                            <span id="prefferedDateErr" class="help-block"></span>
                    </div>
                </div>
            </div>                             
            <div class="col-md-6">
                <div class="form-inner">
                    <div class="form-group">
                            <input type="text" class="form-control requiredview" id="firstName" name="firstName" placeholder="First Name">
                            <span id="firstNameErr" class="help-block"></span>
                    </div>
                    <div class="form-group">
                            <input type="text" class="form-control requiredview" id="lastName" name="lastName" placeholder="Last Name">
                            <span id="lastNameErr" class="help-block"></span>
                    </div>
                    <div class="form-group">
                            <input type="text" class="form-control requiredview" id="contactNo" name="contactNo" placeholder="Contact No">
                            <span id="contactNoErr" class="help-block"></span>
                    </div>

                    <div class="form-group">
                            <select class="form-control" id="status" name="status">
                                <option>Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                           <span id="statusErr" class="help-block"></span>
                    </div>
                </div>
            </div>                             
        </div>
    <div class="row"> 
        <div class="col-md-6 col-sm-6 rootdiv">
            <div class="headtext">Pickup Location</div>
            
            <div class="form-group">
                    <select class="form-control country" id="pickupCountry" name="pickupCountry">
                        <option>Country</option>
                        <?php
                        if (count($country) > 0) {
                            echo "<option value ='0'>Select Conuntry </option>";
                            foreach ($country as $key => $value) {
                                ?>
                                <option value="<?php echo $value['iCountryId']; ?>" <?php echo ($value['iCountryId'] == $all[0]['iPickupCountryId']) ? "selected" : ""; ?>><?php echo $value['vCountry']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                <span id="pickupCountryErr" class="help-block"></span>
            </div>
            <div class="form-group">
                    <select class="form-control state" id="pickupState" name="pickupState"><option value ='0'>Select State </option>;
                    </select>
            </div>
            <div class="form-group">
                    <select class="form-control city" id="pickupCity" name="pickupCity"><option value ='0'>Select City </option>;
                    </select>
                <span id="pickupCityErr" class="help-block"></span>
            </div>
            <div class="form-group">
                    <input type="text" class="form-control requiredview" id="pickupAddress" name="pickupAddress" placeholder="Address">
                    <span id="pickupAddressErr" class="help-block"></span>
            </div>
            <div class="form-group">
                    <input type="text" class="form-control requiredview" id="pickupArea" name="pickupArea" placeholder="Area">
                <span id="pickupAreaErr" class="help-block"></span>
            </div>
            <div class="form-group">
                    <input type="text" class="form-control requiredview" id="pickupLandmark" name="pickupLandmark" placeholder="Landmark">
                <span id="pickupLandmarkErr" class="help-block"></span>
            </div>
                                                                    
        </div>
        <div class="col-md-6 col-sm-6 rootdiv">
            <div class="headtext">Dropoff Location</div>
            <div class="form-group">
                  <select class="form-control country" id="dropCountry" name="dropCountry">
                      <option>Country</option>
                      <?php
                      if (count($country) > 0) {
                          echo "<option value ='0'>Select Conuntry </option>";
                          foreach ($country as $key => $value) {
                              ?>
                              <option value="<?php echo $value['iCountryId']; ?>" <?php echo ($value['iCountryId'] == $all[0]['iPickupCountryId']) ? "selected" : ""; ?>><?php echo $value['vCountry']; ?></option>
                              <?php
                          }
                      }
                      ?>
                  </select>
              <span id="dropCountryErr" class="help-block"></span>
          </div>
          <div class="form-group">
                  <select class="form-control state" id="dropState" name="dropState"><option value ='0'>Select State </option>;
                  </select>
              <span id="dropStateErr" class="help-block"></span>
          </div>
          <div class="form-group">
                  <select class="form-control city" id="dropCity" name="dropCity"><option value ='0'>Select City </option>;
                  </select>
              <span id="dropCityErr" class="help-block"></span>
          </div>
          <div class="form-group">
                  <input type="text" class="form-control requiredview" id="dropAddress" name="dropAddress" placeholder="">
              <span id="dropAddressErr" class="help-block"></span>
          </div>
          <div class="form-group">
                  <input type="text" class="form-control requiredview" id="dropArea" name="dropArea" placeholder="">
              <span id="dropAreaErr" class="help-block"></span>
          </div>
          <div class="form-group">
                  <input type="text" class="form-control requiredview" id="dropLandmark" name="dropLandmark" placeholder="">
              <span id="dropLandmarkErr" class="help-block"></span>
          </div>
        </div>
        
        <div class="col-md-12">
            <button type="submit" class="btn theme-btn popsub" value="submit" name="submit[]">submit</button>
        </div>

    </div>
</form>
								<div class="sidebar-widget-content listing-search-bar  clearfix">
									<div class="sidebar-listing-search-wrap">
										<form action="sc-sidebar.html#">
											<p class="blue-1">SEARCH FOR :</p>
											<select class="sidebar-listing-search-select">
												<option>ALL CATEGORIES</option>
												<option>ALL CATEGORIES</option>
												<option>ALL CATEGORIES</option>
											</select>
											<input class="sidebar-listing-search-input" placeholder="Search" name="search" type="text">
											<p class="blue-1">SEARCH NEAR :</p>
											<select class="sidebar-listing-search-select">
												<option>ALL CATEGORIES</option>
												<option>ALL CATEGORIES</option>
												<option>ALL CATEGORIES</option>
											</select>
											
											<input class="sidebar-listing-search-input" placeholder="Search" name="search" type="text">
											<p>Search In Radius</p>
											<div id="slider-range-min" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 62.6627%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 62.6627%;"></span></div>
											<p><a href="sc-sidebar.html#">Advanced Search</a></p>
											<div class="listing-search-btn">
												<input class="sidebar-listing-search-btn white bgblue-1" value="SEARCH" type="submit">
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
                                </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">Map</div>
                                </div>
</div>
<?php include APPPATH . '/front-modules/views/footer.php'; ?>