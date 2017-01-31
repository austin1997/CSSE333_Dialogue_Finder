<?php
header("Content-type: text/html; charset=utf-8");
$serverName = "137.112.104.37"; //数据库服务器地址
$uid = "zhaiz"; //数据库用户名
$pwd = "555888austin"; //数据库密砿
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ", "CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn == false)
{
	echo "连接失败!</br>";
	die( print_r( sqlsrv_errors(), true));
}else{
	echo "连接成功!";
}
$query = sqlsrv_query($conn, "select COUNT(*) AS Number from Dialogue");
while($row = sqlsrv_fetch_array($query))
{
//	printf("%s\n",$row[3]);
//	print_r($row);
	printf("startID: %d\n", $row[0]);
	$startID = $row[0];
}
echo "开始上传"."</br>";
//file_exists(iconv('utf-8','gbk','D:/test/中文啊.txt'));
$filedemo = iconv('utf-8','gbk',"D:\青春\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru [1920x1080 AVC FLAC]\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru 01 [1920x1080 AVC FLAC].ass");
$fpdemo = fopen($filedemo,"r");
if ($fpdemo){
	while(!strstr(fgets($fpdemo), "---Sub-CN----"));
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
		//$str = str_replace(array("/r/n", "/r", "/n"), '', $str);
		$dialogue = str_replace(array("/r/n", "/r", "/n","</br>","<br>"),'',$dialogue);
		echo "Dialogue: ".$dialogue."</br>";
		/////////////////////////////////////////////////////////////////////////////
		$q = "UPDATE Dialogue SET Content_CHN = N'$dialogue' WHERE Time = '$time'";
//		$q = "UPDATE Dialogue SET Content_CHN = N'hello' WHERE Time = '0:00:02.22'"
		echo $q."</br>";
		$query = sqlsrv_query($conn, $q);
//		$query = sqlsrv_query($conn, "UPDATE Dialogue SET Content_CHN = N'hello' WHERE Time = '0:00:02.22'");
		while($row = sqlsrv_fetch_array($query))
		{
			print_r($row);
		}
//		print_r( sqlsrv_errors());
	}
	fclose($fpdemo);
}
?>