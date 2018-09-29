<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>美房网第一个任务</title>
</head>

<body>
    <p>查看用户访问信息</p>

    <?php
        header("Content-type: text/html; charset=utf-8");

    function get_user_info()
    {
        $file=fopen($GLOBALS['info_file'], 'r');
        $text=fread($file, filesize($GLOBALS['info_file']));
        fclose($file);
        display($text);
    }

    function display($text)
    {
        $address=0;
        $referer=1;
        $time=2;
        $uri=3;

        if ($text) {
            $infos=explode("\t", $text);
            echo '<table class="userinfo">';
            echo '<tr><td>用户IP</td><td>REFERER</td><td>访问时间</td><td>请求页面</td></tr>';
            for ($i=0; $i<count($infos)-1; $i++) {
                $info=explode(",", $infos[$i]);
                echo '<tr>';
                echo '<td>'.$info[$address].'</td>';
                echo '<td>'.$info[$referer].'</td>';
                echo '<td>'.date("Y-m-d H:i:s", $info[$time]).'</td>';
                if (strpos($info[$uri], 'index.php')!==false) {
                    $info[$uri]='主页';
                }
                echo '<td>'.$info[$uri].'</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    
    $info_file='userinfo.txt';
    get_user_info();
    ?>

</body>

</html>
