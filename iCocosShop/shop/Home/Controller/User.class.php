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
        //include'./View/User/list.html';
        //var_dump($page->current);

    }

    
    


    /**
     * 添加功能中的信息填写界面
     */
    
    public function add()
    {
        include 'View/User/register.html';
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

        //判断验证码
        if (strtolower($_POST['yzm']) != strtolower($_SESSION['code'])) {
            $this->alert('验证码错误');
        }

         //勾选条款
            if (empty($_POST['yes'])) {
            $this->alert('请同意老子的霸王条款');
        }
        //开干
        $_POST['pwd']=md5($_POST['pwd']);
        $_POST['addtime'] = time();
        
        if($user->add($_POST)){
            $this->jump('注册成功','index.php?c=Home&a=index');
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
        // var_dump($_POST);exit;
        $user = new Model('user');

        //接收id
        if(empty($_POST['id'])) header('location:index.php');

       
       
// var_dump($_POST['id']);
        
        
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
        if ($user->save($_POST)) {
            $this->jump('修改成功','index.php?c=User&a=person');
        }else{
            $this->jump('您什么都没有改到');
        }
    }

    /**
     * 个人主页
     */
    public function person()
    {   
        if(empty($_SESSION['username'])){
            $this->alert('请登录后浏览');
        }
        $user = new Model('user');
        $arr = $user->find($_SESSION['username']['id']);
        unset($arr['pwd']);
        //var_dump($arr);
        $sexs = ['女','男','妖','gay'];
        include './View/User/person.html';
    }

    /**
     * 修改密码功能
     */
    public function safe()
    {
        if(empty($_GET['id']))header('location:index.php');
        $user = new Model('user');
        $arr = $user->find($_GET['id']);
        if(empty($arr)) $this->jump('非法访问','index.php');
        include './View/User/safe.html';
    }


    public function doSafe()
    {
        //var_dump($_POST);
        $user = new Model('user');

        //接收id
        if(empty($_POST['id'])) header('location:index.php');

        $info = $user->find($_POST['id']);
        // var_dump($info);
        // exit;
        //var_dump($info);
        if(!empty($_POST['pwd0'])){
            if($info['pwd']!==md5($_POST['pwd0']))
                $this->alert('原密码错误');
        }else{
            $this->alert('请输入原密码');
        }
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        if ($pwd !=='') {
            //判断两次密码是否一致
            if ($_POST['pwd'] != $_POST['pwd2']) {
                $this->jump('两次密码不一致');
            }
             if(!preg_match('/^\w{3,18}$/u', $_POST['pwd'])){
            $this->jump('请输入3~18位的字母、数字、下划线的密码');
            
            }
            $_POST['pwd'] = md5($_POST['pwd']);
        } else {
            unset($_POST['pwd']);
        }

        //开始处理
        if ($user->save($_POST)) {
            $this->jump('修改成功','index.php?c=User&a=person');
        }else{
            //$this->jump('您什么都没有改到');
        }
    }

    //收货地址显示
    public function address()
    {   
        $user = new Model('user');
        $info = $user->find($_SESSION['username']['id']);
        $address = new Model('address');
        $arr = $address->where("uid={$info['id']}")->order('id desc ')->select();
        include'./View/User/address.html';
    }

    /**
     * 收货地址修改
     */
    public function doAddress()
    {
        //var_dump($_POST);
        if(empty($_POST['address'])){
            $this->alert('地址不能为空');
        }
        $address = new Model('address');
        if($address->save($_POST)){
            $this->alert('修改成功');
        }else{
            $this->alert('修改失败');
        }
    }
    
    /**
     * 删除地址
     */
    
    public function delAddress()
    {
        //var_dump($_GET['id']);
        if(empty($_GET['id'])){
            $this->alert('未知错误');
        }

        $address = new Model('address');
        if($address->delete($_GET['id'])){
            $this->alert('删除成功');
        }else{
             $this->alert('删除失败');
        }
    }

    /**
     * 添加地址
     */
    
    public function addAddress()
    {
        //var_dump($_POST);
        $address = new Model('address');
        $a = $address->where("uid={$_POST['uid']}")->count();
        //var_dump($a);
        if($a >= 5){
            $this->alert('地址最多添加5条');
        }
        if(empty($_POST['uid'])){
            $this->alert('非法操作');
        }

        if(empty($_POST['address'])){
            $this->alert('请填写地址');
        }
        $arr['uid'] = $_POST['uid'];
        $arr['address'] = $_POST['address'];
        //var_dump($arr);
        if($address->add($arr)){
            $this->alert('添加成功');
        }else{
            $this->alert('添加失败');
        }
    }

    /**
     * 设置默认地址
     */
    public function gai()
    {
        //var_dump($_GET);
        if(empty($_GET['id'])){
            $this->alert('非法操作');
        }
        $address = new Model('address');
        $a = $address->where("uid={$_GET['uid']} and status=1")->select();
        //var_dump($a[0]);
        
        if(!empty($a)){
            $a = $a[0];
            $arr['status']=0;
            $arr['id']=$a['id'];
            $address->save($arr);

            $abb['id'] = $_GET['id'];
            $abb['status'] = 1;
            if($address->save($abb)){
                $this->alert('设置成功');
            }else{
                $this->alert('设置错误');
            }

        }else{
            $abb['id'] = $_GET['id'];
            $abb['status'] = 1;
            if($address->save($abb)){
                $this->alert('设置成功');
            }else{
                $this->alert('设置错误');
            }
        }


    }

}

//index.php?p={$_GET['p']}