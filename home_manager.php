<?php
    require 'untils/functions.php';
    
    if (!isset($_COOKIE['id'])) {
        href('./home_manager.php');
        return;
    }
    
    require 'untils/connect_db.php';

    $uid = $_COOKIE['id'];
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
            padding: 20px;
            background: url(./img/bg.jpg) repeat center top;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container table-responsive text-center shadow-lg">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <span class="navbar-brand">
                <?php 
                    $sql = "SELECT uname FROM manager where id=$uid";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo $row['uname'];
                    }
                    else {
                        echo "获取用户名失败";
                    }
                ?>
            </span>
            
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="./home_manager.php">学生列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./classinfo_manager.php">班级信息</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./scoreinfo_manager.php">成绩信息</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./user_manager.php">个人中心</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./actions/logout.php">注销</a>
                    </li>
                </ul>
                <form class="form-inline" action="" method="POST">
                    <input class="form-control mr-sm-2" type="search" placeholder="" aria-label="Search" name="search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">搜索</button>
                </form>
            </div>
        </nav>

        <table class="table table-hover" border="1">
            <thead class="thead-dark">
                <tr>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>年龄</th>
                    <th>性别</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT id, sid, name, age, sex FROM studentinfo where uid=$uid";
                    
                    if (isset($_POST['search'])) {
                        $s = $_POST['search'];
                        $sql = "$sql and (sid='$s' or name like '%$s%' or age='$s' or sex='$s')";
                    }

                    $result = $conn->query($sql);
                     
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                            $id = $row['id'];
                            $sid = $row['sid'];
                            $name = $row['name'];
                            $age = $row['age'];
                            $sex = $row['sex'];

                            echo "
                                <tr>
                                    <td>$sid</td>
                                    <td>$name</td>
                                    <td>$age</td>
                                    <td>$sex</td>
                                    <td>
                                        <button
                                            type=\"button\"
                                            class=\"btn btn-primary\"
                                            onclick=\"location.href='./edit.php?id=$id&sid=$sid&name=$name&age=$age&sex=$sex'\"
                                            >
                                            编辑
                                        </button>
                                        <button
                                            type=\"button\"
                                            class=\"btn btn-danger\"
                                            onclick=\"location.href='./actions/delete.php?id=$id'\"
                                            >
                                            删除
                                        </button>
                                    </td>
                                </tr>
                            ";
                        }
                    }
                    else {
                        echo "<tr><td colspan='5'>没有符合条件的学生 或 目前还没有添加学生</td></tr>";
                    }

                    $conn->close();
                ?>
                <tr>
                    <form action="./actions/add.php" method="POST">
                        <td>
                            <input class="form-control" type="number" name="sid">
                        </td>
                        <td>
                            <input class="form-control" name="name">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="age">
                        </td>
                        <td>
                            <select class="form-control" name="sex">
                                <option value="男"></option>
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success">添加</button>
                        </td>
                    </form>
                </tr>

            </tbody>
        </table>
    </div>
</body>
</html>
