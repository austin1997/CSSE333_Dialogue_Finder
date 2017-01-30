<?php
header("Content-type: text/html; charset=utf-8");
//假若我们本地的文件是一个名为xmlas.txt的文本
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
?>