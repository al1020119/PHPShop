<?php
class Friend extends Common
{   
    /**
     * 友情列表页
     * @return [type] [description]
     */
    public function index(){
        
        $friend = new Model('friend');
        $arr = $friend->select();

        include './View/Friend/list.html';
    }
    /**
     * 友情添加页
     */
    public function add(){
       include './View/Friend/add.html'; 
    }

    /**
     * 友情添加处理
     * @return [type] [description]
     */
    public function doAdd(){
        //名字判断检测
        $name = isset($_POST['name'])?$_POST['name']:'';
        if ($_POST['name']=='') {
            $this->jump('友情名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('友情名不合法，请输入字母、数字、下划线或者中文');
        }

        //图片处理
         $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        
        if(!$pic = $up->up()){
            $this->jump($up->errInfo);
        }
        $_POST['pic'] = $pic;

        $friend = new Model('friend');
        if($friend->add($_POST)){
            $this->jump('添加成功','index.php?c=Friend&a=index');
        }else{
            // $this->jump('添加失败');
            var_dump($_POST);
        }
    }

    /**
     * 删除处理
     */
    public function del(){
        $friend = new Model('friend');

        if(empty($_GET['id'])){
            $this->jump('无id');
        }
        //删除的时候顺便删除图片
        $img = $friend->find($_GET['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
        }
        
        if($friend->delete($_GET['id'])){
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
        $friend = new Model('friend');  
        $arr = $friend->find($_GET['id']);
        //var_dump($arr);
        include '/View/Friend/edit.html';
        
    }

    public function doEdit(){

        //id
        if(empty($_POST['id'])) {header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }

        //友情名检测
        $name = isset($_POST['name']) ? $_POST['name'] :'';
        if ($name == '') {
            $this->jump('友情名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('友情名不合法，请输入字母、数字、下划线或者中文');
        }

        //图片修改
        $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        if (!($pic = $up->up())) {
            unset($_POST['pic']);
        }else{
        $_POST['pic'] = $pic;//将新的图片名给post里pic其替换goods内的信息
        //替换之后
        $friend= new Model('friend');
        $img = $friend->find($_POST['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
            }
        }   
        $friend= new Model('friend');
        if($friend->save($_POST)){
            $this->jump('修改成功','index.php?c=Friend&a=index');
        }else {
            $this->jump('您没修改到任何东西');
        }

    }


    /**
     * 处理状态
     */
    public function doStatus()
    {
        if(empty($_GET['id']))header('location:index.php');
        
        $friend = new Model('friend');
        $friend->save($_GET);
    
        header("location:".$_SERVER['HTTP_REFERER']);
    }
}