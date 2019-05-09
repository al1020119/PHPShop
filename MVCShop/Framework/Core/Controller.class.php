<?php
/**
 *================================================================
 *  Controller.class.php 控制器基类
 * @Author: Happydong
 * @Date:   2017-07-24 21:05:37
 * @Last Modified by:   Happydong
 * @Last Modified time: 2017-07-25 19:43:53
 *================================================================
 */
class Controller {
    public function jump($url, $messages, $wait=2){
        if($wait == 0){
            header("Location:$url");
        }else{
            include CUR_VIEW_PATH . "messages.html";
        }
    }
    // 强制退出
    exit();
}