<?php

// 开启session
session_start();
// 判断登录
if ( intval( $_SESSION['uid'] ) < 1 )
{
    header("Location:user_login.php");
    die("请先<a href='user_login.php'>登录再添加简历</a>");
}

// 报告 E_NOTICE 之外的所有错误
error_reporting( E_ALL & ~E_NOTICE );

// 获取输入参数：接收响应，trim去除空格
$id = intval( $_REQUEST['id'] );
$title = trim( $_REQUEST['title'] );
$content = trim( $_REQUEST['content'] );

// 参数检查：判断 email、密码、重复密码 不能为空
if ( strlen( $id ) < 1 ) die('简历ID不能为空');
if ( strlen( $title ) < 1 ) die('简历名称不能为空');
if ( mb_strlen( $content ) < 10 ) die('简历内容不能少于10个字符');

// 连接数据库
try {
    // 初始化PDO对象
    $dbh = new PDO('mysql:host=mysql.ftqq.com;dbname=fangtangdb', 'php', 'fangtang');

    // 捕捉异常
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 预处理sql模板  ?参数准备sql
    $sql = "UPDATE  `resume` SET `title` = ? , `content` = ? WHERE `id` = ? AND `uid` = ? LIMIT 1";

    // 预处理对象
    $sth = $dbh->prepare( $sql );

    // 执行sql语句
    $ret = $sth->execute( [ $title , $content , $id , intval( $_SESSION['uid'] ) ] );

    //header("Location: user_login.php");
    die("简历更新成功<script>location='resume_list.php'</script>");
}
// 错误处理
// PDO异常
catch ( PDOException $Exception )
{
    $errorInfo = $sth->errorInfo();

    if ( $errorInfo[1] == 1062)
    {
        die("简历名称已存在");
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