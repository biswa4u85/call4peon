<!DOCTYPE html>
<html ng-app="Call4peonApp">
<head>
    <?php include APPPATH . '/front-modules/views/common_header_files.php'; ?>
    <script type="text/javascript">
'use strict';
    
    // Declaring angular module
    var app = angular.module('Call4peonApp', ['google.places','ngUpload']);

    // Defining angular controller
    app.controller('SocialCtrl', ['$scope', function($scope) {
        
        $scope.socialicons = <?php echo $this->config->item('SOCIAL_ICONS'); ?>;

        $scope.addNewChoice = function($event) {
          var newItemNo = $scope.socialicons.length+1;
          $scope.socialicons.push({'id':'socialicons'+newItemNo});
          $event.preventDefault();
        };
        
         $scope.removeOldChoice = function($event, $index) {
          $scope.socialicons.splice($index,1);
          $event.preventDefault();
        };
  
    }

    ]);
</script>
</head>
<body>
	<div class="preloader"><span class="preloader-gif"></span></div>
	<div class="theme-wrap clearfix">
		<!--================================responsive log and menu==========================================-->
		<div class="wsmenucontent overlapblackbg"></div>
		<div class="wsmenuexpandermain slideRight">
			<a id="navToggle" class="animated-arrow slideLeft"><span></span></a>
			<a href="index.php" class="smallogo"><img src="<?php echo $this->config->item('front_assets_url'); ?>images/logo.png" width="120" alt="" /></a>
		</div>
		<!--================================HEADER==========================================-->
                <div class="header" id="header">
			<div class="top-toolbar"><!--header toolbar-->
				<div class="container">
					<div class="row">
                                           
						<div class="col-md-8 col-sm-12 col-xs-12 pull-right" ng-controller="SocialCtrl">
							<div class="top-contact-info">
								<div class="social-content" ng-if="socialicons">
								<ul class="social-links">
                                                                    <li data-ng-repeat="icon in socialicons"><a href="{{icon.link}}"  class="facebook" title="{{icon.name}}" target="_blank"><i class="fa {{icon.icon}}"></i></a></li>
								</ul>
							</div>
                                                                <ul>
									<li class="toolbar-email"><i class="fa fa-envelope-o"></i> <?php echo $this->config->item('COMPANY_EMAIL');?></li>
									<li class="toolbar-contact"><i class="fa fa-phone"></i> <?php echo $this->config->item('COMPANY_PHONE');?></li>
									<li><a class="toolbar-new-listing" href="#" data-toggle = "modal" data-target = "#become"><i class="fa fa-plus-circle"></i> Become a Peon</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div><!--header toolbar end-->