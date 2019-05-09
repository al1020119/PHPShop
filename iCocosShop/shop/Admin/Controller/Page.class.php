<?php
/**
 * 分页类的封装
 */
class Page
{
	public $limit;		//存储limit条件
	public $allPage;	//存储总页数
	public $current;	//存储当前页
	public $total;		//存储总条数

	/**
	 * 分页类的构造方法
	 * @param int  $total 总条数
	 * @param integer $num   每页显示条数
	 */
	public function __construct($total, $num = 5)
	{
		//计算总页数
		$this->allPage = ceil($total/$num);

		//处理当前页
		$this->current();

		//3,3  6,3
		$this->limit = (($this->current-1)*$num).','.$num;
		$this->total = $total;
	}

	/**
	 * 处理当前页
	 */
	protected function current()
	{
		$p = isset($_GET['p']) ? $_GET['p'] : 1;
		// $p = max(1, $p);	//最小不能小于1
		// $p = min($p, $this->allPage);//最大不能超过总页数

		if ($p < 1) $p = 1;
		if ($p > $this->allPage) $p = $this->allPage;

		$this->current = (int)$p;
	}

	/**
	 * 处理分页按钮
	 * @return string 拼接好的分页按钮
	 */
	public function show()
	{
		$first = $end = $pre = $next = $_GET;

		//处理上一页
		$pre['p'] = $this->current - 1;
		$preStr = http_build_query($pre);

		//处理下一页
		$next['p'] = $this->current + 1;
		$nextStr = http_build_query($next);

		//处理首页
		$first['p'] = 1;
		$firstStr = http_build_query($first);

		//处理尾页
		$end['p'] = $this->allPage;
		$endStr = http_build_query($end);

		$str = "共{$this->total}条数据 第{$this->current}/{$this->allPage}页 | ";
		$str .= "<a href='?{$firstStr}'>首页</a> | ";
		$str .= "<a href='?{$preStr}'>上一页</a> | ";
		$str .= "<a href='?{$nextStr}'>下一页</a> | ";
		$str .= "<a href='?{$endStr}'>尾页</a>";

		return $str;
	}
}