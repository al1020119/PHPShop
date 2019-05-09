<?php

include_once "./lib/fun.php";

// 开启session
session_start();

// 判断用户是否登录
if ($login = (isset($_SESSION['user']) && !empty($_SESSION['user']))) {
    $user = $_SESSION["user"];
}

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$page = max($page, 1);

// 分页设置

$pageSize = 3;

$offset = ($page - 1) * $pageSize;

$conn = mysqlInit("localhost", "root", "password", "mall");

$sql = "SELECT COUNT(`id`) AS total FROM `goods`";

$result_obj = $conn->query($sql);
$result = $result_obj->fetch_assoc();

$total = isset($result["total"]) ? $result["total"] : 0;

unset($sql, $result_obj, $result);

$sql = "SELECT `id`, `name`, `pic`, `des` FROM `goods` ORDER BY `id` ASC, `view` DESC LIMIT {$offset}, {$pageSize}";

$result_obj = $conn->query($sql);
$goods = array();

// 取得商品信息数组
while ($result = $result_obj->fetch_assoc()) {
    $goods[] = $result;
}

// 关闭数据库连接
$conn->close();

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|首页</title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/index.css"/>
</head>
<body>
<div class="header">
    <div class="logo f1">
        <img src="./static/image/logo.png">
    </div>
    <div class="auth fr">
        <ul>
            <?php if (!$login): ?>
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
            <?php else: ?>
                <li><span>管理员: <?php echo $user['username'] ?></span></li>
                <li><a href="publish.php">发布</a></li>
                <li><a href="login_out.php">退出</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="content">
    <div class="banner">
        <img class="banner-img" src="./static/image/welcome.png" width="732px" height="372" alt="图片描述">
    </div>
    <div class="img-content">
        <ul>
            <?php foreach ($goods as $good): ?>
                <li>
                    <img class="img-li-fix" src="<?php echo $good["pic"] ?>" alt="<?php echo $good["name"] ?>">
                    <div class="info">
                        <a href="detail.php?id=<?php echo $good["id"] ?>"><h3 class="img_title"><?php echo $good["name"] ?></h3></a>
                        <p>
                            <?php echo $good["des"] ?>
                        </p>
                        <div class="btn">
                            <a href="edit.php?id=<?php echo $good["id"] ?>" class="edit">编辑</a>
                            <a href="delete.php?id=<?php echo $good["id"] ?>" class="del">删除</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php echo(getPages($total, $page, $pageSize, 7)) ?>
</div>

<div class="footer">
    <p><span>M-GALLARY</span>©2017 POWERED BY IMOOC.INC</p>
</div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script>
    $(function () {
        $('.del').on('click', function () {
            if (confirm('确认删除该画品吗?')) {
                window.location = $(this).attr('href');
            }
            return false;
        })
    })
</script>


</html>

