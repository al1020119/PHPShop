<?php
class Guanggao extends Common
{   
    /**
     * 广告列表页
     * @return [type] [description]
     */
    public function index(){
        
        $guang = new Model('guanggao');
        $arr = $guang->select();

        include './View/Guanggao/list.html';
    }
    /**
     * 广告添加页
     */
    public function add(){
       include './View/Guanggao/add.html'; 
    }

    /**
     * 广告添加处理
     * @return [type] [description]
     */
    public function doAdd(){
        //名字判断检测
        $name = isset($_POST['name'])?$_POST['name']:'';
        if ($_POST['name']=='') {
            $this->jump('广告名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('广告名不合法，请输入字母、数字、下划线或者中文');
        }

        //图片处理
         $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        
        if(!$pic = $up->up()){
            $this->jump($up->errInfo);
        }
        $_POST['pic'] = $pic;

        $guang = new Model('guanggao');
        $num = $guang->count();
        if($num >= 5){
            $this->alert('最多添加五条轮播图','index.php?c=Guanggao&a=index');
        }
        if($guang->add($_POST)){
            $this->jump('添加成功','index.php?c=Guanggao&a=index');
        }else{
            // $this->jump('添加失败');
            var_dump($_POST);
        }
    }

    /**
     * 删除处理
     */
    public function del(){
        $guang = new Model('guanggao');

        if(empty($_GET['id'])){
            $this->jump('无id');
        }
        //删除的时候顺便删除图片
        $img = $guang->find($_GET['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
        }
        
        if($guang->delete($_GET['id'])){
            header('location:'.$_SERVER['HTTP_REFERER']);
        }else {
            $this->jump('删除失败');
        }

         
        
    }

    /**
     * 修改商品
     */
    
    public function edit()
    {
        //修改操作需要进行界面的遍历所以用Model类中的find()方法
        $guang = new Model('guanggao');  
        $arr = $guang->find($_GET['id']);
        //var_dump($arr);
        include '/View/Guanggao/edit.html';
        
    }

    public function doEdit(){

        //id
        if(empty($_POST['id'])) {header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }

        //广告名检测
        $name = isset($_POST['name']) ? $_POST['name'] :'';
        if ($name == '') {
            $this->jump('广告名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('广告名不合法，请输入字母、数字、下划线或者中文');
        }

        //图片修改
        $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        if (!($pic = $up->up())) {
            unset($_POST['pic']);
        }else{
        $_POST['pic'] = $pic;//将新的图片名给post里pic其替换goods内的信息
        //替换之后
        $guang= new Model('guanggao');
        $img = $guang->find($_POST['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
            }
        }   
        $guang= new Model('guanggao');
        if($guang->save($_POST)){
            $this->jump('修改成功','index.php?c=Guanggao&a=index');
        }else {
            $this->jump('您没修改到任何东西');
        }

    }

    /**
     * 头部广告
     */
    public function home(){
        $top = new Model('tops');
        $arr = $top->select();
        
        //var_dump($arr);
        include './View/Tops/list.html';
    }

    /**
     * 改变头部显示状态
     */
    public function doStatus()
    {
       if(empty($_GET['id']))header('location:index.php');
    
        $top = new Model('tops');
        $top->save($_GET);
    
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    /**
     * 修改头部广告页
     */
    public function gai()
    {   
        $top = new Model('tops');
        $arr = $top->find($_GET['id']);
        //var_dump($arr);
        include './View/Tops/edit.html';
    }

    /**
     * 修改头部
     */
    public function doGai()
    {
        //id
        if(empty($_POST['id'])) {header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }

        //广告名检测
        $name = isset($_POST['name']) ? $_POST['name'] :'';
        if ($name == '') {
            $this->jump('广告名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('广告名不合法，请输入字母、数字、下划线或者中文');
        }

        //图片修改
        $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        if (!($pic = $up->up())) {
            unset($_POST['pic']);
        }else{
        $_POST['pic'] = $pic;//将新的图片名给post里pic其替换goods内的信息
        //替换之后
        $top= new Model('tops');
        $img = $top->find($_POST['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
            }
        } 
        //var_dump($_POST);exit;  
        $top= new Model('tops');
        if($top->save($_POST)){
            $this->jump('修改成功','index.php?c=Guanggao&a=home');
        }else {
            $this->jump('您没修改到任何东西');
        }
    }
}
