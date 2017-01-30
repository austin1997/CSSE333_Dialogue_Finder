<!DOCTYPE HTML >
<html>
<head>
<p>hello</br></p>
</head>
<body>
<p>
<?php
header("Content-type: text/html; charset=gb2312");
$serverName = "137.112.104.37"; //数据库服务器地址
$uid = "zhaiz"; //数据库用户名
$pwd = "555888austin"; //数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn == false)
{
	echo "连接失败！<br/>";
	die( print_r( sqlsrv_errors(), true));
}else{
	echo "连接成功!";
}
$query = sqlsrv_query($conn, "select * from Episode");
while($row = sqlsrv_fetch_array($query))
{
//	printf("%s\n",$row[3]);
	print_r($row);
}
?>

</p>


</body>

</html>