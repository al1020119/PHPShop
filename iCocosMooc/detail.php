<?php
include_once "./lib/fun.php";

// 开启session
session_start();

// 判断用户是否登录
if ($login = (isset($_SESSION['user']) && !empty($_SESSION['user']))) {
    $user = $_SESSION["user"];
}

$goodId = isset($_GET["id"]) ? intval($_GET["id"]) : NUll;

if (!$goodId) {
    showMsg(0, "参数非法");
}

$conn = mysqlInit("localhost", "root", "password", "mall");

$sql = "SELECT * FROM `goods` WHERE `id` = {$goodId}";

$result_obj = $conn->query($sql);

$info = $result_obj->fetch_assoc();

unset($sql, $result_obj);

$sql = "SELECT * FROM `user` WHERE `id` = {$info["user_id"]}";

$result_obj = $conn->query($sql);

$user = $result_obj->fetch_assoc();

unset($sql, $result_obj);

$sql = "UPDATE `goods` SET `view` = `view` + 1 WHERE `id` = {$info["id"]}";

$conn->query($sql);


// 关闭数据库连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|<?php echo $goods['name'] ?></title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/detail.css"/>
</head>
<body class="bgf8">
<div class="header">
    <div class="logo f1">
        <img src="./static/image/logo.png">
    </div>
    <div class="auth fr">
        <ul>
            <?php if (!$login): ?>
                <li><a href="./">首页</a></li>
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
            <?php else: ?>
                <li><a href="./">首页</a></li>
                <li><span>管理员: <?php echo $user['username'] ?></span></li>
                <li><a href="publish.php">发布</a></li>
                <li><a href="login_out.php">退出</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="content">
    <div class="section" style="margin-top:20px;">
        <div class="width1200">
            <div class="fl"><img src="<?php echo $info['pic'] ?>" width="720px" height="432px"/></div>
            <div class="fl sec_intru_bg">
                <dl>
                    <dt><?php echo $info['name'] ?></dt>
                    <dd>
                        <p>发布人：<span><?php echo $user['username'] ?></span></p>
                        <p>发布时间：<span><?php echo $info['create_time'] ?></span></p>
                        <p>修改时间：<span><?php echo $info['update_time'] ?></span></p>
                        <p>浏览次数：<span><?php echo $info['view'] ?></span></p>
                    </dd>
                </dl>
                <ul>
                    <li>售价：<br/><span class="price"><?php echo $info['price'] ?></span>元</li>
                    <li class="btn"><a href="javascript:;" class="btn btn-bg-red" style="margin-left:38px;">立即购买</a>
                    </li>
                    <li class="btn"><a href="javascript:;" class="btn btn-sm-white" style="margin-left:8px;">收藏</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="secion_words">
        <div class="width1200">
            <div class="secion_wordsCon">
                <?php echo $info['content'] ?>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <p><span>M-GALLARY</span>©2017 POWERED BY IMOOC.INC</p>
</div>
</div>
</body>
</html>

