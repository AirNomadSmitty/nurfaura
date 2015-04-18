angular.module('guess.controllers', [])
.controller('guess.controller.guess', [
    '$scope',
    '$timeout',
    'guess.services.match',
    'guess.services.guess',
    'guess.services.leaderboard',
    function($scope, $timeout, matchService, guessService, leaderboardService) {
    var goldDifference, timeAxis,  match, mytimeout, timers;
    timers =[];
    goldDifference = ['Gold Difference'];
    timeAxis = ['x'];
    var chart = setChartOptions();
    $scope.overallScore = 0;
    $scope.runAGame = function(){
        if(typeof($scope.username) != 'undefined' && $scope.username.trim().length >0 ){
            leaderboardService.post($.param({username: $scope.username.trim()}))
        }
        $scope.callBack = false;
        $scope.result = null;
        $scope.username = '';
        $scope.guess={score:0, team:'', matchId:0};
        goldDifference = ['Gold Difference'];
        timeAxis = ['x'];
		chart.load({
			columns:[
				timeAxis,
				goldDifference
			]
		});
        $scope.disabled = false;
        $scope.counter = 500;
        $scope.showModalCorrect = false;
        $scope.showModalWrong = false;
        clearTimers();
        timers =[];
        match = matchService.get({}, function(){
            $scope.redArray = [6,7,8,9,10];
            $scope.blueArray = [1,2,3,4,5];
            if(match.toJSON().success){
                $scope.match = match.toJSON().match;
        		chart.axis.max({x: $scope.match.matchLength});
                setupTimers();
                mytimeout = $timeout($scope.onTimeout,3000);
            }
            else
            {
                alert('The rito api seems to be down! Looks like someone forgot to feed the engineers...')
            }
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
        $timeout.cancel(mytimeout);
        guessService.post($.param($scope.guess), function(u, putResponseHeaders){
            $scope.callBack = true;
            $scope.result = {questionCount: u.questionCount, score: u.score};
			$scope.overallScore = u.score;
			if ( !u.correct){
				$scope.overallScore = 0;
			}
			$scope.correct = u.correct;
            $scope.showModalCorrect = u.correct;
            $scope.showModalWrong = !$scope.showModalCorrect; 
        });
    }

    $scope.onTimeout = function(){
        $scope.counter--;
        if($scope.counter > 0){
            mytimeout = $timeout($scope.onTimeout,60);
        }
    }

    function setupTimers(){
            for (var i in  $scope.match.events) {
                if( $scope.match.events[i].eventType == 'CHAMPION_KILL'){
                    timers.push($timeout(deathCounter.bind(null,  $scope.match.events[i]), $scope.match.events[i].normalizedTimestamp +3000));
                }
                else if( $scope.match.events[i].eventType == 'GOLD_UPDATE')
                {
                    timers.push($timeout(goldCounter.bind(null,  $scope.match.events[i]),  $scope.match.events[i].normalizedTimestamp +3000));
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
			size: {
				height: 400,
				width: 650
			},
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
}]);