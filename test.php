<?php
header("Content-type: text/html; charset=gb2312");
$serverName = "137.112.104.37"; //���ݿ��������ַ
$uid = "zhaiz"; //���ݿ��û���
$pwd = "555888austin"; //���ݿ�����
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn == false)
{
	echo "����ʧ�ܣ�<br/>";
	die( print_r( sqlsrv_errors(), true));
}else{
	echo "���ӳɹ�!";
}
$query = sqlsrv_query($conn, "select * from Episode");
while($row = sqlsrv_fetch_array($query))
{
  print_r($row);
}
?>