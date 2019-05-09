<?php
/**
 * 登陆控制器
 */
class Login
{
    /**
     * 显示登陆界面
     */
    function index()
    {
        include'./View/Login/index.html';
    }

    /**
     * 处理登录
     */
    public function doLogin()
    {
        //判断用户名和密码是不是为空
        
        $user = new Model('user');
        $info = $user->where("username='{$_POST['username']}'")->limit(1)->select();
        

        
        if(empty($info)){
            echo '<script>alert("用户名或密码错误");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
            exit;
        }else {
            $info = $info[0];
            if($info['pwd'] != md5($_POST['pwd'])){
               echo '<script>alert("用户名或密码错误");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
               
                exit; 
            }
            //判断角色
            if($info['role'] !=='2'){
                echo '<script>alert("无权限登录此系统");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
        
            //判断状态
            if($info['status']=='2'){
                echo '<script>alert("被禁用的用户，无法登陆！");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
            exit;
            }
            //判断通过
            if($_SESSION['username']=$info) 
                header('location:index.php');
        }
    }


    
    public function logout()
    {
        unset($_SESSION['username']);
        if(isset($_COOKIE[session_name()]))
        setCookie(session_name(),'',-1,'/');
        session_destroy();
        header('location:index.php');
    }
}