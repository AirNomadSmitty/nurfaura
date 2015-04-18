<?php ?>
<script type="text/javascript" src="js/app/guess.js"></script>
<script type="text/javascript" src="js/services/guess.services.js"></script>
<script type="text/javascript" src="js/controllers/guess.controller.js"></script>
<script type="text/javascript" src="js/directives/guess.directives.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.js" charset="utf-8"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.js"></script>

<link href= "/css/c3.css" rel="stylesheet" type="text/css">
<div ng-app="guess" ng-controller="guess.controller.guess">
	<div id = "overallScore">
		Overall Score: <span>0</span>
	</div>
	<div id="matchScore">
	Score: {{counter}}
	</div>

	<div class="matchGuessButtons">
		<button ng-click="guess.team = 'Blue'; postGuess(); disabled = true" ng-show= '!disabled' class='btn blue'>Blue side wins!</button>
		<button ng-click="guess.team = 'Red'; postGuess(); disabled = true" ng-show='!disabled' class='btn red'>Red side wins!</button>
		<button type="next" class="btn" ng-show="callBack" ng-click="runAGame()" class='btn'>Next Match!</button>
		<button type="next" class="btn" ng-show="!correct && !showModalWrong && result != null" ng-click="showModalWrong = true" class='btn'>Enter Username</button>
		
	</div>
	<div class="matchContainer">
	<table class="teamTable" >
		<tr ng-repeat="n in blueArray" >
		<td>
			<img ng-src="{{match.teams.blue.participants[n].championImg}}" />
		</td>
		<td class="champScores">
			<div highlight-on-change="{{match.teams.blue.participants[n].currentKills}}">
			{{match.teams.blue.participants[n].currentKills}}/{{match.teams.blue.participants[n].currentDeaths}}/{{match.teams.blue.participants[n].currentAssists}}
			</div>		
		</td>

	</table>
		<div id="graphContainer">
		<div id="goldGraph"></div>
		</div>


		<table class="teamTable">
		<tr ng-repeat="i in redArray" >
		<td class="champScores">
			<div highlight-on-change="{{match.teams.red.participants[i].currentKills}}">
				{{match.teams.red.participants[i].currentKills}}/{{match.teams.red.participants[i].currentDeaths}}/{{match.teams.red.participants[i].currentAssists}}
			</div>
		</td>
		<td>
			<img ng-src="{{match.teams.red.participants[i].championImg}}" style="float:right"/>
		</td>


	</table>
</div>


    
  <modal title="Correct!" visible="showModalCorrect">
    <form role="form">
    <button type="submit" class="btn btn-default" class="close" data-dismiss="modal" ng-click="runAGame()">Next Match!</button>
    <button type="submit" class="btn btn-default" class="close" data-dismiss="modal">Keep watching!</button>
    </form>
  </modal>
  
    <modal title="Incorrect!" visible="showModalWrong">
    <h4>But nice run! After {{result.questionCount}} games your final score is {{result.score}}</h4>
    <form role="form">
        <p>To save your score type in a username below</p>
      <div class="form-group">
        <label for="email">Username</label>
        <input ng-model="$parent.$parent.username" class="form-control" id="username" placeholder="Username" maxlength="20"/>
      </div>
    <button type="submit" class="btn btn-default" class="close" data-dismiss="modal" ng-click="runAGame()">Submit</button>
    <button type="submit" class="btn btn-default" class="close" data-dismiss="modal">Keep watching!</button>
    </form>
  </modal>

</div>
