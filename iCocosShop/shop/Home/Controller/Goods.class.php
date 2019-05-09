<?php
class Goods extends Common
{
    /**
     * 显示商品页
     */
    public function index()
    {
        $str = 'status=2';
        $goods = new Model('goods');
        $type = new Model('type');

        //搜索名字在
        
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        // $reall = trim($_GET['name']);
        // var_dump($reall);
        // if($reall=''){
        //     $name = '';
        // }

        if($name !== ''){
            $str0 ="name like '%{$_GET['name']}%'";
            $g = $goods->where($str0)->select();
            if(empty($g)){
                $t = $type->where("name=\"{$_GET['name']}\"")->select();

                if(!empty($t)){
                    $t = $t[0];
                    $_GET['tid'] = $t['id'];
                    
                }
            }else{
                $str .=" and name like '%{$_GET['name']}%'";
            }
        }//var_dump($_GET['tid']);exit;
        //搜索类
        $_GET['tid'] = isset($_GET['tid'])?$_GET['tid']:'';
        if($_GET['tid']!=''){
            //要判断传过来的类型有没有子类，有的话将子类所有的商品查出来；如果没有子类，则直接差该分类下的商品
            
            $son = $type->where("pid={$_GET['tid']}")->select();
            if($son){
                //有子类，获取子类所有的id，并拼接为"1,2,3,4"这种格式
                $ids = join(array_column($son,'id'),',');
                $str .= " and tid in($ids)";
                
            }else {
                $str .= " and tid={$_GET['tid']}";
                // $qq = $type->where("id ={$_GET['tid']}");
                // $idd = $_GET['tid'].','.$ids;
                // $qq = $type->where("id in ($idd)");
            }
        }

        // //商品分类的传值
        // $tid = isset($_GET['tid'])?$_GET['tid']:'';
        // if($tid==''){
        //     $this->jump('请选择商品分类');
        //     exit;
        //     }else{
        //         $str .=" and tid="
        //     }

        

        //价格区间搜索
        $p1 = isset($_GET['p1']) ? $_GET['p1'] : '';
        $p2 = isset($_GET['p2']) ? $_GET['p2'] : '';
        if($p1 > $p2){
            $b = $p1;
            $p1 = $p2;
            $p2 = $b;
        }
        if($p1 < 0 || $p2 < 0)$this->alert('请输入不小于0的价格');
        if($p1 > $p2 )$this->jump('大小价格请勿混乱');
        if($p1 !== '') {
            if($p2 !==''){
            $str .=" and price between {$p1} and";
            }else{
                $str .=" and price > {$p1} ";    
            }
        }
        if($p2 !== '') {
            if($p1!==''){
            $str .=" {$p2}";
            }else{
                $str .=" and price < {$p2} ";
            }
        }

        //处理价格升降序
        $order = 'addtime desc';
        if(!empty($_GET['sortPrice'])){
            $order = $_GET['sortPrice'];
            unset($_GET['sortPrice']);
        }
        //处理库存升降序排列
        if(!empty($_GET['sortReserve'])){
            $order = $_GET['sortReserve'];
            unset($_GET['sortReserve']);
        }
        //处理购买量升降序
        if(!empty($_GET['sortBuy'])){
            $order = $_GET['sortBuy'];
            unset($_GET['sortBuy']);
        }
        //处理点击量排序
        if(!empty($_GET['sortClick'])){
            $order = $_GET['sortClick'];
            unset($_GET['sortClick']);
        }
        //a链接前台可以拼接进行传搜索条件之类的上一次get的参数。
        $now = http_build_query($_GET);

        //分页
        $total = $goods->where($str)->count();
        $page = new Page($total,10); 

        
        
        
        //var_dump($_GET);



        $arr = $goods->where($str)->order($order)->limit($page->limit)->select();
        $a = count($arr);
        //var_dump($str);
        if($str=="status=2"){
            $this->alert('无搜索条件');
        }
        include './View/Goods/index.html';

        if($arr=[]) header('location:home.html');
        //var_dump($a);
        //var_dump($_GET);
        //利用构造好的str进行where语句的查询
    }

    /**
     * 显示商品详情页
     */
    public function detail()
    {
        if (empty($_GET['id'])) header('location:index.php');


        //找出父类,面包屑
        //搜索类
        $type = new Model('type');
        $goods = new Model('goods');
        $a = $goods->find($_GET['id']);
        
        $a = $a['tid'];
        $b = $type->find($a);
        $num = substr_count($b['path'],',');//2
        //var_dump($num);
        
            
        if(!empty($a)){
            //要判断传过来的类型有没有子类，有的话将子类所有的商品查出来；如果没有子类，则直接差该分类下的商品
 
            for($i=0;$i<$num;$i++){
            $b = $type->find($a);
            
            $qq[] = $b;
            $a = $b['pid'];
                
            }
        }//var_dump($qq);
        //记录当前商品的id
        if(!isset($_SESSION['see'])){
            $_SESSION['see']=[];
        }
        if(!in_array($_GET['id'],$_SESSION['see'])){
        $_SESSION['see'][] = $_GET['id'];
        }else{
            $k = array_keys($_SESSION['see'],$_GET['id']);
            //var_dump($k);exit;
            unset($_SESSION['see'][$k[0]]);
            unset($k);
            $_SESSION['see'][] = $_GET['id'];
            //$k ='';
        }
        //找出当前商品的详情
        $mem = new Memcache;
        $mem->addServer('localhost',11211);
        $key = 'good_detail'.$_GET['id'];
        $info = $mem->get($key);
        if(!$info){
            echo '查询数据库的操作';
        $info = $goods->find($_GET['id']);
        if (empty($info)) header('location:index.php');
        $mem->set($key,$info,MEMCACHE_COMPRESSED);

        }

        //修改点击量
        $data['clicknum'] = $info['clicknum']+1;
        $data['id'] = $info['id'];
        $goods->save($data);

        //var_dump($_SESSION['see']);
        // var_dump($info);
        include './View/Goods/detail.html';
    }

    /**
     * 添加购物车
     */
    public function addShopcar()
    {
        if(empty($_GET['id'])) header('location:index.php');

        //找出当前商品的详情
        $goods = new Model('goods');
        $info = $goods->find($_GET['id']);
        //判断购物车是否存在当前的商品
        if(empty($_SESSION['shopcar'][$_GET['id']])){
            if(empty($info)) header('location:index.php');
            //加入购物车，数量1
            $info['num'] = $_GET['num'];
            $_SESSION['shopcar'][$_GET['id']] = $info;
        } else {
            //判断不能超出库存
            if($_SESSION['shopcar'][$_GET['id']]['num'] + $_GET['num']> $info['reserve']){
               
               $this->alert("不好意思，没那么多库存，您只能购买{$info['reserve']}件"); 
            }
            $_SESSION['shopcar'][$_GET['id']]['num'] +=$_GET['num'];
        }
        //var_dump($_GET);
        //var_dump($_SESSION['shopcar']);
        $this->alert('加入成功');
    }

    /**
     * 显示购物车列表
     */
    public function shopcar()
    {
        include './View/Goods/shopcar.html';
    }

    /**
     * 修改购物车数量
     */
    public function changeNum()
    {   
        $goods = new Model('goods');
        if(empty($_GET['fu'])||empty($_GET['id']))
            header('location:./Public/404.html');
        if ($_GET['fu'] == 'jia') {//添加数量
            //判断库存?
            $info = $goods->find($_GET['id']);
            if($info['reserve'] > $_SESSION['shopcar'][$_GET['id']]['num']){
            $_SESSION['shopcar'][$_GET['id']]['num'] += 1;
            }else{
                $this->alert('库存不足，超过最大购买量');
            }
        } else {
            //不能小于1?
            if($_SESSION['shopcar'][$_GET['id']]['num']>0){
            $_SESSION['shopcar'][$_GET['id']]['num'] -= 1;
            }else{
            $_SESSION['shopcar'][$_GET['id']]['num'] =0;
            }
        }

        //跳回去
        header('location:'.$_SERVER['HTTP_REFERER']);
    }

    /**
     * 删除购物车中的某件商品
     */
    public function delShopcar()
    {
        if (!empty($_GET['id'])) {
            unset($_SESSION['shopcar'][$_GET['id']]);
        }

        header('location:'.$_SERVER['HTTP_REFERER']);
    }

    /**
     * 清空购物车
     */
    public function delAll()
    {
        unset($_SESSION['shopcar']);
        header('location:index.php?c=Goods&a=shopcar');
    }

    /**
     * 清空浏览历史
     */
    public function delSee()
    {
        $_SESSION['see']=[];
        $this->alert('清除成功');
        
    }

    /**
     * 热门商品
     */
    public function HOT()
    {
        $goods = new Model('goods');
        $arr = $goods->order('buynum desc')->limit('5')->select();
        $total = $goods->where($str)->count();
        $page = new Page($total,5); 

        
        
        
        //var_dump($_GET);

        

        
        $a = count($arr);
        include './View/Goods/index.html';

        if($arr=[]) header('location:home.html');

        include './View/Goods/index.html';
    }
}