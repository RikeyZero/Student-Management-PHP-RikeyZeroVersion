<?php
    require './untils/functions.php';

    if (isset($_COOKIE['id'])) {
        href('./home.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生管理系统</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        body {
            color: white;
            padding: 20px;
            background: url(./img/bg.jpg) repeat center top;
            margin-top: 10%;
        }
        button {
            margin: 10px;
        }
        .title {
            font-size:  60px;
            text-shadow: 2px 2px 3px #000000;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col text-center title">学生管理系统</div>
        <button class="btn btn-primary col" onclick="location.href='./register_student.php'">注册</button>
        <button class="btn btn-success col" onclick="location.href='./login_student.php'">登陆</button>
        <button class="btn btn-danger col" onclick="location.href='./index.php'">返回</button>
    </div>
</body>
</html>