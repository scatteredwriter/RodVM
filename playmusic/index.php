<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>播放音乐</title>
    <script type="text/javascript">
        function playmusic(songmid) {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("downloaddiv").innerHTML = '<a href="' + xmlhttp.responseText + '">点击下载歌曲</a>';
                    document.getElementById("downloaddiv").style = "padding: 5px 0px 5px 0px;";
                }
            }
            xmlhttp.open("GET", "playmusic.php?songmid=" + songmid, true);
            xmlhttp.send();
        }
        function changemusic() {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "changemusic.php", true);
            xmlhttp.send();
        }
    </script>
</head>

<body>

    <form action="" method="post">
        <p>输入搜索关键字：</p>
        <input class="text" type="text" name="keyword" />
        </br>
        <input class="submit" type="submit" name="submit" value="搜索" />
        <div id="playingmusic" style="padding: 5px 0px 5px 0px;">
            <a href="javascript:changemusic();">点击切歌</a>
        </div>
        <div id="downloaddiv"></div>
   </form>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['keyword'])) {
        $url='https://c.y.qq.com/soso/fcgi-bin/client_search_cp?new_json=1&aggr=1&cr=1&catZhida=1&p=1&n=20&w={0}&format=jsonp&inCharset=utf8&outCharset=utf-8';
        $keyword = urlencode($_POST['keyword']);
        $url = str_replace('{0}',$keyword,$url);
        $result = file_get_contents($url);
        $result = str_replace('callback(','',$result);
        $result = substr($result,0,strlen($result)-1);
        $result = json_decode($result);
        if ($result != NULL) {
            $list = $result->data->song->list;
            if(count($list) > 0){
                echo '<div class="musiclist">';
                for($i = 0;$i < count($list) ; $i++){
                    $music = $list[$i];
                    $singer='';
                    for($j = 0; $j < count($music->singer); $j++) {
                        if($j > 0)
                            $singer = $singer.'/';
                        $singer = $singer.$music->singer[$j]->name;
                    }
                    echo '<a class="music" href="javascript:playmusic(\''.$music->mid.'\');">'.$singer."- ".$music->name.'</a>';
                }
                echo '</div>';
            }
        }
    }
}
?>

</body>

</html>
