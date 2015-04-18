angular.module('leaderboard.controller', [])
.controller('leaderboard.controller.grid', ['$scope', '$filter', 'leaderboard.services.grid', function ($scope, filter, gridRead) {
    $scope.players =[];
    gridRead.query(function(x){
        for (var i in x) {
            x[i].ratio = x[i].score/x[i].questionCount;
        }
        $scope.players = x;
    });
}]);