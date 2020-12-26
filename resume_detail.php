<?php

$id = intval( $_REQUEST );
if ( $id < 1 ) die("错误的简历");

// 连接数据库
try {
    // 初始化PDO对象
    $dbh = new PDO('mysql:host=mysql.ftqq.com;dbname=fangtangdb', 'php', 'fangtang');

    // 捕捉异常
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 预处理sql模板  ?参数准备sql
    $sql = "SELECT * FROM `resume` WHERE `id` = ? LIMIT 1";

    // 预处理对象
    $sth = $dbh->prepare( $sql );

    // 执行sql语句
    $ret = $sth->execute( [$id] );
    $resume = $sth->fetch(PDO::FETCH_ASSOC);

}
// 错误处理
// 全局异常
catch (Exception $Exception)
{
    die( $Exception->getMessage() );
}

include 'lib/Parsedown.php';
$md = new Parsedown();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$resume['title']?></title>
    <link rel="stylesheet" href="main.css">
    <script src="http://lib.sinaapp.com/js/jquery/3.1.0/jquery-3.1.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="container">
    <h1><?=$resume['title']?></h1>
    <div class="content">
        <?=$md->text( $resume['content'] )?>
    </div>
</div>
</body>
</html>