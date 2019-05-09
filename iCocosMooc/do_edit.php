<?php

include_once "./lib/fun.php";

checkLogin();

$user = $_SESSION['user'];

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
    // 商品ID
    $goodsId = isset($_POST['id']) ? intval($_POST['id']) : "";
    // 修改时间
    $update_time = date("Y-m-d H:i:s");

    // 验证商品ID
    if (!$goodsId) {
        showMsg(0, "参数非法");
    }

    // 判断商品ID是否存在数据库
    $sql = "SELECT * FROM `goods` WHERE `id` = {$goodsId} LIMIT 1";
    $result_obj = $conn->query($sql);
    $goods = $result_obj->fetch_assoc();
    if (!$goods) {
        showMsg(0, "画品不存在", "./");
    }

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

    // 当用户选择图片时上传
    if ($_FILES["file"]["size"] > 0) {
        $pic = imgUpload($_FILES['file']);
    }

    // 更新数据数组
    $update = array(
        "name" => $name,
        "price" => $price,
        "des" => $des,
        "content" => $content,
        "update_time" => $update_time
    );

    // 只更新被更改的数据
    foreach ($update as $k => $v) {
        if ($goods[$k] == $v) {
            unset($update[$k]);
        }
    }

    // 构造SQL语句
    $updateSQL = "";
    foreach ($update as $k => $v) {
        $updateSQL .= "`{$k}` = '{$v}',";
    }
    if (empty($update)) {
        showMsg(1, "操作成功", "./edit.php?id={$goodsId}");
    }

    // 去除最后一个`,`
    $updateSQL = rtrim($updateSQL, ",");

    $sql = "UPDATE `goods` SET {$updateSQL} WHERE `id` = {$goodsId}";

    $result = $conn->query($sql);
    if ($result) {
        showMsg(1, "操作成功", "./edit.php?id={$goodsId}");
    } else {
        showMsg(0, "操作失败", "./edit.php?id={$goodsId}");
    }

    // 关闭数据库连接
    $conn->close();

}
