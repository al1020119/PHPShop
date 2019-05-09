<?php
class Home extends Common
{
    public function index(){
        //轮播图广告遍历    
        $guang = new Model('guanggao');
        $arr =$guang->order('orders')->select();
        //下方商品遍历
        $goods = new Model('goods');
        $info = $goods->where('tid=30')->select();
        
        include './View/Home/home.html';
    }


}