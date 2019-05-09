<?php
/**
 * 数据库连接初始化
 * @param $host
 * @param $username
 * @param $password
 * @param $database
 * @return bool|object mysqli
 */
function mysqlInit($host, $username, $password, $database, $charset = "utf8")
{
    // 面向对象连接数据库
    $conn = new mysqli("$host", "$username", "$password", "$database");
    if ($conn->connect_error) {
        return false;
    }
    // echo "连接成功";
    // 设置字符集
    $conn->set_charset("$charset");
    // 返回的是一个对象
    return $conn;
}

/**
 * 用户密码加密
 * @param $password
 * @return bool|string
 */
function pwdEncrypt($password)
{
    if (!$password) {
        return false;
    }

    return md5(md5($password) . "password");
}

/**
 * 信息页提示信息跳转
 * @param int $type
 * @param null $msg
 * @param null $url
 */
function showMsg($type, $msg = null, $url = null)
{
    $msg = urlencode($msg);
    $toUrl = "Location:msg.php?type={$type}";
    $toUrl .= $msg ? "&msg={$msg}" : "";
    $toUrl .= $url ? "&url={$url}" : "";

    header($toUrl);
    exit;
}

/**
 * 图片上传
 * @param $file
 * @return string
 */
function imgUpload($file)
{
    $now = $_SERVER['REQUEST_TIME'];

    // 检查上传文件是否合法
    if (!is_uploaded_file($file['tmp_name'])) {
        showMsg(0, "请上传合法的文件");
    }

    // 上传路径
    $uploadPath = "./static/file/";
    // 访问URL
    $uploadUrl = "/static/file/";
    // 上传文件夹
    $fileDir = date("Y/md/", $now);

    // 检查上传目录是否存在
    if (!is_dir($uploadPath . $fileDir)) {
        mkdir($uploadPath . $fileDir, 0755, true);
    }

    // 获取上传文件的扩展名
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // 上传图像重命名（用于去重）
    // uniqid()函数在微秒级生成一个随机数
    $img = uniqid() . mt_rand(1000, 9999) . "." . $ext;

    // 文件路径
    $imgPath = $uploadPath . $fileDir . $img;
    // 文件URL路径
    $imgUrl = "http://localhost:63342/mall" . $uploadUrl . $fileDir . $img;

    // 文件上传验证
    $type = $file['type'];
    if (!in_array($type, array("image/png", "image/jpeg", "image/gif"))) {
        showMsg(0, "缩略图文件不合法，请重新上传");
    }
    // 文件上传
    if (!move_uploaded_file($file['tmp_name'], $imgPath)) {
        showMsg("服务器繁忙，请稍候再试");
    }
    return $imgUrl;
}

/**
 * 检查用户是否登录
 * @return bool
 */
function checkLogin()
{
    // 开启session
    session_start();

    // 判断用户是否登录
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        showMsg(0, "请登录", "login.php");
    }
    return true;
}

/**
 * 获取当前url
 * @return string
 */
function getUrl()
{
    $url = '';
    $url .= $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * 根据page生成url
 * @param $page
 * @param string $url
 * @return string
 */
function pageUrl($page, $url = '')
{
    $url = empty($url) ? getUrl() : $url;

    // 查询url是否存在
    $pos = strpos($url, '?');

    if ($pos == false) {
        $url .= "?page=" . $page;
    } else {
        $queryString = substr($url, $pos + 1);
        parse_str($queryString, $queryArr);
        if (isset($queryArr["page"]))
        {
            unset($queryArr["page"]);
        }
        $queryArr["page"] = $page;

        $queryStr = http_build_query($queryArr);

        $url = substr($url, 0, $pos) . "?" . $queryStr;
    }

    return $url;

}


/**
 * 根据逻辑分页显示
 * @param $total
 * @param $currentPage
 * @param $pageSize
 * @param int $showNum
 * @return string
 */
function getPages($total, $currentPage, $pageSize, $showNum = 5)
{
    $pageStr = '';

    // 当总数大于分页数时
    if ($total > $pageSize) {

        // 向上取整获取总页数
        $totalPage = ceil($total / $pageSize);

        // 对当前页进行容错处理
        $currentPage = $currentPage > $totalPage ? $totalPage : $currentPage;

        // 获取外层 div
        $pageStr .= "<div class=\"page-nav\"><ul>";

        $homePage = pageUrl(1);


        if ($currentPage > 1) {
            $nextPage = pageUrl($currentPage - 1);
            $pageStr .= "<li><a href=\"{$homePage}\">首页</a></li><li><a href=\"{$nextPage}\">上一页</a></li>";
        }

        // 1 2 3 4 5 6 7 8 9
        // 分页起始显示页面
        $from = max($currentPage - intval($showNum / 2), 1);
        $to = $from + ($showNum - 1);

        if ($to > $totalPage) {
            $to = $totalPage;
            $from = max($to - $showNum + 1, 1);
        }

        if ($from > 1) {
            $pageStr .= "<li>...</li>";
        }

        for ($i = $from; $i <= $to; $i++) {
            $page = pageUrl($i);
            if ($i != $currentPage) {
                $pageStr .= "<li><a href=\"{$page}\">{$i}</a></li>";
            } else {
                $pageStr .= "<li><span class=\"curr-page\">{$i}</span></li>";
            }
        }

        if ($to < $totalPage)
        {
            $pageStr .= "<li>...</li>";
        }

        $endPage = pageUrl($totalPage);

        if ($currentPage < $totalPage) {
            $upPage = pageUrl($currentPage + 1);
            $pageStr .= "<li><a href=\"{$upPage}\">下一页</a></li><li><a href=\"{$endPage}\">尾页</a></li>";
        }
        // 闭合 div 标签
        $pageStr .= "</ul></div>";
    }
    return $pageStr;
}




