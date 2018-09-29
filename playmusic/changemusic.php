<?php
header("Content-type: text/html; charset=utf-8");
$playingtxt="playingmusic.txt";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $file = fopen($playingtxt,"a");
    fwrite($file,'RodChong');
    fclose($file);
}
else {
    if(is_file($playingtxt)) {
        $file = fopen($playingtxt,"r");
        $text = fread($file,filesize($playingtxt));
        fclose($file);
        if(strpos($text,'RodChong') !== false) {
            $text = str_replace('RodChong','',$text);
            echo $text;
            unlink($playingtxt);
        }
    }
}
?>