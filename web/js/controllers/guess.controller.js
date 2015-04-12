var app = angular.module('myApp', ['ngResource', 'myApp.services']);
app.controller('myCtrl', function($scope, $timeout, Match, Guess) {
    $scope.guess={score:0, team:''};
    var goldDifference = ['Gold Difference'];
    $scope.postGuess = function(){
        $scope.guess.score = $scope.coutner;
        $timeout.cancel(mytimeout);
        Guess.save($scope.guess);
    }
    $scope.disabled = false;
    $scope.counter = 30;
    $scope.onTimeout = function(){
        $scope.counter--;
        if($scope.counter > 0){
            mytimeout = $timeout($scope.onTimeout,1000);
        }
    }
    
    

    
    
    
    function setupTimers(){
            for (var i in match.events) {
                if(match.events[i].eventType == 'CHAMPION_KILL'){
                    $timeout(deathCounter.bind(null, match.events[i]),match.events[i].timestamp);
                }
                else if(match.events[i].eventType == 'GOLD_UPDATE')
                {
                    var time = match.events[i].timestamp;
                    $timeout(goldCounter.bind(null, match.events[i]), match.events[i].timestamp);
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
        chart.load({
            columns:[
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
    
   var chart = c3.generate({
        bindto: '#chart',
        data: {
            columns: [
                goldDifference,
            ]
        },
        axis: {
          x: {
            tick: {
              count: 0
            }
          }
        }
    });
         
    
    
    
    
    
    
    
    
    
    var match = Match.get({}, function(){
        $scope.match = match.toJSON();

        
        setupTimers();
        var mytimeout = $timeout($scope.onTimeout,1000);
    })    
        
        // $scope.playerPictureRed = [];
        // $scope.playerPictureBlue = [];
        // for (var x in $scope.match.participants) {
        //     debugger
        //     var id = $scope.match.participants[x].championId;
        //     var player = {id: id, picture: $scope.getPicture(id), currentKills: 0, currentDeaths: 0};
        //     if($scope.match.participants[x].teamId == 100 ){
        //         $scope.playerPictureRed.push(player);
        //     }
        //     else{
        //       $scope.playerPictureBlue.push(player);  
        //     }
        //     // $scope.match.participants[x];
        //     // player.picture = $scope.getPicture;
        // }
        
        // function randomTimeline(){
        //     var timeline =[]; 
        //     var playerDuple = randomPlayer();
        //     timeline.push({player: playerDuple.player, playerKilled:playerDuple.playerKilled, time:Math.floor(Math.random() * 20)});
        //     var events = Math.floor(Math.random() * 50);
        //     for( var i = 0; i <events; i++ )
        //     {
        //         var time = Math.floor(Math.random() * 1000 + timeline[i].time );
        //         playerDuple = randomPlayer();
        //         timeline.push({player: playerDuple.player, playerKilled:playerDuple.playerKilled, time:time});
        //     }
            
        //     return timeline;
        // };
        
        
        // function randomPlayer(){
        //     var team = Math.random();
        //     var player;
        //     var playerKilled;
        //     if (team > .5)
        //     {
        //         player = $scope.playerPictureRed[Math.floor((Math.random() * 5))].id;
        //         playerKilled = $scope.playerPictureBlue[Math.floor((Math.random() * 5))].id;
        //     }
        //     else
        //     {
        //         player = $scope.playerPictureBlue[Math.floor((Math.random() * 5))].id;
        //         playerKilled = $scope.playerPictureRed[Math.floor((Math.random() * 5))].id;
        //     }
        //     return {player:player, playerKilled:playerKilled};
        // }
        

        


    
});