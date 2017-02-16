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
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" id="username" name="username">
          <label class="mdl-textfield__label" for="username">Username</label>
      </div>
      <br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="password" id="password" name="password">
          <label class="mdl-textfield__label" for="password">Password</label>
        </div>
      <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" id="login-btn">Login</button>
    </form>

    <?php
	    $username='';	
      $password='';
	    if	($_SERVER['REQUEST_METHOD']	== 'POST')	{
		    $errors = '';
		    $username = $_POST['username'];
        $password = $_POST['password'];
		    if	(empty($username))	$errors .= '<p style="padding-top:20px;text-align:center;">Username	is	required</p>';
        if	(empty($password))	$errors .= '<p style="text-align:center;">Password	is	required</p>';
		    if	(!empty($errors))	{	
			    echo $errors;
		    }
	    }
      $serverName = "137.112.104.37";
      $uid = $username;
      $pwd = $password;
      $connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ", "CharacterSet"=>"UTF-8");
      $conn = sqlsrv_connect( $serverName, $connectionInfo);
	    if(!empty($username) && !empty($password)){
        if($conn==true){
          setcookie('uid',$uid);
          setcookie('pwd',$pwd);
          echo '<form action="/testEchoTable.php">
                  <input type="submit" id="go-btn" value="Verified! Visit our website!"/>
                </form>';
        }else{
          echo '<p style="padding-top:20px;text-align:center;">Invalid username and/or password.</p>';
        }
	    }else{
		    echo '<p style="padding-top:50px;text-align:center;">Please use the visitor account<br>Username: user<br>Password: user</p>';
	    }
    ?>

    

  </body>
</html>