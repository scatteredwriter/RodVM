<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>班级信息</title>
    <script type="text/javascript">
        function showstudent(studentId) {
            window.open("showphoto.php?studentId=" + studentId);
        }
    </script>
</head>

<body>
    <?php
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"http://www.devdo.net");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
$output = curl_exec($ch);
curl_close($ch);
preg_match('<div id="kbTabs-bj".+(?=<div id="kbTabs-kc")', $output, $result);
echo $result;
?>

</body>

</html>
