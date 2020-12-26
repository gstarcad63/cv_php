<?php

// 开启session
session_start();
// 判断登录
if ( intval( $_SESSION['uid'] ) < 1 )
{
    header("Location:user_login.php");
    die("请先<a href='user_login.php'>登录</a>再删除简历");
}

$id = intval($_REQUEST['id']);
if ($id < 1) die("错误的简历");

// 连接数据库
try {
    // 初始化PDO对象
    $dbh = new PDO('mysql:host=mysql.ftqq.com;dbname=fangtangdb', 'php', 'fangtang');

    // 捕捉异常
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 预处理sql模板  ?参数准备sql
    $sql = "UPDATE  `resume` SET `is_deleted` = 1 , `title` = CONCAT( `title` , ? ) WHERE `id` = ? AND `uid` = ? LIMIT 1";

    // 预处理对象
    $sth = $dbh->prepare( $sql );

    // 执行sql语句
    $ret = $sth->execute( [ '_DEL_'.time() , $id , intval( $_SESSION['uid'] ) ] );

    // header("Location: user_login.php");
    // die("简历删除成功<script>location='reload();'</script>");
    die("done");
}
// 错误处理
catch (PDOException $PDOException)
{
    die( $PDOException->getMessage() );
}
// 全局异常
catch (Exception $Exception)
{
    die( $Exception->getMessage() );
}
