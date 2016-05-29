(function () {
    'use strict';

    /* Controllers */
    var pollsControllers = angular.module('pollsControllers', []);
    
    var author = 'Patrick Nicholls';

    pollsControllers.controller('PollListCtrl', ['$scope', '$http',
        function ($scope, $http) {
            var resource = "/~pjn59/365/polls/index.php/services/polls";
            $scope.polls = undefined;
            $scope.author = author;
            $http.get(resource)
                    .success(function(data){
                        $scope.polls = data;
                
            })
                    .error(function(){
                        console.log("Couldn't get data");
            });
        }]);

    pollsControllers.controller('PollDetailCtrl', ['$scope', '$routeParams', '$http',
      function($scope, $routeParams, $http) {
        $scope.pollId = $routeParams.pollId;
        $scope.title = undefined;
        $scope.quesiton = undefined;
        $scope.choice = undefined;
        var base_url = "/~pjn59/365/polls/index.php/services/";
          
        $http.get(base_url + "polls/" + $scope.pollId)
                .success(function(data){
                    console.log(data);
                    var choices = [];
                    for (var i = 0; i < data.choices.length; i++) {
                        choices[i] = {
                            'choice': data.choices[i],
                            'votes' : parseInt(data.votes[i])
                        };
                    }
                    $scope.choices = choices;
                    $scope.question = data.question;
                    $scope.title = data.title;
                    console.log($scope.choices);
        })
                .error(function(){
                    console.log("Couldn't get data");
        });
        
        $scope.vote = function() {
            //Increment database through PHP somehow
            $scope.choices[$scope.choice-1].votes += 1;          
            $http.post(base_url + "votes/" + $scope.pollId + "/" + $scope.choice)
                    .success(function(data){
                        console.log("Vote succeeded")
            })
                    .error(function(){
                        console.log("Vote unsuccessful");
            }); 
        };
        
        $scope.reset = function() {
            
            for (var i = 0; i < $scope.choices.length; i++) { 
                $scope.choices[i].votes = 0;
            }
                  
            $http.delete(base_url + "votes/" + $scope.pollId)
                    .success(function(data){
                        console.log("Reset succeeded")
            })
                    .error(function(){
                        console.log("Reset unsuccessful");
            }); 
        }
      }]);
  
    
    pollsControllers.controller('AboutCtrl', ['$scope',
        function ($scope) {
            $scope.author = author;
        }]);
    
  }())
