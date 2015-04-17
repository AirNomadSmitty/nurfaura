angular.module('leaderboard.controller', [])
.controller('leaderboard.controller.grid', ['$scope', '$filter', 'leaderboard.services.grid', function ($scope, filter, gridRead) {
    $scope.players =[];
    gridRead.query(function(x){
        $scope.players = x;
    });
}]);