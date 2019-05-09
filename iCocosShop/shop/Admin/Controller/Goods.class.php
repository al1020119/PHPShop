<?php
class Goods extends Common
{
    /**
     * 展示商品列表
     * @return [type] [description]
     */
	public function index()
	{
		
		$goods = new Model('goods');

        //遍历查询的类别下拉框
        $type = new Model('type');
        $types = $type->order('concat(path,id)')->select();

        //str语句的构造
		$str = '1=1';

		//对没有get到name和tid的时候进行填坑
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        if($name !== '')
            $str .=" and name like '%{$_GET['name']}%'"; 

        //类别处理
        $tid = isset($_GET['tid']) ? $_GET['tid'] : '';
        if($tid !== '') 
            $str .=" and tid={$_GET['tid']}";

        //状态处理
        $status = isset($_GET['status'])?$_GET['status'] : '';
        if($status !== ''){
            $str .=" and status={$status}";
        }
		// $name = isset($_GET['name'])?$_GET['name']:'';
		// $tid = isset($_GET['tid'])?$_GET['tid']:'';
		// if($name!=='')
		// 	$str .=" and name like '%{$name}%'";
		// if($tid !=='')
		// 	$str .=" and tid={$tid}";
		// //page类有一个$total参数要传
        // 最高最低价格p1与p2的构造str
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

        //处理价格升序降序排列
        $order = 'addtime desc';
        if(!empty($_GET['sortTime'])){
            $order = $_GET['sortTime'];
            unset($_GET['sortTime']);
        }
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
        //var_dump($now);
        //var_dump($_GET['p1'],$_GET['p2']);
        //对分类显示使用array_column;
        $res = array_column($types,'name','id');
        
        //分页
		$total = $goods->where($str)->count();
		$page = new Page($total,5);	
		$arr = $goods->where($str)->order($order)->limit($page->limit)->select();
        //var_dump($types);
		include './View/Goods/list.html';
        //var_dump($goods->_sql());
	}

    /**
     * 添加商品的表单
     */
	public function add()
	{  
        //查询分类
        $type = new Model('type');
        $types = $type->order('concat(path,id)')->select();

        if(empty($types)) $this->alert('请先添加分类','index.php?c=Type');
		include './View/Goods/add.html';
	}
    /**
     * 处理添加商品
     * @return [type] [description]
     */
	public function doAdd()
	{
		//var_dump($_POST);

		//商品名不填的处理
        $name = isset($_POST['name'])?$_POST['name']:'';
		if ($_POST['name']=='') {
            $this->jump('商品名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('商品名不合法，请输入字母、数字、下划线或者中文');
        }


			//商品分类没有选给一个空然后跳转终止
		$tid = isset($_POST['tid'])?$_POST['tid']:'';
		if($tid==''){
			$this->jump('请选择商品分类');
			exit;
			}

			//商品价格为空的时候进行跳转终止
        $price = isset($_POST['price']) ? $_POST['price'] :'';
        if ($price == '') {
            $this->jump('请输入商品价格');
        } else if ($_POST['price'] < 0) {
            //记录日志
            $this->jump('请输入合法的商品价格，不能小于0');
        } else if (!preg_match('/^\d{1,}$/', $_POST['price'])){
            $this->jump('请输入合法的商品价格');
        }


			//库存不填的时候进行默认0赋值
        $reserve = isset($_POST['reserve']) ? $_POST['reserve'] :'';
		if($reserve == ''){
            $this->jump('请输入商品库存');
        }else if($_POST['reserve'] < 0){
            error_log('有个傻逼想让库存为负数，他是'.$_SESSION['username']);
            $this->jump('请输入的库存，不小于0');
        }else if (!preg_match('/^\d{1,}$/', $_POST['reserve'])){
            $this->jump('请输入合法的商品价格');
        }

        //添加时间
		$_POST['addtime'] = time();

        //上传图片
        $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        
        if(!$pic = $up->up()){
            $this->jump($up->errInfo);
        }
        $_POST['pic'] = $pic;

		$goods = new Model('goods');
		if($goods->add($_POST)){
			$this->jump('添加成功','index.php?c=Goods&a=index');
		}else{
			$this->jump('添加失败');
		}

	}
    /**
     * 删除商品
     * @return [type] [description]
     */
	public function del()
    {   //  先进行了id的判断来进行跳转
        if(empty($_GET['id'])){ header('location:'.$SERVER['HTTP-REFERER']);
        exit;
        }
        $goods = new Model('goods');
        //删除的时候顺便删除图片
        $img = $goods->find($_GET['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
        }
        //var_dump($img);

        $goods->delete($_GET['id']);
        header('location:'.$_SERVER['HTTP_REFERER']);
    }
    /**
     * 商品修改表单
     * @return [type] [description]
     */
    public function edit()
    {
    	//修改操作需要进行界面的遍历所以用Model类中的find()方法
    	$type = new Model('type');
        $types = $type->order('concat(path,id)')->select();
       
        $goods= new Model('goods');
    	$arr = $goods->find($_GET['id']);
        //var_dump($arr);
    	include './View/Goods/edit.html';
       // var_dump($_GET['id']);
    }

    /**
     * 修改商品操作商品
     * @return [type] [description]
     */
    public function doEdit()
    {	//var_dump($_POST   );
    	if(empty($_POST['id'])) {header('location:'.$_SERVER['HTTP_REFERER']);
    	exit;
        }
    //由于id是主键和自增的，会自动赋值，所以要删除POST里面的id索引对应的值
        if (empty($_POST['tid'])) {
            $this->jump('请选择商品分类');
        }

        //判断商品名是否合法
        $name = isset($_POST['name']) ? $_POST['name'] :'';
        if ($name == '') {
            $this->jump('商品名不能为空');
        } else if (!preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u', $_POST['name'])) {
            $this->jump('商品名不合法，请输入字母、数字、下划线或者中文');
        }

        //判断价格
        $price = isset($_POST['price']) ? $_POST['price'] :'';
        if ($price == '') {
            $this->jump('请输入商品价格');
        } else if ($_POST['price'] < 0) {
            //记录日志
            $this->jump('请输入合法的商品价格，不能小于0');
        } else if (!preg_match('/^\d{1,}.\d{2}$/', $_POST['price'])){
            $this->jump('请输入合法的商品价格');
        }

        //判断库存
        $reserve = isset($_POST['reserve']) ? $_POST['reserve'] :'';
        if($reserve == ''){
            $this->jump('请输入商品库存');
        }else if($_POST['reserve'] < 0){
            error_log('有个傻逼想让库存为负数，他是'.$_SESSION['username']);
            $this->jump('请输入的库存，不小于0');
        }else if (!preg_match('/^\d{1,}$/', $_POST['reserve'])){
            $this->jump('请输入合法的商品价格');
        }

        $goods= new Model('goods');
        //上传商品图片
        $dir = ['path'=>'../Upload/'];
        $up = new Upload($dir);
        if (!($pic = $up->up())) {
            unset($_POST['pic']);
        }else{
        $_POST['pic'] = $pic;//将新的图片名给post里pic其替换goods内的信息
        //替换之后
        $img = $goods->find($_POST['id']);
        if(file_exists('../Upload')){
            $op = opendir('../Upload');
            while (($file = readdir($op))!== false){
                if($file == $img['pic']) unlink('../Upload/'.$img['pic']);
            }
            closedir($op);
            }
        }   

        
        //准备开干
        
        $_POST['addtime'] = time();
        
    	
    	

    	if($goods->save($_POST)){
    		
            $mem = new Memcache;
            $mem->addServer('localhost',11211);
            $key= 'good_detail'.$_POST['id'];
            $mem->delete($key);
            $this->jump('修改成功','index.php?c=Goods&a=index');
    	}else{
    		$this->jump('您没修改到任何东西');
		}
    	
    }

}