<div class="headbox">
    <?php if ( $is_login ): ?>
        <div class="menu">
            <li><span class="menu_square"></span><a href="resume_list.php">我的简历</a></li>
            <li><span class="menu_square"></span><a href="user_logout.php">退出</a></li>
        </div>
    <?php else: ?>
        <div class="menu">
            <li><span class="menu_square"></span><a href="user_reg.php">注册</a></li>
            <li><span class="menu_square"></span><a href="user_login.php">登录</a></li>
        </div>
    <?php endif; ?>
    <div class="logo"><a href="index.php"><img src="image/logo.png" alt="极简简历logo"></a></div>
</div>