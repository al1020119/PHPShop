<?php
class Orders extends Common
{
    public function index()
    {
        $orders = new Model('orders');
        $str = '1=1';
        //根据用户查看相关订单
        $getman = isset($_GET['getman']) ? $_GET['getman'] : '';
        if($getman !== '')
            $str .=" and getman like '%{$_GET['getman']}%'";
        //根据状态查询
        $status = isset($_GET['status'])?$_GET['status'] : '';
        if($status !== ''){
            $str .=" and status={$status}";
        }

        //默认根据订单升序，因为越早下单就越需要早发货
        $order = 'addtime';

        //分页
        $total = $orders->where($str)->count();
        $page = new Page($total,5);
        $arr = $orders->where($str)->order($order)->limit($page->limit)->select();
        include './View/Orders/list.html';

    }


    /**
     * 删除订单
     * @return [type] [description]
     */
    public function del()
    {   //  先进行了id的判断来进行跳转
        if(empty($_GET['id'])){ header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }
        
        $orders = new Model('orders');
        $detail = new Model('detail');
        

        if($orders->delete($_GET['id'])){

            if($detail->where("oid={$_GET['id']}")->delete()){
                $this->jump('删除成功');
            }else{
                $this->alert('删除失败');
            }
        }else{
            var_dump($order->_sql());
            //$this->alert('删除失败！');
        }
        
    }
    /**
     * 订单详情
     * @return [type] [description]
     */
    public function showDetail()
    {
        if(empty($_GET['id'])){ header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }
        $orders = new Model('orders');
        $info = $orders->find($_GET['id']);
        $detail = new ModeL('detail');
        $arr = $detail->where("oid={$_GET['id']}")->select();
        //var_dump($arr);
        //var_dump($info);
        include './View/Orders/detail.html';
    }

    /**
     * 订单修改功能
     */
    public function save()
    {   
        if(empty($_GET['id'])){ header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }
        $orders = new Model('orders');
        $arr = $orders->find($_GET['id']);
        //var_dump($arr);
        include'./View/Orders/save.html';
    }

    /**
     * 修改订单操作
     */
    public function doSave()
    {
        //var_dump($_POST);
        $orders = new Model('orders');
        if(empty($_POST['id'])){ header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }

        //判断手机不为空的时候是否合法
        if(!empty($_POST['phone'])){
            if(!preg_match('/^(1[358]\d|147|17[789])\d{8}$/',"{$_POST['phone']}"))
                $this->jump('手机号码不合理');

        }else{
            unset($_POST['phone']);
        }

        //判断收货地址
        if(empty($_POST['address'])){
            $this->alert('地址不能为空');
        }
        

        //判断邮箱不为空的时候是否合法
        if(!empty($_POST['email'])){
            if(!preg_match('/^[0-9a-z_][_.0-9a-z-]{0,32}@([0-9a-z][0-9a-z-]{0,32}\.){1,4}[a-z]{2,4}$/i',"{$_POST['email']}")){
                $this->jump('请输入正确的邮箱');
            }
        }else{
            unset($_POST['email']);
        }
        //开干
        if($orders->save($_POST)){
            $this->jump('修改成功','index.php?c=Orders&a=index');

        }else {
            $this->jump('下单失败');
        }
    }

    /**
     * 发货
     */
    public function fa()
    {
        if(empty($_GET['id'])){ header('location:'.$_SERVER['HTTP_REFERER']);
        exit;
        }
        $arr['id'] = $_GET['id'];
        $arr['status'] = 3;
        var_dump($arr);
        $type = new Model('orders');
        if($type->save($arr)){
            $this->alert('发货成功');
        }else{
            //$this->alert('发货失败');
        }
    }

    
    
}
