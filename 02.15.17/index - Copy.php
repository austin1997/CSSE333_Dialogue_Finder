<!DOCTYPE	html>
<html>
<?php
//	Open	a	connection	to	the	database	
//	(display	an	error	if	the	connection	fails)	
header("Content-type: text/html; charset=utf-8");
?>
  <head>
    <title>Dialog Finder</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer="" src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <style>
      h1,h4 {
      text-align: center;
      }
      .mdl-textfield {
      display:block;
      margin:0 auto;
      }
      #login-btn{
      display:block;
      margin:0 auto;
      }
      #go-btn{
      display:block;
      margin:0 auto;
      margin-top:50px;
      text-align:center;
      }
      body{
      background: #A0A0A0
      }
    </style>
  </head>
  <body>
    <h1>Dialog Finder</h1>
    <h4>Developed by Yizhi Feng, Zhihong Zhai</h4>
	<form action="" method="post">
	<?php
		$type = $_COOKIE['changeTable'];
	  if ($type == 'Anime') {
		  echo '
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="Name" name="Name">
					<label class="mdl-textfield__label" for="Name">Name</label>
			</div>
			<br>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="Publish_date" name="Publish_date">
					<label class="mdl-textfield__label" for="Publish_date">Publish date</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="Summary" name="Summary">
					<label class="mdl-textfield__label" for="Summary">Summary</label>
			</div>
			<br>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="Produced_by" name="Produced_by">
					<label class="mdl-textfield__label" for="Produced_by">Produced by</label>
			</div>
			<br>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="Directed_by" name="Directed_by">
					<label class="mdl-textfield__label" for="Name">Directed by</label>
			</div>
			<br>
			';
		  
	  }
		
	
	
	?>
		<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" name = "insert" id="insert-btn">INSERT</button>
		<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" name = "update" id="update-btn">UPDATE</button>
		<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" name = "delete" id="delete-btn">DELETE</button>
    </form>

    <?php
      $serverName = "137.112.104.37";
      $uid = $_COOKIE['uid'];
      $pwd = $_COOKIE['pwd'];
	  echo "$uid </br>";
      $connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ", "CharacterSet"=>"UTF-8");
      $conn = sqlsrv_connect( $serverName, $connectionInfo);
	  $Name='';	
      $Publish_date = '';
	  $Summary = '';
	  $Produced_by = '';
	  $Directed_by = '';
	  if ($_SERVER['REQUEST_METHOD'] == 'POST')	{
		$errors = '';
		$Name = $_POST['Name'];
        $Publish_date = $_POST['Publish_date'];
		$Summary = $_POST['Summary'];
		$Produced_by = $_POST['Produced_by'];
		$Directed_by = $_POST['Directed_by'];
		if (empty($Name))	$errors .= '<p style="padding-top:20px;text-align:center;">Name	is	required</p>';
//        if (empty($password))	$errors .= '<p style="text-align:center;">Password	is	required</p>';
		    if	(!empty($errors))	{	
			    echo $errors;
		    }
	    }
	    if(!empty($Name)){
			if($conn==true){
				$q = "";
			if (isset($_POST['insert'])){
				$q = "INSERT INTO Anime
					  VALUES ('$Name', '$Publish_date', '$Summary', N'$Produced_by', N'$Directed_by')";
			}else if(isset($_POST['update'])){
				$q = "UPDATE Anime
					  SET Publish_date = '$Publish_date', Summary = '$Summary', Produced_by = N'$Produced_by', Directed_by = N'$Directed_by'
					  WHERE Name = N'$Name'";
				
			}else if(isset($_POST['delete'])){
				$q = "DELETE FROM Anime WHERE Name = N'$Name'";
				
			}
				echo "$q </br>";
				$query = sqlsrv_query($conn, $q) or die(  print_r( sqlsrv_errors(), true));
//		$query = sqlsrv_query($conn, "INSERT INTO Dialogue VALUES ( 0, 1, '0:00:02.22', N'"."$temp"."', NULL)");
//				while($row = sqlsrv_fetch_array($query))
//				{
				//	print_r($row);
//				}
			}else{
				echo '<p style="padding-top:20px;text-align:center;">Invalid username and/or password.</p>';
			}
		}else{
		    echo '<p style="padding-top:50px;text-align:center;">Please use the visitor account<br>Username: user<br>Password: user</p>';
	    }
    ?>

    

  </body>
</html>