<?php
header("Content-type: text/html; charset=utf-8");
$serverName = "137.112.104.37"; //数据库服务器地址
$uid = "zhaiz"; //数据库用户名
$pwd = "555888austin"; //数据库密�?
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn == false)
{
	echo "连接失败!</br>";
	die( print_r( sqlsrv_errors(), true));
}else{
	echo "连接成功!";
}
//$result = sqlsrv_query($conn, "select COUNT(*) AS Number from Dialogue");
//print_r($result);
//file_exists(iconv('utf-8','gbk','D:/test/中文啊.txt'));
$filedemo = iconv('utf-8','gbk',"D:\青春\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru [1920x1080 AVC FLAC]\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru 01 [1920x1080 AVC FLAC].ass");
$fpdemo = fopen($filedemo,"r");
if ($fpdemo){
	while(!strstr(fgets($fpdemo), "-----Sub-JP---"));
	while(!feof($fpdemo)) {
		$line = fgets($fpdemo) . "</br>";
		$firstComma = stripos($line, ",") + 1;
		$temp = substr($line, $firstComma);
		
		$secondComma = strpos($temp, ",") + 1;
		$temp = substr($line, $secondComma);
		$time = substr($line, $firstComma, $secondComma - 1);
		echo "Time: ".$time."</br>";
		
		$doubleComma = stripos($line, ",,") + 1;
		$dialogue = substr($line, $doubleComma);
		
		$doubleComma = stripos($dialogue, ",,") + 2;
		$dialogue = substr($dialogue, $doubleComma);
		echo "Dialogue: ".$dialogue."</br>";
		
}
	fclose($fpdemo);
}
$query = "";

$result = sqlsrv_query($conn, "select * from Episode");

?>