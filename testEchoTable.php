<!DOCTYPE	html>
<html>
<?php
//	Open	a	connection	to	the	database	
//	(display	an	error	if	the	connection	fails)	
$conn = mysqli_connect('localhost',	'root',	'')	or die(mysqli_error());	
mysqli_select_db($conn,	'rhitter')	or die(mysqli_error());	
?>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
<title>Welcome!</title>
</head>
<body>
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
			</tbody>
	</table>
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
		echo 'id is: '.$id.'<br>';
		$posts = mysqli_query($conn, "SELECT user_id, post_body". "FROM posts". "WHERE user_id=".$id."LIMIT 2");
		echo 'posts are: '.$posts.'<br>';
		if (!($posts)) {
			echo 'The anime you searched is not available';
		}else{
			while ($row = mysqli_fetch_array($posts))	{
				echo '<table class="table table-hover"><tbody><tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr></tbody></table>';
			}
		}
	}else{
		echo 'Please search for a anime.';
	}
		
?>
<form action="" method="post">
				<label for="id">ID</label><br/>
				<input type="text" name="id"/><br/>
				<input type="submit" value="Search"/>
</form>
</body>
</html>