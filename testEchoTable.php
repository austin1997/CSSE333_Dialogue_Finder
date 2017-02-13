<!DOCTYPE	html>
<html>
<?php
//	Open	a	connection	to	the	database	
//	(display	an	error	if	the	connection	fails)	
header("Content-type: text/html; charset=utf-8");
$serverName = "137.112.104.37"; //数据库服务器地址
$uid = "zhaiz"; //数据库用户名
$pwd = "555888austin"; //数据库密砿
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ", "CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
<title>Welcome!</title>
</head>
<body>
<form action="" method="post">
				<label for="id">ID</label><br/>
				<input type="text" name="id"/><br/>
				<input type="submit" value="Search"/>
</form>
<table class="table table-hover">
			<thead>
			<tr>
				<th>Posts table</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>Name</td>
				<td>ID</td>
				<td>Body</td>
			</tr>
			
			<?php
	$id='0';	
	if	($_SERVER['REQUEST_METHOD']	== 'POST')	{
		$errors = '';
		$id = $_POST['id'];
		if	(empty($id))	$errors .= '<li>ID	is	required</li>';
		if	(!empty($errors))	{	
			echo '<ul>' . $errors . '</ul>';
		}
	}
	if(!empty($id)){
//		echo 'id is: '.$id.'<br>';
		$posts = sqlsrv_query($conn, "SELECT Id, Episode_id, Content_CHN FROM Dialogue WHERE Id = $id");
//		echo 'posts are: '.$posts.'<br>';
		if (!($posts)) {
			echo 'The anime you searched is not available';
		}else{
			while ($row = sqlsrv_fetch_array($posts))	{
				echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
			}
		}
	}else{
		echo 'Please search for a anime.';
	}
		
?>
			
			</tbody>
	</table>


</body>
</html>