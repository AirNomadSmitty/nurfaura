angular.module('leaderboard.services', [])
.factory('leaderboard.services.grid', function($resource) {
  return $resource('getLeaderboard'); 
})
