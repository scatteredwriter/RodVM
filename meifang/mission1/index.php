<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>美房网第一个任务</title>
    <script type="text/javascript">
        var timer=5000;
        window.setInterval(request, timer);
        function request(){
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "timer.php", true);
            xmlhttp.send();
        }
    </script>
</head>

<body>
    <p>主页</p>

    <?php

    header("Content-type: text/html; charset=utf-8");
    function write_user_info()
    {
        if ($GLOBALS['address']!=null&&$GLOBALS['time']!=null&&$GLOBALS['uri']!=null&&$GLOBALS['referer']!=null) {
            write();
        }
    }

    function write()
    {
        $file=fopen($GLOBALS['info_file'], 'a');
        $text=$GLOBALS['address'].','.$GLOBALS['referer'].','.$GLOBALS['time'].','.$GLOBALS['uri']."\t";
        fwrite($file, $text);
        fclose($file);
    }

    $address=$_SERVER['REMOTE_ADDR'];
    $time=$_SERVER['REQUEST_TIME'];
    $uri=$_SERVER['REQUEST_URI'];
    $referer='';
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer=$_SERVER['HTTP_REFERER'];
    } else {
        $referer='直接访问';
    }
    $info_file='userinfo.txt';
    echo $address.' '.$referer.' '.$time.' '.$uri;
    write_user_info();
    ?>

</body>

</html>
