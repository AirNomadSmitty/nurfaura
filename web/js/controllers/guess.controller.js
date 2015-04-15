var app = angular.module('myApp', ['ngResource', 'myApp.services', 'myApp.directives']);
app.controller('myCtrl', function($scope, $timeout, Match, Guess) {
    
    var goldDifference, timeAxis,  match, mytimeout, timers;
     timers =[];
    goldDifference = ['Gold Difference'];
    timeAxis = ['x'];
    var chart = setChartOptions();
    $scope.runAGame = function(){
        
        $scope.guess={score:0, team:'', matchId:0};
        goldDifference = ['Gold Difference'];
        timeAxis = ['x'];
        $scope.disabled = false;
        $scope.counter = 30;
        $scope.showModalCorrect = false;
        $scope.showModalWrong = false;
        clearTimers();
        timers =[];
        match = Match.get({}, function(){
            $scope.match = match.toJSON();
    		chart.axis.max({x: $scope.match.matchLength});
            setupTimers();
            mytimeout = $timeout($scope.onTimeout,1000);
        })    
    }
    
    function clearTimers(){
        while(timers.length > 0) {
            var currentTimer =timers.shift();
            $timeout.cancel(currentTimer)
        }
    }

    
    $scope.postGuess = function(){
        $scope.guess.score = $scope.counter;
        $scope.guess.matchId = $scope.match.match;
        debugger
        $timeout.cancel(mytimeout);
        Guess.post($.param($scope.guess), function(u, putResponseHeaders){
            $scope.result = {questionCount: u.questionCount, score: u.score};
            $scope.showModalCorrect = u.correct;
            $scope.showModalWrong = !$scope.showModalCorrect; 
        });
    }

    $scope.onTimeout = function(){
        $scope.counter--;
        if($scope.counter > 0){
            mytimeout = $timeout($scope.onTimeout,1000);
        }
    }
    

    $scope.toggleModal = function(){
        $scope.showModal = !$scope.showModal;
    };
  
    
    function setupTimers(){
            for (var i in match.events) {
                if(match.events[i].eventType == 'CHAMPION_KILL'){
                    timers.push($timeout(deathCounter.bind(null, match.events[i]),match.events[i].normalizedTimestamp));
                }
                else if(match.events[i].eventType == 'GOLD_UPDATE')
                {
                    timers.push($timeout(goldCounter.bind(null, match.events[i]), match.events[i].normalizedTimestamp));
                }
            }
        }
        
    function deathCounter(event){
        if (event.killerId < 6){
           
            if(event.killerId !== 0){
                 var killer = $scope.match.teams.blue.participants[event.killerId];
                killer.currentKills++;
            } 
            
            var killed = $scope.match.teams.red.participants[event.victimId];
            killed.currentDeaths++;
            if(typeof(event.assistingParticipantIds) !== 'undefined'){
                for (var n in event.assistingParticipantIds) {
                    var assist= $scope.match.teams.blue.participants[event.assistingParticipantIds[n]];
                    assist.currentAssists++;
                }
            }
            // debugger
        }
        else{
             var killer = $scope.match.teams.red.participants[event.killerId];
            killer.currentKills++;
            var killed = $scope.match.teams.blue.participants[event.victimId];
            killed.currentDeaths++;
            if(typeof(event.assistingParticipantIds) !== 'undefined'){
                for (var n in event.assistingParticipantIds) {
                    var assist= $scope.match.teams.red.participants[event.assistingParticipantIds[n]];
                    assist.currentAssists++;
                }
            }
        //  debugger
        }
    
    }
    
    function goldCounter(event){
        goldDifference.push(event.gold.blue - event.gold.red);
        timeAxis.push(event.prettyTimestamp);
        chart.load({
            columns:[
                timeAxis,
                goldDifference
            ]
        });
    }
    
    function search(players ,id){
        for (var i in players) {
            if (players[i].id == id){
                return players[i];
            } 
        }
    }
    function setChartOptions(){
        return c3.generate({
            bindto: '#goldGraph',
            data: {
                x: 'x',
    			xFormat: '%M:%S',
                columns: [
                    timeAxis,
                    goldDifference
                ],
    			color: function(color, d){
    				if( d.value > 0){
    					return '#0814FC';
    				} else if ( d.value < 0){
    					return '#FF0000';
    				} else {
    					return '#000000'
    				}
    			}
            },
            axis: {
              x: {
                type: 'timeseries',
                tick: {
                  format: '%M:%S'
                }
              }
            },
    	   regions: [
    			{axis: 'y', end: 0, class: 'region-red'},
    			{axis: 'y', start: 0, class: 'region-blue'}
    		]

        });
    }
    $scope.runAGame();
});