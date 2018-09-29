<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>美房网第一个任务</title>
    <script type="text/javascript">
        function clear(){
            document.getElementsByClassName("tip")[1].remove();
        }
    </script>
</head>

<body>
    <p>楼盘价格预警</p>
    <p class="tip">正在抓取数据，可能需要1-2分钟，请稍等(刷新页面会重新抓取)</p>

    <?php

    `showprice.py`;
    $comparelist=file_get_contents('comparelist.txt');
    $comparelist=json_decode(comparelist);
    echo "<script type=\"text/javascript\">clear();</script>";
    echo "<table>";
    echo "<tr><td>楼盘</td><td>美房网价格</td><td>我房网价格</td><td>品房网价格</td><td>旅居网价格</td></tr>";
    foreach ($comparelist as $item) {
        echo "<tr>";
        echo '<td>'.$item->title.'</td>';
        echo '<td>'.$item->meifangprice.'</td>';
        try {
            echo '<td>'.$item->wofangprice.'</td>';
        } catch (Exception $e) {
        }
        try {
            echo '<td>'.$item->pinfangprice.'</td>';
        } catch (Exception $e) {
        }
        try {
            echo '<td>'.$item->hainanfzprice.'</td>';
        } catch (Exception $e) {
        }
        echo "</tr>";
    }

    ?>

</body>

</html>
