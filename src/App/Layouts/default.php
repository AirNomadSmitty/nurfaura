<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>URF Pick'em</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" lang="en" content="Picking the winner of URF games">
	<meta name="author" content="ADD AUTHOR INFORMATION">
	<meta name="robots" content="index">

	<link rel="stylesheet" href="/css/main.css">
</head>
<body>
		<div class="header">
			<div class="container">
				<h1 class="header-heading">URF Pick'em</h1>
			</div>
		</div>
		<div class="nav-bar">
			<div class="container">
				<ul class="nav">
					<li><a href="/">Home</a></li>
					<li><a href="/guess">Pick'em</a></li>
					<li><a href="/leaderboards">Leaderboards</a></li>
				</ul>
			</div>
		</div>
		<div class="wrapper">
			<div class="content">
				<div class="container">
					<div class="main">
						<?= $this->getContent(); ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				&copy; Copyright 2015
			</div>
		</div>
</body>
</html>
