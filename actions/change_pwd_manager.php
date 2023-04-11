<?php
    require '../untils/functions.php';

    $pwd = $_POST['pwd'];
    $npwd = $_POST['npwd'];
    $cnpwd = $_POST['cnpwd'];

    if ($npwd != $cnpwd) {
        alert('两个密码不一致，请重新输入。');
        return;
    }

    require '../untils/connect_db.php';

    $sql = "SELECT * FROM manager WHERE id={$_COOKIE['id']} AND pwd=$pwd";
    $result = $conn->query($sql);
    
    if ($result->num_rows >= 0) {
        $sql = "UPDATE manager SET pwd='$npwd' WHERE pwd='$pwd' AND id= {$_COOKIE['id']}";
    
        if ($conn->query($sql) === TRUE) {
            alert('修改成功');
            href("../user_manager.php");
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    else {
        alert('原密码不正确。');
        href("../user_manager.php");
    }

    $conn->close();

?>