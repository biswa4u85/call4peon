<?php include APPPATH . '/back-modules/views/header.php'; ?>
<script type="text/javascript">
'use strict';
    
    // Declaring angular module
    var app = angular.module('Call4peonApp', []);

    // Defining angular controller
    app.controller('SocialCtrl', ['$scope', function($scope) {

        $scope.socialicons = <?php echo $social; ?>;

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
<!-- Page Content -->
<div class="row">
              <div class="col-lg-12">
                <div class="box" ng-controller="SocialCtrl">
                 <form id="frm-setting" action="admin/system_setting_action" method="post" class="form-horizontal">
                  <header>
                      <ul class="nav nav-tabs" role="tablist">
                    <li class="active">
                        <a href="#appearance" role="tab" data-toggle="tab"><i class="fa fa-user" style="padding-right: 10px;border-right: 1px solid #d1d1d1;margin-right: 10px;"></i> Appearance</a>
                    </li>            

                    <li>
                        <a href="#social" role="tab" data-toggle="tab"><i class="fa fa-user" style="padding-right: 10px;border-right: 1px solid #d1d1d1;margin-right: 10px;"></i> Social</a>
                    </li>
                    <li class="toolbar">
                         <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-floppy-o"></i> Submit</button>              
                    </li>
                </ul>
                    
                  </header>
 <?php
        $expiredate = substr($all['dtExpireDate'], 0, 10);
        $now = date("Y-m-d");
        ?>
                    
                    
<div class="body">
    
   <div class="tab-content">
            <div class="tab-pane fade active in" id="appearance">
                <div class="panel-wrapper collapse in" style="height: auto;">
                        <div class="common_whitebg">
                            <div class="col-md-12"> 
                                        <div class="row">
                                            <div class="col-md-12 handle">
                                                <?php foreach ($appearance as $key => $value) { ?>
                                                    <div class="row">
                                                        <!--Start of 1st column-->
                                                        <div class="control-group">
                                                            <label class="control-label col-md-3" for="name"><?php echo $value['vDesc']; ?></label>
                                                            <div class="col-md-8">                                                 
                                                                <input type="text" id="<?php echo $value['vName']; ?>" name="<?php echo $value['vName']; ?>" class="form-control" value="<?php echo $value['vValue']; ?>" >
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>                
                                       
                            </div>

                        </div>
                    </div>
                </div>
            <div class="tab-pane fade" id="social">
                <div class="panel-wrapper collapse in" style="height: auto;">
                    <div class="common_whitebg">
                            <div class="col-md-12"> 
                                                    <div class="row control-group" data-ng-repeat="socialicon in socialicons">
                                                        <!--Start of 1st column-->
                                                            <label class="control-label col-md-2" for="name">Social Icon {{$index}}</label>
                                                            <div class="col-md-3"> 
                                                                <input type="text" ng-model="socialicon.name" placeholder="Name" class="form-control" name="{{socialicon.name}}" value="{{socialicon.name}}" required >
                                                                <span class="help-block"></span>
                                                            </div>
                                                            <div class="col-md-3"> 
                                                                <input type="text" ng-model="socialicon.icon" placeholder="Icon Shortcode" class="form-control" name="{{socialicon.icon}}" value="{{socialicon.icon}}" required >
                                                                <span class="help-block"></span>
                                                            </div>
                                                            <div class="col-md-3"> 
                                                                <input type="text" ng-model="socialicon.link" placeholder="Link" class="form-control" name="{{socialicon.link}}" value="{{socialicon.link}}" required >
                                                                <span class="help-block"></span>
                                                            </div>
                                                            <div class="col-md-1">                                                 
                                                                <button class="btn btn-danger btn-xs" ng-click="removeOldChoice($event, $index)">-</button>
                                                            </div>
                                                        
                                                    </div>
                                                <button class="btn btn-success btn-xs" ng-click="addNewChoice($event)">Add Icons</button>
                                                <input type="hidden" id="SOCIAL_ICONS" name="SOCIAL_ICONS" class="form-control" value="{{ socialicons }}" >
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