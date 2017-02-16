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
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="float:right;">
					<input class="mdl-textfield__input" type="text" id="anime_p_input" name="animePName">
					<label class="mdl-textfield__label" for="anime_p_input">Company</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="float:right;">
					<input class="mdl-textfield__input" type="text" id="anime_d_input" name="animeDName">
					<label class="mdl-textfield__label" for="anime_d_input">Direcotr</label>
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
							$errors = '';
							$animeName = $_POST['animeName'];
							if	(empty($animeName))	$errors .= '<li>The Name of Anime is required</li>';
							if	(!empty($errors))	{	
								echo '<ul>' . $errors . '</ul>';
							}
						}
						if(!empty($animeName)){
							//echo 'Name is: '.$animeName.'<br>';
							$posts = sqlsrv_query($conn, "SELECT Name, Publish_date, Produced_by, Directed_by FROM Anime");
					//		echo 'posts are: '.$posts.'<br>';
							if (!($posts)) {
								echo 'The anime you searched is not available';
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
				<input class="mdl-textfield__input" type="text" id="anime_input" name="animeName">
				<label class="mdl-textfield__label" for="anime_input">Name of Anime</label>
				</div>
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
							$errors = '';
							$animeName = $_POST['animeName'];
							if	(empty($animeName))	$errors .= '<li>The Name of Anime is required</li>';
							if	(!empty($errors))	{	
								echo '<ul>' . $errors . '</ul>';
							}
						}
						if(!empty($animeName)){
							echo 'Name is: '.$animeName.'<br>';
							$posts = sqlsrv_query($conn, "SELECT Name, Publish_date, Produced_by, Directed_by FROM Anime");
					//		echo 'posts are: '.$posts.'<br>';
							if (!($posts)) {
								echo 'The anime you searched is not available';
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
	<section class="mdl-layout__tab-panel" id="fixed-tab-3">
		<div class="page-content">
			<form action="#fixed-tab-2" method="post">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="anime_input" name="animeName">
				<label class="mdl-textfield__label" for="anime_input">Name of Company</label>
				</div>
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
							$errors = '';
							$animeName = $_POST['animeName'];
							if	(empty($animeName))	$errors .= '<li>The Name of Anime is required</li>';
							if	(!empty($errors))	{	
								echo '<ul>' . $errors . '</ul>';
							}
						}
						if(!empty($animeName)){
							echo 'Name is: '.$animeName.'<br>';
							$posts = sqlsrv_query($conn, "SELECT Name, Publish_date, Produced_by, Directed_by FROM Anime WHERE Produced_by=N'$animeName'");
					//		echo 'posts are: '.$posts.'<br>';
							if (!($posts)) {
								echo 'The anime you searched is not available';
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