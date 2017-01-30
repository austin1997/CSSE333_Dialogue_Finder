<?php
header("Content-type: text/html; charset=utf-8");
$serverName = "137.112.104.37"; //数据库服务器地址
$uid = "zhaiz"; //数据库用户名
$pwd = "555888austin"; //数据库密砿
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn == false)
{
	echo "连接失败!</br>";
	die( print_r( sqlsrv_errors(), true));
}else{
	echo "连接成功!"."</br>";
}
$query = sqlsrv_query($conn, "select *  from Dialogue");
while($row = sqlsrv_fetch_array($query))
{
//	printf("%s\n",$row[3]);
	echo unicode_to_utf8($row[3])."</br>";
//	print_r($row);
	
}
echo "开始下载"."</br>";



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



?>