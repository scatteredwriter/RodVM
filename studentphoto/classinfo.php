<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>班级信息</title>
    <script type="text/javascript">
        function showstudent(studentId) {
            window.open("index.php?studentId=" + studentId);
        }
    </script>
</head>

<body>
    <?php
$content = shell_exec('python3 classinfo.py');
$pattern = '"kb_bj\.php\?bj=(\d+)"';
$content = preg_replace($pattern,'javascript:showMemberPhoto($1);', $str);
echo $content;
?>

</body>

</html>
