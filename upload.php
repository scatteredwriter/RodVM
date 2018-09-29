<?php
header("content-type:text/html;charset=utf-8");
$counts=count($_FILES['file']['name']);
if($counts!=0){
    echo "It will upload ".$counts." file(s)...</br>";
    for($i=0;$i<$counts;$i++){
        echo "Upload ".$i.": ".$_FILES['file']['name'][$i]." <br/>";
        echo "Type: ".$_FILES['file']['type'][$i]." <br/>";
        echo "Size: ".$_FILES['file']['size'][$i]." <br/>";
        echo "Dir: ".$_POST['dir']." <br/>";
        if(!is_dir($_POST['dir'])){
                echo $_POST['dir']." does't exsit.</br>";
                mkdir($_POST['dir'],0777);
                echo $_POST['dir']." is made.</br>";
        }
        if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$_POST['dir']."/".$_FILES['file']['name'][$i]))
                echo $_FILES['file']['name'][$i]." uploaded successfully!</br>";
        else
                echo $_FILES['file']['name'][$i]." uploaded failed!</br>";
	echo "</br>";
    }
}
?>
