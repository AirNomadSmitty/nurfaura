<?php ?>
<script type="text/javascript" src="../../../node_modules/angular/angular.js"></script>
<script type="text/javascript" src="../AngularControllers/guess.controller.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.js" charset="utf-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.js"></script>
<link href= "../../../web/css/c3.css" rel="stylesheet" type="text/css">
<div ng-app="myApp" ng-controller="myCtrl">

First Name: <input type="text" ng-model="firstName"><br>
Last Name: <input type="text" ng-model="lastName"><br>
<br>
Full Name: {{firstName + " " + lastName}}

test: {{match.matchId}}

<!--<ul>-->
<!--    <li ng-repeat="player in match.participants"> {{player.championId}}-->
    
<!--    </li>-->
<!--    <p>{{player.picture}}</p>-->
<!--    <img ng-src="{{player.picture}}" />-->
<!--</ul>-->

<table style="width:10%; float:left; display:block" >
    <tr ng-repeat="player in playerPictureRed" >
    <td>    
        <img ng-src="{{player.picture}}" /> 
    </td>
    <td>
        {{player.currentKills}}/{{player.currentDeaths}}
    </td>
    
</table>

<table style="width: 10%; float:right; display:block">
    <tr ng-repeat="player in playerPictureBlue" >
    <td>
        {{player.currentKills}}/{{player.currentDeaths}}
    </td>
    <td>    
        <img ng-src="{{player.picture}}" style="float:right"/> 
    </td>

   
</table>

<div id="chart"></div>

<script>
    
        var chart = c3.generate({
    bindto: '#chart',
    data: {
      columns: [
        ['data1', 30, 200, 100, 400, 150, 250],
        ['data2', 50, 20, 10, 40, 15, 25]
      ]
    }
});
</script>
