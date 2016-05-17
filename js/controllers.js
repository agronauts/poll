(function () {
    'use strict';

    /* Controllers */

    // Global "database"
		// Figure out how to query myphpadmin
    var itemList = [
        {id: 1, title: 'Donald or Bush', question: 'Would you rather be ruled by incompetence or terror?'},
        {id: 2, title: 'Ronald or Kush', question: 'Would you rather be ruled by nonhopetence or merror?'},
        {id: 3, title: 'Ponald or Dush', question: 'Would you rather be ruled by lemonescence or Sarrah?'},
    ];



    var itemsControllers = angular.module('itemsControllers', []);

    itemsControllers.controller('ItemListCtrl', ['$scope', 
        function ($scope) {
            $scope.items = itemList;
            $scope.author = 'Angus McGurkinshaw';
        }]);

    itemsControllers.controller('ItemDetailCtrl', ['$scope', '$routeParams',
      function($scope, $routeParams) {
          var itemId = $routeParams.itemId;
          // Look up item in "database"
          for (var i = 0; i < itemList.length; ++i) {
              if (itemList[i].id == itemId) {
                  $scope.item = itemList[i];
              }
          }
      }]);
  }())
