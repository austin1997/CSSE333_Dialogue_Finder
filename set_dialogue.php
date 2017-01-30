<?php
header("Content-type: text/html; charset=utf-8");
$serverName = "137.112.104.37"; //数据库服务器地址
$uid = "zhaiz"; //数据库用户名
$pwd = "555888austin"; //数据库密�?
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
		$q = "INSERT INTO Dialogue VALUES ( $startID, 1, '$time', N'$dialogue', NULL)";
		$startID += 1;
		$query = sqlsrv_query($conn, $q);
//		$query = sqlsrv_query($conn, "INSERT INTO Dialogue VALUES ( 0, 1, '0:00:02.22', N'"."$temp"."', NULL)");
		while($row = sqlsrv_fetch_array($query))
		{
			print_r($row);
		}
//		print_r( sqlsrv_errors());
}
	fclose($fpdemo);
}


/**
 * utf8字符转换成Unicode字符
 * @param [type] $utf8_str Utf-8字符
 * @return [type]      Unicode字符
 */
function utf8_str_to_unicode($utf8_str) {
  $unicode = 0;
  $unicode = (ord($utf8_str[0]) & 0x1F) << 12;
  $unicode |= (ord($utf8_str[1]) & 0x3F) << 6;
  $unicode |= (ord($utf8_str[2]) & 0x3F);
  return dechex($unicode);
}

/**
 * Unicode字符转换成utf8字符
 * @param [type] $unicode_str Unicode字符
 * @return [type]       Utf-8字符
 */
function unicode_to_utf8($unicode_str) {
  $utf8_str = '';
  $code = intval(hexdec($unicode_str));
  //这里注意转换出来的code一定得是整形，这样才会正确的按位操作
  $ord_1 = decbin(0xe0 | ($code >> 12));
  $ord_2 = decbin(0x80 | (($code >> 6) & 0x3f));
  $ord_3 = decbin(0x80 | ($code & 0x3f));
  $utf8_str = chr(bindec($ord_1)) . chr(bindec($ord_2)) . chr(bindec($ord_3));
  return $utf8_str;
}

function str_utf8_str_to_unicode($utf8_str){
	$out="";
	for($i=0;$i<strlen($utf8_str);$i++){
		$out= $out.utf8_str_to_unicode(substr($utf8_str,$i,1)); //将单个字符
	}
	return $out;
}

function unicode_encode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {   //两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}

//将UNICODE编码后的内容进行解码
function unicode_decode($name)
{
    //转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}




?>