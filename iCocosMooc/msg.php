<?php

// type == 1操作成功
// type == 2操作失败
if ($_GET['type'] == 1 || $_GET['type'] == 0) {
    $type = $_GET['type'];
} else {
    $type = 0;
}

// 获取提示信息
$msg = isset($_GET['msg']) && !empty($_GET['msg']) ? trim($_GET['msg']) : null;

// 获取跳转url
$url = isset($_GET['url']) && !empty($_GET['url']) ? trim($_GET['url']) : null;

// 设置title
$title = $msg;

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/done.css"/>
</head>
<body>
<div class="header">
    <div class="logo f1">
        <img src="./static/image/logo.png">
    </div>
</div>
<div class="content">
    <div class="center">
        <div class="image_center">
            <?php if ($type == 1): ?>
                <span class="smile_face">:)</span>
            <?php elseif ($type == 0): ?>
                <span class="smile_face">:(</span>
            <?php endif; ?>
        </div>
        <div class="code">
            <?php echo $msg ?>
        </div>
        <div class="jump">
            页面在 <strong id="time" style="color: #009f95">3</strong> 秒后跳转
        </div>
    </div>

</div>
<div class="footer">
    <p><span>M-GALLARY</span>©2017 POWERED BY IMOOC.INC</p>
</div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script>
    $(function () {
        var time = 3;
        var url = "<?php echo $url ?>" || null;
        setInterval(function () {
            if (time > 1) {
                time--;
                console.log(time);
                $('#time').html(time);
            }
            else {
                $('#time').html(0);
                if (url) {
                    location.href = url;
                }
                else {
                    history.go(-1);
                }
            }
        }, 1000);
    })
</script>
</html>
