<?php
// 开启session
session_start();
// 判断登录
if ( intval( $_SESSION['uid'] ) < 1 )
{
    header("Location:user_login.php");
    die("请先<a href='user_login.php'>登录再添加简历");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加简历</title>
    <link rel="stylesheet" href="main.css">
    <script src="http://lib.sinaapp.com/js/jquery/3.1.0/jquery-3.1.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
        <h1>添加简历</h1>
        <form action="resume_save.php" method="post" id="form_resume" onsubmit="send_form('form_resume');return false;">
            <div id="form_resume_notice" class="form_info full"></div>

            <p><input type="text" name="title" placeholder="简历名称" class="full"></p>

            <p><textarea name="content" placeholder="写入简历内容，支持Markdown语法" class="full"></textarea></p>

            <p>
                <input type="submit" value="添加简历" class="middle-button">
                <input type="button" value="返回首页" class="middle-button cancel-button" onClick="history.back(1);void(0);">
            </p>
        </form>
    </div>
</body>
</html>