<?php ?>
<div class="indexWrapper">
<div class="main-body">
	<p>
		Think you can pick the winner of a game while it's happening? With URF Pick'em, we animate a gold graph and update champion KDAs as the game is progressing. The earlier you pick the winner correctly, the more points you get. Keep picking matches until you get one wrong and then submit to the leaderboards!
	</p>
<a href="/guess" class="btn green">Start Picking!</a>
</div>
<div class="sidebar">
	<div class="leaderboard">
		<h3>Top 10</h3>
		<table cellspacing="0">
			<?php foreach ($this->topTen as $score) { ?>
			<tr>
			<td class="userName"><?= $score->getUsername()?></td>
			<td class="score"><?= $score->getScore()?></td>
			</tr>
			<?php } ?>
		</table>
	</div>

	<div class="leaderboard">
		<h3>Most Recent</h3>
		<table cellspacing="0">
			<?php foreach ($this->recent as $score) { ?>
				<tr>
					<td class="userName"><?= $score->getUsername()?></td>
					<td class="score"><?= $score->getScore()?></td>
				</tr>
			<?php } ?>
		</table>
	</div>

</div>
<div class="clear"></div>
</div>

