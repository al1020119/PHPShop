<?php
/**
 * 登陆控制器
 */
class Login extends Common
{
    /**
     * 显示登陆界面
     */
    function index()
    {
        include'./View/Login/login.html';
    }

    /**
     * 处理登录
     */
    public function doLogin()
    {
        //判断用户名和密码是不是为空
        
        $user = new Model('user');
        $info = $user->where("username='{$_POST['username']}'")->limit(1)->select();
        
        $uid =$info[0]['id'];
        
        //检查用户最近30分钟密码错误次数
        $res = $this->checkPassWrongTime($uid);
        // echo '<pre>';
        // print_r($res);
        //错误次数超过限制次数
        if ($res === false){
           $this->jump('密码输出错误次数超过3次，被限制');
            exit;
        }
        
        if(empty($info)){
            echo '<script>alert("用户名或密码错误");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
            exit;
        }else {
            $info = $info[0];
            if($info['pwd'] != md5($_POST['pwd'])){
                $this->recordPassWrongTime($uid);
                $num = $res + 1; 
                $num2 = 3 - $num;
               $this->alert("30分钟内输错密码{$num}次,还剩下{$num2}次");
               
                exit; 
            }
        }
            // //判断角色
            // if($info['role'] !=='2'){
            //     echo '<script>alert("无权限登录此系统");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
            //     exit;
            // }
        
            //判断状态
            if($info['status']=='2'){
                echo '<script>alert("被禁用的用户，无法登陆！");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
            exit;
            }
            //判断通过
            if($_SESSION['username']=$info){ 
                header('location:index.php');
            }
        
    }


//记录密码输出信息
    protected function recordPassWrongTime($uid)
    {

        //ip2long()函数可以将IP地址转换成数字
        $ip =$_SERVER['REMOTE_ADDR'];

        $time =time();
        $sql = "insert into user_login_info(uid,ipaddr,logintime,pass_wrong_time_status) values($uid,'{$ip}','{$time}',2)";
        $dns = "mysql:host=localhost;dbname=shop;charset=utf8";
        $pdo = new PDO($dns,'root','123456'); 
        $pdo->setAttribute(3,1);
        $stmt = $pdo->exec($sql);

        

       
    }
    /**
     * 检查用户最近$min分钟密码错误次数
     * $uid 用户ID
     * $min  锁定时间
     * $wTIme 错误次数
     * @return 错误次数超过返回false,其他返回错误次数，提示用户
     */
    protected function checkPassWrongTime($uid, $min=30, $wTime=3)
    {

        // echo '<pre>';
        // print_r($uid);

        $time = time();
        $prevTime = time() - $min*60;

        //用户所在登录ip
        $ip =$_SERVER['REMOTE_ADDR'];


        //pass_wrong_time_status代表用户输出了密码
        $sql = "select * from user_login_info where uid={$uid} and pass_wrong_time_status=2 and logintime between $prevTime and $time and ipaddr='{$ip}'";


        $dns = "mysql:host=localhost;dbname=shop;charset=utf8";
        $pdo = new PDO($dns,'root','123456'); 
        $pdo->setAttribute(3,1);
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        

        

        
        //统计错误次数
        $wrongTime = count($data);
        // echo '<pre>';
        // print_r($wrongTime);
        // exit;
        //判断错误次数是否超过限制次数
        if ( $wrongTime>$wTime-1 ) {
            return false;
        }

        return $wrongTime;

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