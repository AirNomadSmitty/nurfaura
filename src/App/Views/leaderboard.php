<?php ?>
<script type="text/javascript" src="node_modules/angular-smart-table/dist/smart-table.js"></script>
<script type="text/javascript" src="js/app/leaderboard.js"></script>
<script type="text/javascript" src="js/services/leaderboard.services.js"></script>
<script type="text/javascript" src="js/controllers/leaderboard.controller.js"></script>

<h3>Leader Board</h3>
<div ng-app='leaderboard' ng-controller='leaderboard.controller.grid'>
    <table st-table="rows" st-safe-src="players" class="table table-striped">
    	<thead>
    	<tr>
    		<th st-sort="username">Username</th>
    		<th st-sort="score">Score</th>
    	</tr>
    	<tr>
    		<th>
    			<input st-search="" placeholder="Search for Username" class="input-sm form-control" type="search"/>
    		</th>
    	</tr>
    	</thead>
    	<tbody>
    	<tr ng-repeat="row in rows">
    		<td>{{row.username}}</td>
    		<td>{{row.score}}</td>
    	</tr>
    	</tbody>
    	<tfoot>
    		<tr>
    			<td colspan="5" class="text-center">
    				<div st-pagination="" st-items-by-page="30" st-displayed-pages="7"></div>
    			</td>
    		</tr>
    	</tfoot>
    </table>
</div>