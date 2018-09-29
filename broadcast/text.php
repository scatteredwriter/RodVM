<?php
header("Content-type: text/html; charset=utf-8");
$text="";
$txt="text.txt";
$histxt="history.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $text = $_POST["text"];
  echo "RodChong的Raspberry Pi正在说：".$text;
  $file=fopen($txt,"w");
  fwrite($file,$text);
  fclose($file);
  $file=fopen($histxt,"a");
  fwrite($file,$text."\n");
  fclose($file);
}
else{
    if(is_file($txt)){
      $file=fopen($txt,"r");
      $text=fread($file,filesize($txt));
      echo $text;
      fclose($file);
      unlink($txt);  
    }
}

?>