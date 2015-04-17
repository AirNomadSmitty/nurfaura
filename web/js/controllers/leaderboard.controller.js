angular.module('leaderboard.controller', [])
.controller('leaderboard.controller.grid', ['$scope', 'leaderboard.services.grid', function ($scope, gridRead) {
    debugger
    $scope.players = gridRead.query();
}]);