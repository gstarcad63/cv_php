<?php

// 开启session
session_start();
// 判断登录
if ( intval( $_SESSION['uid'] ) < 1 )
{
    header("Location:user_login.php");
    die("请先<a href='user_login.php'>登录再添加简历</a>");
}

$id = intval($_REQUEST);
if ($id < 1) die("错误的简历");

// 连接数据库
try {
    // 初始化PDO对象
    $dbh = new PDO('mysql:host=mysql.ftqq.com;dbname=fangtangdb', 'php', 'fangtang');

    // 捕捉异常
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 预处理sql模板  ?参数准备sql
    $sql = "SELECT * FROM `resume` WHERE `id` = ? LIMIT 1";

    // 预处理对象
    $sth = $dbh->prepare($sql);

    // 执行sql语句
    $ret = $sth->execute([$id]);
    $resume = $sth->fetch(PDO::FETCH_ASSOC);

    // 权限判断
    if ( $resume['uid'] != $_SESSION['uid'] ) die("没有权限，只能修改自己的简历");
}
// 错误处理

// 全局异常
catch (Exception $Exception) {
    die($Exception->getMessage());
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改简历</title>
    <link rel="stylesheet" href="main.css">
    <script src="http://lib.sinaapp.com/js/jquery/3.1.0/jquery-3.1.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="container">
    <h1>修改简历</h1>
    <form action="resume_update.php" method="post" id="form_resume" onsubmit="send_form('form_resume');return false;">
        <div id="form_resume_notice" class="form_info full"></div>

        <p><input type="text" name="title" placeholder="简历名称" class="full" value="<?=$resume['title']?>"></p>

        <p><textarea name="content" placeholder="编辑简历内容，支持Markdown语法" class="full"><?=htmlspecialchars( $resume['content'] )?></textarea></p>

        <input type="hidden" name="id" value="<?=$resume['id']?>">
        <p>
            <input type="submit" value="更新简历" class="middle-button">
            <input type="button" value="返回首页" class="middle-button cancel-button" onClick="history.back(1);void(0);">
        </p>
    </form>
</div>
</body>
</html>