<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>学生照片</title>
    <script type="text/javascript">
        function showstudent(studentId) {
            window.open("showphoto.php?studentId=" + studentId);
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
$keyword = NULL;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['keyword'])) {
        $keyword = urlencode($_POST['keyword']);
    }
} else {
    if(!empty($_GET['classId'])) {
        $keyword = urldecode($_GET['classId']);
    }
}
if($keyword != NULL) {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,'http://jwzx.cqu.pt/data/json_StudentSearch.php?searchKey='.$keyword);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36');
    $result = curl_exec($ch);
    // $result = shell_exec('python3 studentinfo.py'.' search '.$keyword);
    $result = json_decode($result);
    if ($result != NULL) {
        $list = $result->returnData;
        if(count($list) > 0){
            echo '<div class="studentlist">';
            for($i = 0;$i < count($list) ; $i++){
                $student = $list[$i];
                if($student->xh == 2015212856 || $student->xh == 2015211726) {
                    continue;
                }
                echo '<a class="student" href="javascript:showstudent(\''.$student->xh.'\');">'.$student->xm." ".$student->nj." ".$student->xb." ".$student->xh." ".$student->zym." ".$student->yxm.'</a>';
            }
            echo '</div>';
        }
    }
}
?>

</body>

</html>
