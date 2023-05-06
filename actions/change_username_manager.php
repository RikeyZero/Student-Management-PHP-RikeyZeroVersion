<?php
    require '../untils/connect_db.php';
    require '../untils/functions.php';
  
    $sql = "UPDATE manager SET uname='{$_POST['uname']}' WHERE id= {$_COOKIE['id']}";

    if ($conn->query($sql) === TRUE) {
        alert('修改成功');
        href("../user_manager.php");
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>