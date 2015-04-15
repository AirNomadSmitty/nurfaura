<?php ?>
<script type="text/javascript" src="/node_modules/angular/angular.js"></script>
<script type="text/javascript" src="/node_modules/angular-resource/angular-resource.js"></script>
<script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script type="text/javascript" src="/js/directives/guess.directives.js"></script>
<script type="text/javascript" src="/js/services/guess.services.js"></script>
<script type="text/javascript" src="/js/controllers/guess.controller.js"></script>
<script type="text/javascript" src="/js/directives/guess.directives.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.js" charset="utf-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.js"></script>
<link href= "/node_modules/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href= "/css/c3.css" rel="stylesheet" type="text/css">
<div ng-app="myApp" ng-controller="myCtrl">
{{counter}} 

<div id="goldGraph"></div>
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



<button ng-click="guess.team = 'Blue'; postGuess(); disabled = true" ng-disabled= 'disabled' class='btn'>Blue side wins!</button>
<button ng-click="guess.team = 'Red'; postGuess(); disabled = true" ng-disabled='disabled' class='btn'>Red side wins!</button>


    
  <modal title="Correct!" visible="showModalCorrect">
    <form role="form">
    <button type="submit" class="btn btn-default" class="close" data-dismiss="modal" ng-click="runAGame()">Next Match!</button>
    </form>
  </modal>
  
    <modal title="Incorrect!" visible="showModalWrong">
    <h4>But nice run! After {{result.questionCount}} games your final score is {{result.score}}</h4>
    <form role="form">
        <p>To save your score type in a username below</p>
      <div class="form-group">
        <label for="email">Username</label>
        <input ng-model="username" class="form-control" id="username" placeholder="Username" />
      </div>
    <button type="submit" class="btn btn-default" class="close" data-dismiss="modal" ng-click="runAGame()">Submit</button>
    </form>
  </modal>

</div>