<?php
class Type extends Common
{   
    /**
     * 展示分类页
     */
    public function index()
    {
        
        $type = new Model('type');
        
        $arr = $type->order('concat(path,id)')->select();
        include './View/Type/list.html';
    }
    //添加表单的页面
    public function add()
    {
        //有传id就是添加子类，没传id就是添加顶级分类
        if(!empty($_GET['id'])){
            $type= new Model('type');
            $info = $type->find($_GET['id']);
            if(empty($info)) {
                error_log('脑残的'.$_SESSION['username'].'乱来');
                $this->jump('非法访问','index.php?c=Login&a=logout');
            }
        }

        include './View/Type/add.html';
    }

    /**
     * 处理添加分页
     * 
     */
    public function doAdd()
    {
        //var_dump($_POST);
        //商品名不填的处理
        if(empty($_POST['name'])){
            $this->jump('商品分类不能为空');
            } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]{1,18}$/u', $_POST['name'])) {
            $this->jump('请输入1~18位的字母、数字、下划线或者中文');
            }
        

        $type = new Model('type');
        if($type->add($_POST)){
            $this->jump('添加成功', 'index.php?c=Type&a=index');
        }else{
            $this->jump('添加失败');
        }

    }

    public function del()
    {   //  先进行了id的判断来进行跳转
        if(empty($_GET['id'])) {header('location:'.$SERVER['HTTP-REFERER']);
        exit;
        }
        

        $type = new Model('type');
        $son = $type->where('pid='.$_GET['id'])->select();
        if(!empty($son)){
            $this->alert('请先删除子类');
        }

        $goods = new Model('goods');
        $res = $goods->where("tid={$_GET['id']}")->select();
        if(!empty($res)){
            $this->jump('此类里面有商品不可删除');
        }
        $type->delete($_GET['id']);
        header('location:'.$_SERVER['HTTP_REFERER']);

    }
    /**
     * 显示修改的表单页
     * @return [type] [description]
     */
    public function edit()
    {
        //判断非法访问
        if(empty($_GET['id'])) header('location:index.php');
        $type= new Model('type');
        $arr = $type->find($_GET['id']);
        if(empty($arr)) $this->jump('非法访问','index.php');
        include '/View/Type/edit.html';
    }
    /**
     * 处理编辑
     * @return [type] [description]
     */
    public function doEdit()
    {   
        if(empty($_POST['id'])) {header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
    }
        
       
        $type= new Model('type');

        if($type->save($_POST)){
            $this->jump('修改成功','index.php?c=Type&a=index');
        }else{
            $this->jump('您什么也没有修改到');
        }
        
    }

}