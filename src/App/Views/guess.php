<?php ?>
<script type="text/javascript" src="../../../node_modules/angular/angular.js"></script>
<script type="text/javascript" src="../AngularControllers/guess.controller.js"></script>

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

<table style="width:25%">
    <tr ng-repeat="player in playerPictureRed" >
    <td>    
        <img ng-src="{{player.picture}}" /> 
    </td>
    <td>
        {{player.currentKills}}/{{player.currentDeaths}}
    </td>
    
</table>

<table style="width: 25%" style="float:right; display:block">
    <tr ng-repeat="player in playerPictureBlue" >
    <td>
        {{player.currentKills}}/{{player.currentDeaths}}
    </td>
    <td>    
        <img ng-src="{{player.picture}}" /> 
    </td>

   
</table>

