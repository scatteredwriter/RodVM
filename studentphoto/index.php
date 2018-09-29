<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>学生照片</title>
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
   </form>

    <?php
// header("Content-type: text/html; charset=utf-8");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['keyword'])) {
        $url='http://jwzx.cqu.pt/data/json_StudentSearch.php?searchKey={0}';
        $keyword = urlencode($_POST['keyword']);
        $url = str_replace('{0}',$keyword,$url);
        $result = file_get_contents($url);
        $result = json_decode($result);
        if ($result != NULL) {
            $list = $result->returnData;
            if(count($list) > 0){
                echo '<div class="studentlist">';
                for($i = 0;$i < count($list) ; $i++){
                    $student = $list[$i];
                    echo '<a class="student" href="javascript:showstudent(\''.$student->xh.'\');">'.$student->xm." ".$student->nj." ".$student->xb." ".$student->xh.'</a>';
                }
                echo '</div>';
            }
        }
    }
}
?>

</body>

</html>
