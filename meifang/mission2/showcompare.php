<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <title>美房网第二个任务</title>
    <script type="text/javascript">
        function loadscript() {
            var tips = document.createElement("p");
            tips.appendChild(document.createTextNode("正在抓取数据，可能需要3-5分钟，请稍等，不要刷新页面"));
            tips.setAttribute("class", "tips");
            document.body.appendChild(tips);
            clear();
            this.location = "showcompare.php?action=load"; 
        }
        function clear() {
            var tips = document.body.getElementsByClassName("tips");
            for (var index = 0; index < tips.length; index++) {
                document.body.removeChild(tips[index]);
            }
        }
    </script>
</head>

<body>
    <p>楼盘价格预警</p>
    <button onclick="loadscript();">抓取数据</button>
    <?php
    
    if (!file_exists('comparelist.txt')) {
        echo "<p class=\"tips\">没有本地数据，请点击上方按钮重新抓取</p>";
    } else {
        show();
    }

    if ($_GET['action']=='load') {
        load_data();
    }

    function load_data()
    {
        shell_exec('rm -rf *.txt');
        shell_exec('python3 showprice.py');
        show();
    }

    function show()
    {
        // 输出房价预警列表
        $comparelist=file_get_contents('comparelist.txt');
        $comparelist=json_decode($comparelist);
        echo "<script type=\"text/javascript\">clear();</script>";
        echo "<p>房价预警列表</p>";
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
        echo "</table>";
        // 输出美房网按整套售卖的楼盘列表
        if (file_exists('meifanginfo_.txt')) {
            $meifanginfo_=file_get_contents('meifanginfo_.txt');
            $meifanginfo_=json_decode($meifanginfo_, true);
            echo "<p>美房网按整套售卖的楼盘列表</p>";
            echo "<table>";
            echo "<tr><td>楼盘</td><td>价格</td></tr>";
            foreach ($meifanginfo_ as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</table>";
        }
        // 输出错误数据列表
        if (file_exists('errorinfo.txt')) {
            $errorinfo=file_get_contents('errorinfo.txt');
            $errorinfo=json_decode($errorinfo);
            echo "<p>错误数据列表</p>";
            echo "<table>";
            echo "<tr><td>楼盘</td><td>美房网价格</td><td>我房网价格</td><td>品房网价格</td><td>旅居网价格</td></tr>";
            foreach ($errorinfo as $item) {
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
        }
    }

    ?>

</body>

</html>
