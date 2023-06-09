
<?php
    require 'untils/functions.php';
    
    if (!isset($_COOKIE['id'])) {
        header('./scoreinfo_student.php');
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
                    $sql = "SELECT uname FROM studentaccount where id=$uid";
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
                    <li class="nav-item">
                        <a class="nav-link" href="./home_student.php">学生列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./classinfo_student.php">班级信息</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./scoreinfo_student.php">成绩信息</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./user_student.php">个人中心</a>
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
                    <th>科目</th>
                    <th>成绩</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT id,sid,name,sub,score FROM scoreinfo where sid=(SELECT sid FROM scoreinfo where name=(SELECT uname FROM studentaccount WHERE id=$uid) limit 1)";
                    
                    if (isset($_POST['search'])) {
                        $s = $_POST['search'];
                        $sql = "$sql and (sid='$s' or name like '%$s%' or sub like '%$s%' or score = '%$s%' )";
                    }

                    $result = $conn->query($sql);
                     
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                            $id = $row['id'];
                            $sid = $row['sid'];
                            $name = $row['name'];
                            $sub = $row['sub'];
                            $score = $row['score'];
                            

                            echo "
                                <tr>
                                    <td>$sid</td>
                                    <td>$name</td>
                                    <td>$sub</td>
                                    <td>$score</td>
                                
                                    <td>
                                        <button
                                            type=\"button\"
                                            class=\"btn btn-primary\"
                                            onclick=\"\"
                                            >
                                            无权操作
                                        </button>
                                        <button
                                            type=\"button\"
                                            class=\"btn btn-danger\"
                                            onclick=\"\"
                                            >
                                            无权操作
                                        </button>
                                    </td>
                                </tr>
                            ";
                            
                        }
                        
                    }
                    
                    $conn->close();
                ?>
              

            </tbody>
        </table>
    </div>
</body>
</html>