<script type="text/javascript">
        app.directive('fileModel', ['$parse', function ($parse) {
            return {
               restrict: 'A',
               link: function(scope, element, attrs) {
                  var model = $parse(attrs.fileModel);
                  var modelSetter = model.assign;
                  
                  element.bind('change', function(){
                     scope.$apply(function(){
                        modelSetter(scope, element[0].files[0]);
                     });
                  });
               }
            };
         }]);
      
         app.service('fileUpload', ['$http', function ($http) {
            this.uploadFileToUrl = function(file, uploadUrl){
               var fd = new FormData();
               fd.append('file', file);
            
               $http.post(uploadUrl, fd, {
                  transformRequest: angular.identity,
                  headers: {'Content-Type': undefined}
               })
            
               .success(function(){
               })
            
               .error(function(){
               });
            }
         }]);
  
    app.controller("userController", ['$scope', '$http', 'fileUpload', function($scope,$http,fileUpload){
    $scope.address = null;
    $scope.users = [];
    $scope.tempUserData = {};
    
    // function to insert or update user data to the database
    $scope.saveUser = function(type){
        var dlimg = $scope.dlimg;
        var idimg = $scope.idimg;
        console.dir(dlimg);
        console.dir(idimg);
        
        var uploadUrl = site_url + "content/user_add_upload" ;
        fileUpload.uploadFileToUrl(dlimg, uploadUrl);
        fileUpload.uploadFileToUrl(idimg, uploadUrl);
               
        var data = $.param({
         // 'data':$scope.tempUserData,
            'data':{'d1':$scope.tempUserData,'f1':dlimg.name,'f2':idimg.name},
            'type':type
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post( site_url + "content/user_add", data, config).success(function(response){
            if(response.status == 'OK'){   
                $scope.userForm.$setPristine();
                $scope.tempUserData = {};
                $('.userForm').slideUp();
                $scope.messageSuccess(response.msg);
            }
        });
    };
    
    // function to add user data
    $scope.addUser = function(){
        $scope.showErrorsCheckValidity = true;
        if ($scope.userForm.$valid) {		
            $scope.saveUser('add');
        }
    };
    
    
    
    // function to display success message
    $scope.messageSuccess = function(msg){
        $('.alert-success > p').html(msg);
        $('.alert-success').show();
    };
    
   
}]);
</script>
<div ng-controller="userController">
<form id="userForm" name="userForm" class="userForm" method="POST" enctype="multipart/form-data" ng-submit="addUser()" novalidate>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group listing-form-field">
                    <input type="text" class="form-field bgwhite" id="firstName" name="firstName" placeholder="First Name" ng-model="tempUserData.firstName" required />
                    
                    <div class="alert alert-danger"
    ng-show="userForm.firstName.$pristine.required">
    Please enter your name!
  </div>
                    
              
                    
                </div>
                <div class="form-group listing-form-field">
                    <input type="tel" class="form-field bgwhite" id="contactNo" name="contactNo" placeholder="Contact Number" ng-model="tempUserData.contactNo" required />
                    <span ng-show="userForm.contactNo.$invalid && !userForm.contactNo.$pristine" class="help-block">You name is required.</span>
                </div>
                <div class="form-group select-field-wrap">
                    <select class="search-form-select" id="vehicleId" name="vehicleId" ng-model="tempUserData.vehicleId" >
                                <option value="0">Vehicle</option>
                                <?php foreach ($vehicleTypes as $key => $value) {
                                    ?>   
                                    <option value="<?php echo $value['iVehicleTypeId'] ?>"><?php echo $value['vType'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                    <span ng-show="userForm.vehicleId.$invalid && !userForm.vehicleId.$pristine" class="help-block">You name is required.</span>
                </div>
                <div class="form-group listing-form-field">
                    <p class="blue-1">Driving Licence :</p>
                    <input type="file" name="dlimg" id="dlimg" class="form-field bgwhite" placeholder="Vehicle Registration No." file-model="dlimg" />
                    <span ng-show="userForm.dlimg.$invalid && !userForm.dlimg.$pristine" class="help-block">You name is required.</span>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 rootdiv">
                <div class="form-group listing-form-field">
                    <input type="text" class="form-field bgwhite" id="lastName" name="lastName" placeholder="Last Name" ng-model="tempUserData.lastName" required />
                    <span ng-show="userForm.lastName.$invalid && !userForm.lastName.$pristine" class="help-block">You name is required.</span>
                </div>
                <div class="form-group listing-form-field">
                    <input type="email" class="form-field bgwhite" id="email" name="email" placeholder="Email Address" ng-model="tempUserData.email.text" required />
                    <span ng-show="userForm.email.$invalid && !userForm.email.$pristine" class="help-block">You name is required.</span>
                </div>
                <div class="form-group listing-form-field">
                    <input type="text" class="form-field bgwhite" id="number" name="number" placeholder="Vehicle Registration No." ng-model="tempUserData.number" required />
                    <span ng-show="userForm.number.$invalid && !userForm.number.$pristine" class="help-block">You name is required.</span>
                </div>
                <div class="form-group listing-form-field">
                    <p class="blue-1">Any ID Proof :</p>
                    <input type="file" name="idimg" id="idimg" class="form-field bgwhite" placeholder="Vehicle Registration No." file-model="idimg" />
                    <span ng-show="userForm.idimg.$invalid && !userForm.idimg.$pristine" class="help-block">You name is required.</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group listing-form-field">
                    <input type="text" class="form-field bgwhite" id="address" name="address" placeholder="Address" g-places-autocomplete ng-model="tempUserData.address" required />
                    <span ng-show="userForm.address.$invalid && !userForm.address.$pristine" class="help-block">You name is required.</span>
                </div>
            </div>
            <div class="col-md-12 listing-form-field">
                <input type="submit" class="form-field submit bgblue-1" value="submit" />
            </div>
        </div>
    </form>
    <div class="alert alert-success none"><p></p></div>
</div>