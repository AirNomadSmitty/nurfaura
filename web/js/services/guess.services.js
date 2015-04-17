angular.module('myApp.services', []).factory('Match', function($resource) {
  return $resource('getMatch'); 
})
.factory('Guess', function($resource){
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