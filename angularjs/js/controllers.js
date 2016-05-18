(function () {
    'use strict';

    /* Controllers */

    // Global "database"
		// Figure out how to query myphpadmin
    var pollList = [
        {id: 1, title: 'Donald or Bush', question: 'Would you rather be ruled by incompetence or terror?'},
        {id: 2, title: 'Ronald or Kush', question: 'Would you rather be ruled by nonhopetence or merror?'},
        {id: 3, title: 'Ponald or Dush', question: 'Would you rather be ruled by lemonescence or Sarrah?'},
    ];

		var choices = {
			1: {'Donald': 4, 'Bush':3},
			2: {'Ronald': 6, 'Kush':3},
			3: {'Ponald': 3, 'Dush':2}
		};



    var pollsControllers = angular.module('pollsControllers', []);

    pollsControllers.controller('PollListCtrl', ['$scope', 
        function ($scope) {
            $scope.polls = pollList;
            $scope.author = 'Patrick Nicholls';
        }]);

    pollsControllers.controller('PollDetailCtrl', ['$scope', '$routeParams',
      function($scope, $routeParams) {
          $scope.pollId = $routeParams.pollId;
					$scope.choice = undefined;
          // Look up item in "database"
					$scope.choices = choices[$scope.pollId];
					$scope.vote = function() {
						//Increment database through PHP somehow
						$scope.choices[$scope.choice] += 1;
					};
					$scope.reset = function() {
						for (var choice in $scope.choices) {
							if ($scope.choices.hasOwnProperty(choice)) {
								$scope.choices[choice] = 0;
							}
						}
					}
      }]);
  }())
