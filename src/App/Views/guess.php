<?php ?>
<script type="text/javascript" src="../node_modules/angular/angular.js"></script>
<script type="text/javascript" src="../node_modules/angular-resource/angular-resource.js"></script>
<script type="text/javascript" src="/web/js/services/guess.services.js"></script>
<script type="text/javascript" src="/web/js/controllers/guess.controller.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.js" charset="utf-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.js"></script>
<link href= "../../../web/css/c3.css" rel="stylesheet" type="text/css">
<div ng-app="myApp" ng-controller="myCtrl">
{{counter}} {{match.teams.blue.winner}}
<table style="width:10%; float:left; display:block" >
    <tr ng-repeat="n in [1,2,3,4,5]" >
    <td>    
        <img ng-src="{{match.teams.blue.participants[n].championImg}}" /> 
    </td>
    <td>
        {{match.teams.blue.participants[n].currentKills}}/{{match.teams.blue.participants[n].currentDeaths}}/{{match.teams.blue.participants[n].currentAssists}}
    </td>
    
</table>

<table style="width: 10%; float:right; display:block">
    <tr ng-repeat="i in [6,7,8,9,10]" >
    <td>
        {{match.teams.red.participants[i].currentKills}}/{{match.teams.red.participants[i].currentDeaths}}/{{match.teams.red.participants[i].currentAssists}}
    </td>
    <td>    
        <img ng-src="{{match.teams.red.participants[i].championImg}}" style="float:right"/> 
    </td>

   
</table>

<div id="chart"></div>

<script>
    

</script>
