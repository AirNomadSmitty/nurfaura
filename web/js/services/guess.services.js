angular.module('guess.services', [])
.factory('guess.services.match', function($resource) {
  return $resource('getMatch'); 
})
.factory('guess.services.guess', function($resource){
    return $resource('matchGuess', {}, {
      post: {
        method:"POST",
        isArray: false,
        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
      }
    });
})
.factory('guess.services.leaderboard', function($resource){
    return $resource('submitScore', {}, {
      post: {
        method:"POST",
        isArray: false,
        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
      }
    });
});