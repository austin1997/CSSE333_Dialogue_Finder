<!DOCTYPE	html>
<html>
<?php
//	Open	a	connection	to	the	database	
//	(display	an	error	if	the	connection	fails)	
header("Content-type: text/html; charset=utf-8");
$serverName = "137.112.104.37";
$uid = $_COOKIE['uid'];
$pwd = $_COOKIE['pwd'];
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ", "CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Dialog Finder</title>
<!-- mdl -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<style>
    .mdl-data-table {
        width:100%;
    }
    .mdl-textfield {
        margin: 0 auto;
		text-align: center;
    }
</style>
</head>

<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
            mdl-layout--fixed-tabs">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <span class="mdl-layout-title">Dialog Finder</span>
        </div>
        <!-- Tabs -->
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
            <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Anime</a>
            <a href="#fixed-tab-2" class="mdl-layout__tab">Episode</a>
            <a href="#fixed-tab-3" class="mdl-layout__tab">Dialogue</a>
            <a href="#fixed-tab-4" class="mdl-layout__tab">Company</a>
        </div>
    </header>
    <main class="mdl-layout__content">
        <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
            <div class="page-content">
				<form action="" method="post">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="float:right;">
					<input class="mdl-textfield__input" type="text" id="anime_input" name="animeName">
					<label class="mdl-textfield__label" for="anime_input">Anime Name</label>
					</div>
				</form>
				<form action="/index - Copy.php" style="float:left;padding-top:20px;padding-left:20px;">
					<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Modify</button>
					<?php
						setcookie('changeTable','Anime');
					?>
				</form> 

			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						<th>Date Released</th>
						<th>Producer</th>
						<th>Director</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$animeName='';	
						if	($_SERVER['REQUEST_METHOD']	== 'POST')	{
							if (isset($_POST['animeName'])) {
								$animeName = $_POST['animeName'];
							}
						}
						if(!empty($animeName)){
							$posts = sqlsrv_query($conn, "SELECT Name, Publish_date, Produced_by, Directed_by FROM Anime WHERE Name = N'$animeName'");
							if (!($posts)) {
								echo 'The anime you searched is not available';
							}else{
								while ($row = sqlsrv_fetch_array($posts))	{
									echo '<tr><td class="mdl-data-table__cell--non-numeric">'.$row[0].'</td><td>'.date_format($row[1], 'd/m/y').'</td><td>'.$row[2].'</td><td>'.$row[3].'</td></tr>';
								}
							}
						}else{
							$posts = sqlsrv_query($conn, "SELECT Name, Publish_date, Produced_by, Directed_by FROM Anime");
							if (!($posts)) {
								
							}else{
								while ($row = sqlsrv_fetch_array($posts))	{
									echo '<tr><td class="mdl-data-table__cell--non-numeric">'.$row[0].'</td><td>'.date_format($row[1], 'd/m/y').'</td><td>'.$row[2].'</td><td>'.$row[3].'</td></tr>';
								}
							}
						}
						?>
				</tbody>
			</table>
				
			</div>
		</section>
	<section class="mdl-layout__tab-panel" id="fixed-tab-2">
		<div class="page-content">
			<form action="" method="post">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="episode_input" name="fromAnimeName">
				<label class="mdl-textfield__label" for="episode_input">From which Anime</label>
				</div>
			</form>

			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">UniqueID</th>
						<th>Anime</th>
						<th>Number</th>
						<th>Summary</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$fromAnimeName='';	
						if	($_SERVER['REQUEST_METHOD']	== 'POST')	{
							$fromAnimeName = $_POST['fromAnimeName'];
						}
						if(!empty($fromAnimeName)){
							$posts = sqlsrv_query($conn, "SELECT Id, from_Anime, Number, Summary FROM Episode WHERE from_Anime=N'$fromAnimeName'");
					//		echo 'posts are: '.$posts.'<br>';
							if (!($posts)) {
								echo 'The anime you searched is not available';
							}else{
								while ($row = sqlsrv_fetch_array($posts))	{
									echo '<tr><td class="mdl-data-table__cell--non-numeric">'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td></tr>';
								}
							}
						}
						?>
				</tbody>
			</table>
		</div>
	</section>
	<section class="mdl-layout__tab-panel" id="fixed-tab-3">
		<div class="page-content">
			<form action="" method="post">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" id="dialog_input1" name="dialogEpisode">
					<label class="mdl-textfield__label" for="dialog_input1">Episode Unique ID</label>
				</div>
			</form>

			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Time</th>
						<th>Content_CHN</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$dialogEpisode='0';
						//$dialogKW='';	
						if	($_SERVER['REQUEST_METHOD']	== 'POST')	{
							$dialogEpisode = $_POST['dialogEpisode'];
							//$dialogKW=$_POST['dialogKW'];
						}
						if(!empty($dialogEpisode)){
							$posts = sqlsrv_query($conn, "SELECT Content_JP, Content_CHN FROM Dialogue WHERE Episode_id = 0");
							echo 'posts are: '.$posts.'<br>';
							if (!($posts)) {
								echo 'error';
							}else{
								while ($row = sqlsrv_fetch_array($posts))	{
									echo '<tr><td class="mdl-data-table__cell--non-numeric">'.$row[0].'</td><td>'.$row[1].'</td></tr>';
								}
							}
						}
						?>
				</tbody>
			</table>
		</div>
	</section>
	<section class="mdl-layout__tab-panel" id="fixed-tab-4">
		<div class="page-content">
			<form action="" method="post">
				<div class="search mdl-textfield mdl-js-textfield mdl-textfield--expandable">
					<label class="mdl-button mdl-js-button mdl-button--icon" for="sample6">
						<i class="material-icons">search</i>
					</label>
					<div class="mdl-textfield__expandable-holder">
						<input class="mdl-textfield__input" type="text" id="sample6">
						<label class="mdl-textfield__label" for="sample-expandable">Expandable Input</label>
					</div>
				</div>
			</form>

			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						<th>Birthday</th>
						<th>Gender</th>
						<th>Info</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">A director</td>
						<td>01/01/2000</td>
						<td>M</td>
						<td>A's info</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
</main>
</div>
</body>
</html>