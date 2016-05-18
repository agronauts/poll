(function () {
    'use strict';

    /* App Module */

    var pollsApp = angular.module('pollsApp', [
      'ngRoute',
      'pollsControllers'
    ]);

    pollsApp.config(['$routeProvider',
      function($routeProvider) {
        $routeProvider.
          when('/polls', {
            templateUrl: 'partials/poll-list.html',
            controller: 'PollListCtrl'
          }).
          when('/polls/:pollId', {
            templateUrl: 'partials/poll-detail.html',
            controller: 'PollDetailCtrl'
          }).
          otherwise({
            redirectTo: '/polls'
          });
      }]);
}())
