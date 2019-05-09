<?php

class Orders extends Common
{

    /**
     * 判断是否登录的构造方法
     */
    public function __construct()
    {
        if (empty($_SESSION['username'])) {
            $this->alert('请先登录', 'index.php?c=Login&a=index');
            exit;
        }
    }

    /**
     * 显示结算界面
     */
    public function add(){
        //var_dump($_GET);
        if($_GET['t']==0){
            $this->alert('购物车为空');
        }
        if(empty($_SESSION['username'])){
            $this->alert('请登录','index.php?c=Login&a=index');
            exit;
        }
        if(empty($_SESSION['shopcar'])){
            $this->alert('购物车空空如也，先逛逛吧');
        }
        //地址遍历
        $address = new Model('address');
        $arr = $address->where("uid={$_SESSION['username']['id']}")->select();
        include './View/Orders/add.html';
    }

    /**
     * 处理添加订单
     */
    
    public function doAdd()
    {
        //判断收件人
        if(empty($_POST['getman'])) {
            $this->alert('用户名不能为空');
        }
        //判断手机号
        if(empty($_POST['phone'])) {
            $this->alert('电话号码不能为空');
        }elseif(!preg_match('/^(1[358]\d|147|17[789])\d{8}$/',"{$_POST['phone']}")){
            $this->alert('请输入正确的电话号码格式');
        }
        //判断收货地址
        if(empty($_POST['address'])){
            $this->alert('地址不能为空');
        }
        //判断通过,追加数据
       $_POST['uid'] = $_SESSION['username']['id'];
        $_POST['addtime'] = time();

        //计算总价
        $goods = new Model('goods');
        $total = 0;
        foreach ($_SESSION['shopcar'] as $v) {
            $p = $goods->field('price')->find($v['id'])['price'];
            $total += $p * $v['num'];
        }
        $_POST['total'] = $total;

        $orders = new Model('orders');
        if ($orders->add($_POST)) {
            //订单添加成功，遍历购物车，添加订单详情
             $detail = new Model('detail');
             $arr['oid'] = $orders->lastInsertId();
        //下单成功后要追加订单商品详情
        foreach($_SESSION['shopcar'] as $v)
        {
            
            
            $arr['gid'] = $v['id'];
            $arr['num'] = $v['num'];
            $arr['name'] = $v['name'];
            $arr['pic'] = $v['pic'];
            $arr['price'] = $v['price'];
            //var_dump($arr1);
            $i = $detail->add($arr);
            //构成sql语句。应为继承关系我们可以找到系统的PDO类，所以直接用exec的方法来进行数据库操作。
            $sql = "UPDATE ".FIX."goods set buynum=buynum+{$v['num']},reserve=reserve-{$v['num']} where id={$v['id']}";
            if($i <= 0 || $orders->exec($sql) <= 0){
                //出意外要删除详情表和订单表,这里重新写了Model类里面的delete方法
                $detail->where("oid={$arr['oid']}")->delete();
                //删除订单表
                $orders->delete($arr['oid']);
                //var_dump($orders->_sql());
                $this->alert('下单时失败,请稍后再试');
            }
        }
        unset($_SESSION['shopcar']);

        
        $this->alert('下单成功!请立即支付','index.php?c=Orders&a=ok&oid='.$arr['oid'].'&total='.$total);
        } else {
            //var_dump($_POST);
            // var_dump($orders->_sql());
            $this->alert('下蛋失败，服务器繁忙');
        }
    }

    /**
     * 显示下单成功页面
     */
    public function ok()
    {
        //传订单号和总价
        if (empty($_GET['oid']) || empty($_GET['total'])) header('location:./Public/404.html');
        include './View/Orders/ok.html';
    }


    /**
     * 我的订单显示页
     */
    public function Detail()
    {       

        $orders = new Model('orders');
        $detail = new Model('detail');
        $arr = $orders->where("uid={$_SESSION['username']['id']} and shows=0")->order('id desc')->select();
        //统计订单数
        $a = count($arr);
        //var_dump($arr);
        $info = $detail->select();
        include'./View/Orders/detail.html';
    }

    /**
     * 订单操作
     */
    public function doDetail()
    {
        $orders = new Model('orders');
        $detail = new Model('detail');
        var_dump($_GET['id']);
        if(empty($_GET['id'])){
            $this->alert('非法操作');
        }
        $info = $detail->select();
        //删除订单的时候，同时删除订单详情表的商品信息
        if($orders->delete($_GET['id'])){
            foreach($info as $v){
                if($v['oid']==$_GET['id']){
                    $detail->delete($v['id']);
                }
            }
            $this->alert('删除成功');
        }else {
            $this->alert('删除失败,系统繁忙！');
        }
    }
    /**
     * 付款成功修改订单状态
     */
    public function status()
    {
        if(empty($_GET['id'])){
            header('location:./Public/404.html');
        }
        $orders = new Model('orders');
        //var_dump($_GET);
        $arr['id'] = $_GET['id'];
        $arr['status'] = 2;
        if($orders->save($arr)){
            $this->jump('下单成功','index.php?c=Orders&a=detail');
        }else{
            $this->jump('下单失败');
        }
    }
    /**
     * 收货确认
     */
    public function getHuo()
    {
        if(empty($_GET['id'])){
            header('location:./Public/404.html');
            exit;
        }
        $arr['id'] = $_GET['id'];
        $arr['status'] = 4;
        $orders = new Model('orders');
        if($orders->save($arr)){
            $this->alert('收货成功');
        }else{
            $this->alert('收货失败');
        }
    }

    /**
     * 删除订单，即用户看不到他删除的订单，但是我们数据库还是存在这个订单
     */
    public function shows()
    {
        if(empty($_GET['id'])){ header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }
        $arr['id'] = $_GET['id'];
        $arr['shows'] = 1;
        $orders = new Model('orders');
        if($orders->save($arr)){
            $this->alert('删除成功');
        }else{
            $this->alert('删除失败');
        }

    }
    
}