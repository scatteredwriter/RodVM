<?php
header("Content-type: text/html; charset=utf-8");
$txt="music.txt";
$playingtxt='playingmusic.txt';
$music='';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!empty($_GET['songmid'])) {
        $songmid = $_GET['songmid'];
        $music = shell_exec('python3 music.py '.$_GET['songmid']);
        echo $music;
        $file = fopen($txt,"w");
        fwrite($file,$music);
        fclose($file);
    }
    elseif(!empty($_GET['type'])) {
        $type = $_GET['type'];
        if($type == 'over' && is_file($playingtxt))
            unlink($playingtxt);
    }
}
else{
    if(is_file($txt)){
      $file = fopen($txt,"r");
      $music = fread($file,filesize($txt));
      echo $music;
      fclose($file);
      unlink($txt);
      $file = fopen($playingtxt,"w");
      fwrite($file,substr(trim($music),0,strpos($music,"mp3")));
      fclose($file);
    }
}
?>
