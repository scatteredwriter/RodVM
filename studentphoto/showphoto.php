<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>学生照片</title>
</head>

<body>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET['studentId'])) {
        $studentId = $_GET['studentId'];
        $stu_photo = shell_exec('python3 studentinfo.py'.' student '.$studentId);
        $cet_photo = shell_exec('python3 studentinfo.py'.' cet '.$studentId);
        if($stu_photo != NULL) {
            echo '<div class="studentphoto">';
            echo '<div class="title"><p>证件照片</p></div>';
            echo '<img src="'.$stu_photo.'" width="60%"/>';
            echo '</div>';
        }
        if($cet_photo != NULL) {
            echo '<div class="cetphoto">';
            echo '<div class="title"><p>四六级照片</p></div>';
            echo '<img src="'.$cet_photo.'" width="60%"/>';
            echo '</div>';
        }
    }
}
?>

</body>

</html>
