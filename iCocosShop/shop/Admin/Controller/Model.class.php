<?php
/**
 * 将对数据库的增删改查都封装好
 */
class Model extends PDO
{
	protected $tabName = '';	//存储表名
	protected $sql = ''; 		//存储最后一次执行的sql语句
	protected $allField = [];	//存储表里面所有的字段
	protected $limit = '';	//存储limit条件
	protected $order = '';	//存储order条件
	protected $field = '*';	//存储要查询的字段
	protected $where = '';	//存储where条件
	protected $errInfo = '';//存储错误信息

	//构造方法
	public function __construct($tabName)
	{
		parent::__construct('mysql:host='.HOST.';dbname='.DB.';charset=utf8', USER, PWD);

		//存储表名
		$this->tabName = FIX.$tabName;

		//设置错误模式
		// $this->setAttribute(3, 1);

		//保存当前表的所有字段
		$this->getFields();
	}

	/**
	 * 获取所有的字段，并赋值给$this->allField
	 * @return void 
	 */
	public function getFields()
	{
		$sql = "desc {$this->tabName}";
		$this->sql = $sql;
		$stmt = $this->query($sql);
		if ($stmt) {
			$arr = $stmt->fetchAll(2);

			//返回数组中指定的列
			$this->allField = array_column($arr, 'Field');

			// $tmp = [];
			// foreach ($arr as $v) {
			// 	$tmp[] = $v['Field'];
			// }
			// var_dump($tmp);
			// exit;
		} else {
			die('数据表不存在');
		}
	}

	/**
	 * 查询所有数据
	 * @return array 返回一个数组，查到的所有数据
	 */
	public function select()
	{
		$sql = "select {$this->field} from {$this->tabName} {$this->where} {$this->order} {$this->limit}";
		//存储sql语句
		$this->sql = $sql;

		//发送sql语句
		$stmt = $this->query($sql);
		if ($stmt) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return [];
	}

	/**
	 * 查询单条数据
	 * @param  int $id 要查询的id值
	 * @return array   查到数据，返回一维数组
	 */
	public function find($id)
	{
		$sql = "select {$this->field} from {$this->tabName} where id={$id}";
		$this->sql = $sql;
		$stmt = $this->query($sql);
		if ($stmt) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return [];
	}

	/**
	 * 统计总条数
	 * @return int 统计好的条数
	 */
	public function count()
	{
		$sql = "select count(*) from {$this->tabName} {$this->where}";
		$this->sql = $sql;

		$stmt = $this->query($sql);
		if ($stmt) {
			return (int)$stmt->fetch()[0];
		}
		return 0;
	}

	/**
	 * 删除单条数据
	 * @param  int $id 要删除的id
	 * @return int   返回受影响的行数
	 */
	public function delete($id = null)
	{	
		if(!is_null($id)) $this->where='where id='.$id;
		if(empty($this->where)) return $this;
		$sql = "DELETE FROM {$this->tabName} {$this->where}";
		$this->sql = $sql;
		return $this->exec($sql);
	}

	/**
	 * 添加数据
	 * @param array $data 要添加的数组数据
	 * ['字段名'=>'字段值']
	 */
	public function add($data)
	{
		//过滤非法字段
		foreach ($data as $k=>$v) {
			if (!in_array($k, $this->allField)) unset($data[$k]);
		}

		//判断是否全特么是非法字段
		if (empty($data)) {
			$this->errInfo = 'FUCK, 全是非法字段';
			return false;
		}

		$keys = join(',', array_keys($data));
		$vals = join("','", $data);
		$sql = "insert into {$this->tabName}({$keys}) values('$vals')";
		$this->sql = $sql;

		return (int)$this->exec($sql);
	}
	
	public function save($data)
	{
		$str = '';
		//过滤非法字段
		foreach ($data as $k=>$v) {
			if($k =='id'){
				$this->where = 'where id='.$v;
				unset($data[$k]);
				continue;
			}
			if (in_array($k, $this->allField)) {
				$str .= "`$k`='$v',";
			} else {
				unset($data[$k]);
			}
		}

		// echo $str;exit;
		//判断是否全特么是非法字段
		if (empty($data)) {
			$this->errInfo = 'FUCK, 全是非法字段';
			return false;
		}
		//判断是否传了条件
		if (empty($this->where)) {
			$this->errInfo = '请传入修改条件，FUCK';
			return false;
		}

		//去除右边的,
		$str = rtrim($str, ',');

		$sql = "update {$this->tabName} set $str {$this->where}";

		$this->sql = $sql;
		return (int)$this->exec($sql);
	}

	/**
	 * 获取最后一次执行的sql语句
	 * @return string 最后一次执行的sql语句
	 */
	public function _sql()
	{
		return $this->sql;
	}

	/**
	 * 获取错误信息
	 * @return string 保存好的错误信息
	 */
	public function getError()
	{
		return $this->errInfo;
	}

	/**
	 * limit条件
	 * @param  int|string $limit limit条件
	 * @return object   返回自己，保证连贯操作
	 */
	public function limit($limit)
	{
		$this->limit = 'limit '.$limit;
		return $this;
	}

	/**
	 * order排序方法
	 * @param  string $order 要排序的字段
	 * @return object   返回自己，保证连贯操作
	 */
	public function order($order)
	{
		$this->order = 'order by '.$order;
		return $this;
	}

	/**
	 * 存储要查询的字段	
	 * @param  string $field 要查询的字段
	 * @return object   返回自己，保证连贯操作
	 */
	public function field($field)
	{
		$this->field = $field;
		return $this;
	}

	/**
	 * 存储where条件
	 * @param  string $where where条件
	 * @return object   返回自己，保证连贯操作
	 */
	public function where($where) 
	{
		if (!empty($where)) $this->where = 'where '.$where;
		return $this;
	}
}