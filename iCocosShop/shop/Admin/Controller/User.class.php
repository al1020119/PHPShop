<?php

class User extends Common
{   
    
    //默认a选择调用了index实现首页的显示
    //
    public function index()
    {

        $user = new Model('user');
        $str = '1=1';
        //姓名处理
        $username = isset($_GET['username']) ? $_GET['username'] : '';
        if($username !== '')
            $str .=" and username like '%{$_GET['username']}%'";      
        //性别处理
        $sex = isset($_GET['sex']) ? $_GET['sex'] : '';
        if($sex !== '') 
            $str .=" and sex={$_GET['sex']}";
        //分页处理
        $total = $user->where($str)->count();
        $page = new Page($total,5);
        $arr = $user->where($str)->limit($page->limit)->order('role desc,id desc')->select();
        //将前端的页面代码包含了进去
        include'./View/User/list.html';
        //var_dump($page->current);

    }

    /**
     * 删除功能
     */
    
    public function del()
    {   //  先进行了id的判断来进行跳转
        if(empty($_GET['id'])) header('location:'.$SERVER['HTTP-REFERER']);

        $user = new Model('user');
        if($_GET['id']!='59'){

        $user->delete($_GET['id']);
        }

        header('location:'.$_SERVER['HTTP_REFERER']);

    }


    /**
     * 添加功能中的信息填写界面
     */
    
    public function add()
    {
        include 'View/User/add.html';
    }


    /**
     * 添加的操作方法
     * 
     */
    public function doAdd()
    {   
        $username= isset($_POST['username']) ? $_POST['username']:'';
        if($username=='') {
            $this->jump('用户名不能为空');
        }else if(!preg_match('/^[\w\x{4e00}-\x{9fa5}]{3,18}$/u', $_POST['username']))
        {
            $this->jump('请输入3~18位的字母数字下划线或者中文');  
        }

        //判断用户名是否存在 
        $user = new Model('user');
        if($user->where("username='{$_POST['username']}'")->select()){
            $this->jump('用户名已存在');
        }

        //判断密码是否为空，
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        if($pwd == ''){
            $this->jump('密码不能为空');
            exit;
        }
        //判断两次密码是否一致
        if ($_POST['pwd'] != $_POST['pwd2']) {
            $this->jump('两次密码不一致');
        }

        //密码正则
        if(!preg_match('/^\w{3,18}$/u', $_POST['pwd'])){
            $this->alert('请输入3~18位的字母、数字、下划线的密码');    
            exit;
        }

        //开干
        $_POST['pwd']=md5($_POST['pwd']);
        $_POST['addtime'] = time();
        
        if($user->add($_POST)){
            $this->jump('添加成功','index.php?c=User&a=index');
        }else {
            $this->jump('添加失败');
        }
    }

    /**
     * 修改功能
     */
    public function save()
    {
        if(empty($_GET['id']))header('location:index.php');
        $user = new Model('user');
        $arr = $user->find($_GET['id']);
        if(empty($arr)) $this->jump('非法访问','index.php');
        include './View/User/save.html';
    }

    /**
     * 处理修改
     * @return [type] [description]
     */
    public function doSave()
    {   
        //接收id
        if(empty($_POST['id'])) header('location:index.php');
        //var_dump($_POST);
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        if ($pwd !=='') {
            //判断两次密码是否一致
            if ($_POST['pwd'] != $_POST['pwd2']) {
                $this->jump('两次密码不一致');
            }
            
        } else {
            unset($_POST['pwd']);
        }
        if(!preg_match('/^\w{3,18}$/u', $_POST['pwd'])){
            $this->jump('请输入3~18位的字母、数字、下划线的密码');

        }
// var_dump($_POST['id']);
        $_POST['pwd'] = md5($_POST['pwd']);
        //判断用户名是否存在
       
        $user = new Model('user');
        $res = $user->where("username='{$_POST['username']}' and id<>{$_POST['id']}")->select();
        if($res){
            $this->jump('用户名已存在');
        }

        //判断年龄是否合理
        $age = isset($_POST['age']) ? $_POST['age']:'';
        if($age != ''){
            if($_POST['age']>250 || $_POST['age']<0){
                $this->jump('请输入合理的年龄');
            }
        } else {
            unset($_POST['age']);
        }

        //判断手机不为空的时候是否合法
        if(!empty($_POST['phone'])){
            if(!preg_match('/^(1[358]\d|147|17[789])\d{8}$/',"{$_POST['phone']}"))
                $this->jump('手机号码不合理');

        }else{
            unset($_POST['phone']);
        }


        //判断邮箱不为空的时候是否合法
        if(!empty($_POST['email'])){
            if(!preg_match('/^[0-9a-z_][_.0-9a-z-]{0,32}@([0-9a-z][0-9a-z-]{0,32}\.){1,4}[a-z]{2,4}$/i',"{$_POST['email']}")){
                $this->jump('请输入正确的邮箱');
            }
        }else{
            unset($_POST['email']);
        }

        //var_dump($_POST);

        //开始处理
        if($_POST['id'] == '59'){
            $this->jump('上帝无法修改');
        }
        if ($user->save($_POST)) {
            $this->jump('修改成功','index.php?c=User&a=index');
        }else{
            $this->jump('您什么都没有改到');
        }
    }


    /**
     * 处理状态
     */
    public function doStatus()
    {
        if(empty($_GET['id']))header('location:index.php');
        if($_GET['id']!='59'){
        $user = new Model('user');
        $user->save($_GET);
    }
        header("location:".$_SERVER['HTTP_REFERER']);
    }

    

}

//index.php?p={$_GET['p']}