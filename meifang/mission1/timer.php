<?php
    header("Content-type: text/html; charset=utf-8");
    $timer_file='timer.txt';
    $user=$_SERVER['REMOTE_ADDR'];
if ($_SERVER['REQUEST_METHOD']=='GET') {
    if (is_file($timer_file)&&strpos(file_get_contents($timer_file), $user)!==false) {
        $lines=file($timer_file);
        for ($i=0; $i<count($lines); $i++) {
            $n=explode(':', $lines[$i]);
            if ($n[0]==$user) {
                $lines[$i]=$user.':'.strval(intval($n[1])+5)."\n";
            }
        }
        file_put_contents($timer_file, $lines);
    } else {
        $file=fopen($timer_file, 'a');
        fwrite($file, $user.':'.strval(5)."\n");
        fclose($file);
    }
}
