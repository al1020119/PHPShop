<?php
class Common
{
    /**
     * 辅助方法用于出错跳转
     */
    protected   function jump($str,$url = '')
    {
        if (empty($url)) $url = $_SERVER['HTTP_REFERER'];

        echo $str.'，<a href="'.$url.'">跳转中...</a>';
        echo '<meta http-equiv="refresh" content="3;url='.$url.'">';
        exit;
    }

    /**
     * 弹窗提示
     * @param  string $str 提示信息
     * @param  string $url 跳转地址
     */
    protected function alert($str, $url = '')
    {
        if (empty($url)) $url = $_SERVER['HTTP_REFERER'];
        echo "<script>alert('$str');location.href='$url'</script>";
        exit;
    }

    //  /**
    //  * 友情广告
    //  */
    // protected   function jump($str,$url = '')
    // {
    //     if (empty($url)) $url = $_SERVER['HTTP_REFERER'];

    //     echo $str.'，<a href="'.$url.'">跳转中...</a>';
    //     echo '<meta http-equiv="refresh" content="3;url='.$url.'">';
    //     exit;
    // }
}