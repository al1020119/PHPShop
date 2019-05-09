<?php

include_once "./lib/fun.php";

checkLogin();

$user = $_SESSION['user'];


// 表单进行了提交
if (!empty($_POST['name'])) {

    $conn = mysqlInit("localhost", "root", "password", "mall");

    // 获取表单信息
    // 名字
    $name = $conn->real_escape_string(trim($_POST['name']));
    // 价格
    $price = intval($_POST['price']);
    // 简介
    $des = $conn->real_escape_string($_POST['des']);
    // 详情
    $content = $conn->real_escape_string($_POST['content']);
    // 用户ID
    $userID = $user['id'];

    // 验证画品名字长度
    $nameLength = mb_strlen($name);
    if ($nameLength <= 0 || $nameLength > 30) {
        showMsg(0, "画品名字应在1~30字符之间");
    }

    // 验证画品简介长度
    $desLength = mb_strlen($des);
    if ($desLength <= 0 || $desLength > 100) {
        showMsg(0, "画品简介应在1~100字符之间");
    }

    // 验证画品价格
    if ($price <= 0 || $price > 99999999999) {
        showMsg(0, "画品价格应在1~99999999999之间");
    }

    // 验证画品详情
    if (empty($content)) {
        showMsg(0, "画品详情不能为空");
    }

    // 图片上传
    $pic = imgUpload($_FILES['file']);

    // 画品名称重复性验证
    $sql = "SELECT COUNT(`id`) AS `total` FROM `goods` WHERE `name` = '{$name}'";

    $result_obj = $conn->query($sql);
    $result = $result_obj->fetch_assoc();
    // var_dump($result);
    // 验证画品名称是否存在
    if (isset($result['total']) && $result['total'] > 0) {
        showMsg(0, "画品名称已存在");
    }

    $create_time = date("Y-m-d H:i:s");

    // 数据入库
    $sql = "INSERT INTO `goods` (`name`, `price`, `des`, `content`, `pic`, `user_id`, `create_time`, `update_time`, `view`)"
        . " VALUES ('{$name}', '{$price}', '{$des}', '{$content}', '{$pic}', '{$userID}', '{$create_time}', '{$create_time}', 0)";

    var_dump($conn);
    if ($result_obj = $conn->query($sql)) {
        showMsg(1, "添加画品成功", "./");
    } else {

        showMsg(0, "{$conn->error}");
    }

    // 关闭数据库连接
    $conn->close();

}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|发布画品</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
</head>
<body>
<div class="header">
    <div class="logo f1">
        <img src="./static/image/logo.png">
    </div>
    <div class="auth fr">
        <ul>
            <li><a href="./">首页</a></li>
            <li><span>管理员: <?php echo $user['username'] ?></span></li>
            <li><a href="login_out.php">退出</a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="addwrap">
        <div class="addl fl">
            <header>发布画品</header>
            <form name="publish-form" id="publish-form" action="publish.php" method="post"
                  enctype="multipart/form-data">
                <div class="additem">
                    <label id="for-name">画品名称</label><input type="text" name="name" id="name" placeholder="请输入画品名称">
                </div>
                <div class="additem">
                    <label id="for-price">价值</label><input type="text" name="price" id="price" placeholder="请输入画品价值">
                </div>
                <div class="additem">
                    <!-- 使用accept html5属性 声明仅接受png gif jpeg格式的文件                -->
                    <label id="for-file">画品</label><input type="file" accept="image/png,image/gif,image/jpeg" id="file"
                                                          name="file">
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-des">画品简介</label><textarea id="des" name="des"
                                                                           placeholder="请输入画品简介"></textarea>
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-content">画品详情</label>
                    <div style="margin-left: 120px" id="container">
                        <textarea id="content" name="content"></textarea>
                    </div>

                </div>
                <div style="margin-top: 20px">
                    <button type="submit">发布</button>
                </div>

            </form>
        </div>
        <div class="addr fr">
            <img src="./static/image/index_banner.png">
        </div>
    </div>

</div>
<div class="footer">
    <p><span>M-GALLARY</span>©2017 POWERED BY IMOOC.INC</p>
</div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script src="./static/js/layer/layer.js"></script>
<script src="./static/js/kindeditor/kindeditor-all-min.js"></script>
<script src="./static/js/kindeditor/lang/zh_CN.js"></script>
<script>
    var K = KindEditor;
    K.create('#content', {
        width: '475px',
        height: '400px',
        minWidth: '30px',
        minHeight: '50px',
        items: [
            'undo', 'redo', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'clearhtml',
            'fontsize', 'forecolor', 'bold',
            'italic', 'underline', 'link', 'unlink', '|'
            , 'fullscreen'
        ],
        afterCreate: function () {
            this.sync();
        },
        afterChange: function () {
            //编辑器失去焦点时直接同步，可以取到值
            this.sync();
        }
    });
</script>

<script>
    $(function () {
        $('#publish-form').submit(function () {
            var name = $('#name').val(),
                price = $('#price').val(),
                file = $('#file').val(),
                des = $('#des').val(),
                content = $('#content').val();
            if (name.length <= 0 || name.length > 30) {
                layer.tips('画品名应在1-30字符之内', '#name', {time: 2000, tips: 2});
                $('#name').focus();
                return false;
            }
            //验证为正整数
            if (!/^[1-9]\d{0,8}$/.test(price)) {
                layer.tips('请输入最多9位正整数', '#price', {time: 2000, tips: 2});
                $('#price').focus();
                return false;
            }

            if (file == '' || file.length <= 0) {
                layer.tips('请选择图片', '#file', {time: 2000, tips: 2});
                $('#file').focus();
                return false;

            }

            if (des.length <= 0 || des.length >= 100) {
                layer.tips('画品简介应在1-100字符之内', '#content', {time: 2000, tips: 2});
                $('#des').focus();
                return false;
            }

            if (content.length <= 0) {
                layer.tips('请输入画品详情信息', '#container', {time: 2000, tips: 3});
                $('#content').focus();
                return false;
            }
            return true;

        })
    })
</script>
</html>

