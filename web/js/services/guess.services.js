angular.module('myApp.services', []).factory('Match', function($resource) {
  return $resource('getMatch'); // Note the full endpoint address
})
.factory('Guess', function($resource){
    return $resource('matchGuess');
});