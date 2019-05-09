<?php

include_once "./lib/fun.php";

checkLogin();

// 校验ID
isset($_GET["id"]) && !empty($_GET["id"]) ? $goodsID = intval($_GET["id"]) : showMsg(0, "参数非法");

$conn = mysqlInit("localhost", "root", "password", "mall");

$sql = "SELECT `id` FROM `goods` WHERE `id` = {$goodsID}";

$result_obj = $conn->query($sql);

if (!$result_obj->fetch_assoc()) {
    showMsg(0, "画品不存在");
}

// 实际开发中会使用 status 字段标识 1：正常状态 -1：删除状态
$sql = "DELETE FROM `goods` WHERE `id` = {$goodsID} LIMIT 1";

$result = $conn->query($sql);

if (!$result) {
    showMsg(0, "删除失败");
} else {
    showMsg(1, "删除成功");
}
