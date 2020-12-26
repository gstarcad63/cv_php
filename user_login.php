<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户登入</title>
    <link rel="stylesheet" href="main.css">
    <script src="http://lib.sinaapp.com/js/jquery/3.1.0/jquery-3.1.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
        <?php $is_login=false; include 'header.php';?>
        <h1>用户登入</h1>
        <form action="user_login_check.php" method="post" id="form_login" onsubmit="send_form('form_login');return false;">
            <div id="form_login_notice" class="form_info middle"></div>
            <p><input type="text" name="email" placeholder="Email" class="middle"></p>
            <p><input type="password" name="password" placeholder="密码（6-12个字符）" class="middle"></p>
            <p><input type="submit" value="登入" class="middle-button"></p>
        </form>
    </div>
</body>
</html>