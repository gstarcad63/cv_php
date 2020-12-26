<?php

// 报告 E_NOTICE 之外的所有错误
error_reporting( E_ALL & ~E_NOTICE );

// 获取输入参数：接收响应，trim去除空格
$email = trim( $_REQUEST['email'] );
$password = trim( $_REQUEST['password'] );
$password2 = trim( $_REQUEST['password2'] );

// 参数检查：判断 email、密码、重复密码 不能为空
if ( strlen( $email ) < 1 ) die('Email 地址不能为空');
if ( mb_strlen( $password ) < 6 ) die('密码不能短于6个字符');
if ( mb_strlen( $password ) > 12 ) die('密码不能长于12个字符');
if ( strlen( $password2 ) < 1 ) die('重复密码不能为空');

// 判断两次密码是否一致
if ( $password != $password2 ) die('两次输入的密码不一致');

// 判断email格式是否正确
if ( !filter_var( $email , FILTER_VALIDATE_EMAIL ) )
{
    die('Email 地址错误');
}

//die('数据ok');

// 连接数据库
try {
    // 初始化PDO对象
    $dbh = new PDO('mysql:host=mysql.ftqq.com;dbname=fangtangdb', 'php', 'fangtang');

    // 捕捉异常
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 预处理sql模板  ?参数准备sql
    $sql = "INSERT INTO `user` (`email`, `password`, `created_at`) 
    VALUES ( ? , ? , ? )";

    // 预处理对象
    $sth = $dbh->prepare( $sql );

    // 执行sql语句
    $ret = $sth->execute( [$email , password_hash($password, PASSWORD_DEFAULT ) , date( "Y-m-d H:i:s" )] );

    //header("Location: user_login.php");
    die("用户注册成功<script>location='user_login.php'</script>");
}
// 错误处理
// PDO异常
catch ( PDOException $Exception )
{
    $errorInfo = $sth->errorInfo();

    if ( $errorInfo[1] == 1062)
    {
        die("Email地址已被注册");
    }
    else
    {
        die( $Exception->getMessage() );
    }
}
// 全局异常
catch (Exception $Exception)
{
    die( $Exception->getMessage() );
}
//echo $sql;