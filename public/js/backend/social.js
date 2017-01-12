    'use strict';
    
    // Declaring angular module
    var app = angular.module('Call4peonApp', []);

    // Defining angular controller
    app.controller('SocialCtrl', ['$scope', function($scope) {

        $scope.choices = [{id: 'choice1'}, {id: 'choice2'}, {id: 'choice3'}, {id: 'choice4'}];

        $scope.addNewChoice = function($event) {
          var newItemNo = $scope.choices.length+1;
          $scope.choices.push({'id':'choice'+newItemNo});
          $event.preventDefault();
        };
        
         $scope.removeOldChoice = function($event, $index) {
          $scope.choices.splice($index,1);
          $event.preventDefault();
        };
  
    }

    ]);
