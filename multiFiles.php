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


/////////////////////////////////////////////////////
for ($i = 1; $i <= 2; $i+=1){
	$query = sqlsrv_query($conn, "select COUNT(*) AS Number from Dialogue") ;
	while($row = sqlsrv_fetch_array($query))
	{
//	printf("%s\n",$row[3]);
//	print_r($row);
	printf("startID: %d\n", $row[0]);
	$startID = $row[0];
	}
	
	set_dialogue($i, $startID, $conn);
	update_dialogue($i, $conn);
}




function set_dialogue ($episode_num, $startID, $conn){
	echo "开始上传日文字幕"."</br>";
//file_exists(iconv('utf-8','gbk','D:/test/中文啊.txt'));
	echo "Episode: $episode_num"."</br>";
$filedemo = iconv('utf-8','gbk',"D:\青春\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru [1920x1080 AVC FLAC]\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru 0$episode_num [1920x1080 AVC FLAC].ass");
$fpdemo = fopen($filedemo,"r");
if ($fpdemo){
	while(!strstr(fgets($fpdemo), "-----Sub-JP---"));
	while(!feof($fpdemo)) {
		$line = fgets($fpdemo) . "</br>";
		if(strstr($line, "---Sub-CN----")) break;
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
//		$dialogue = utf8_str_to_unicode($dialogue);
		$temp = $episode_num - 1;
		$q = "INSERT INTO Dialogue VALUES ( $startID, $temp, '$time', N'$dialogue', NULL)";
		$startID += 1;
		$query = sqlsrv_query($conn, $q) or die( print_r( sqlsrv_errors(), true));
//		$query = sqlsrv_query($conn, "INSERT INTO Dialogue VALUES ( 0, 1, '0:00:02.22', N'"."$temp"."', NULL)");
		while($row = sqlsrv_fetch_array($query))
		{
			print_r($row);
		}
//		print_r( sqlsrv_errors());
	}
	fclose($fpdemo);
	}
	
}

function update_dialogue($episode_num, $conn){echo "开始上传"."</br>";
//file_exists(iconv('utf-8','gbk','D:/test/中文啊.txt'));
$filedemo = iconv('utf-8','gbk',"D:\青春\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru [1920x1080 AVC FLAC]\[Kamigami] Yahari Ore no Seishun Love Come wa Machigatteiru 0$episode_num [1920x1080 AVC FLAC].ass");
$fpdemo = fopen($filedemo,"r");
if ($fpdemo){
	while(!strstr(fgets($fpdemo), "---Sub-CN----"));
	while(!feof($fpdemo)) {
		$line = fgets($fpdemo) . "</br>";
		if(strstr($line, "------Title----")) break;
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
		$temp = $episode_num - 1;
		$q = "UPDATE Dialogue SET Content_CHN = N'$dialogue' WHERE Time = '$time' AND Episode_id = $temp";
//		$q = "UPDATE Dialogue SET Content_CHN = N'hello' WHERE Time = '0:00:02.22'"
//		echo $q."</br>";
		$query = sqlsrv_query($conn, $q) or die( print_r( sqlsrv_errors(), true));;
//		$query = sqlsrv_query($conn, "UPDATE Dialogue SET Content_CHN = N'hello' WHERE Time = '0:00:02.22'");
		while($row = sqlsrv_fetch_array($query))
		{
			print_r($row);
		}
//		print_r( sqlsrv_errors());
	}
	fclose($fpdemo);
	}
}




?>