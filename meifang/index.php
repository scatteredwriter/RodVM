<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>美房网第一个任务</title>
</head>

<body>
    <p>主页</p>

    <?php
        header("Content-type: text/html; charset=utf-8");
        $address=$_SERVER['REMOTE_ADDR'];
    if ($_SERVER['HTTP_REFERER']==null) {
        $referer='直接访问';
    } else {
        $referer=$_SERVER['HTTP_REFERER'];
    }
        $time=$_SERVER['REQUEST_TIME'];
        $uri=$_SERVER['REQUEST_URI'];
        $info_file='userinfo.txt';
        echo $address.' '.$referer.' '.$time.' '.$uri;
        
    function write_user_info()
    {
        if ($address==null||$referer==null||$time==null||$uri==null) {
            return;
        } else {
            echo '正在写';
            write();
        }
    }

    function write()
    {
        $file=fopen($info_file, 'a');
        $text=$address.','.$referer.','.$time.','.$uri.'\t';
        fwrite($file, $text);
        fclose($file);
        echo '写完毕';
    }

    write_user_info();
    ?>

</body>

</html>
