<?php
// 开启session
session_start();
// 判断登录
if ( intval( $_SESSION['uid'] ) < 1 )
{
    header("Location:user_login.php");
    die("请先<a href='user_login.php'>登录再添加简历</a>");
}

// 连接数据库
try {
    // 初始化PDO对象
    $dbh = new PDO('mysql:host=mysql.ftqq.com;dbname=fangtangdb', 'php', 'fangtang');

    // 捕捉异常
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 预处理sql模板  ?参数准备sql
    $sql = "SELECT `id`, `uid`, `title`, `created_at` FROM `resume` WHERE `uid` = ? AND `is_deleted` != 1 ";

    // 预处理对象
    $sth = $dbh->prepare( $sql );

    // 执行sql语句
    $ret = $sth->execute( [ intval( $_SESSION['uid'] ) ] );
    $resume_list = $sth->fetchAll(PDO::FETCH_ASSOC);

//    print_r( $resume_list );
}
catch ( Exception $Exception )
{
    die( $Exception->getMessage() );
}

$is_login = true;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的简历</title>
    <link rel="stylesheet" href="main.css">
    <script src="http://lib.sinaapp.com/js/jquery/3.1.0/jquery-3.1.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
        <?php include 'header.php'?>
        <h1>我的简历</h1>
        <?php if ( $resume_list ): ?>
        <ul class="resume_list">
            <?php foreach ( $resume_list as $item ) : ?>
                <li id="rlist-<?=$item['id']?>">
                    <span class="menu_square_large"></span>
                    <a href="resume_detail.php?id=<?=$item['id']?>" class="title middle" target="_blank"> <?=$item['title']?> </a>
                    <a href="resume_detail.php?id=<?=$item['id']?>" target="_blank"> <img src="image/launch.png" alt="查看"> </a>
                    <a href="resume_modify.php?id=<?=$item['id']?>"> <img src="image/create.png" alt="编辑"> </a>
                    <a href="javascript:confirm_delete( '<?=$item['id']?>' );void(0);"> <img src="image/clear.png" alt="删除"> </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <p><a href="resume_add.php" class="resume_add"><img src="image/add.png" alt="添加简历"> 添加简历</a></p>
    </div>
</body>
</html>