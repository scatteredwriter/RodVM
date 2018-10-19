<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>班级信息</title>
    <script type="text/javascript">
        function showclassinfo(classId) {
            window.open("index.php?classId=" + classId);
        }
    </script>
</head>

<body>
    <?php
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'http://jwzx.cqu.pt/kebiao/index.php');
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36');
$output = curl_exec($ch);
curl_close($ch);
preg_match('/<div id="kbTabs-bj".+(?=<div id="kbTabs-kc")/s', $output, $result);
$output = $result[0];
$output = preg_replace('/kb_bj\.php\?bj=(\d+)/','javascript:showclassinfo($1);',$output);
echo $output;
?>

</body>

</html>
