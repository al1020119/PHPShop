<?php
/*
 * 文件上传类
 */
class Upload
{
	public $errInfo = ''; 	//存储错误信息
	public $config 	= [
		'types'	=> ['image/jpeg', 'image/png', 'image/gif'],
		'size'	=> 0,	//为0就不限制大小
		'path'	=> './Upload'
	];

	/**
	 * 合并配置项
	 * @param array $conf 配置项
	 */
	public function __construct($conf = [])
	{
		//合并两个数组，相同下标后面覆盖前面的
		$this->config = array_merge($this->config, $conf);
	}

	/**
	 * 用于文件上传
	 * @return string 上传成功后随机生成的文件名
	 */
	public function up()
	{
		if (empty($_FILES)) {
			$this->errInfo = '请选择文件上传';
			return false;
		}
		//拿出$_FILES里面的下标
		$key  = array_keys($_FILES)[0];
		$file = $_FILES[$key];

	// 1.判断错误号
		if ($file['error'] != 0) {
			switch ($file['error']) {
				case 1:
					$this->errInfo = '亲，太大了！';
					break;
				case 4:
					$this->errInfo = '没有文件上传';
					break;
				default:
					$this->errInfo = '亲，太大了~';
			}

			return false;
		}

	// 2.判断类型
		if (!in_array($file['type'], $this->config['types'])) {
			$this->errInfo = '亲，类型不合法！';
			return false;
		}

	// 3.判断大小
		if ($this->config['size'] != 0) {
			if ($file['size'] > $this->config['size']) {
				$this->errInfo = '亲，文件太大！';
				return false;
			}
		}

	// 4.随机文件名
		$name = md5(str_shuffle(uniqid().mt_rand(0, 99999999).date('YmdHis'))).strrchr($file['name'], '.');

	// 5.处理路径
		$path = rtrim($this->config['path'], '/').'/';
		if (!file_exists($path)) mkdir($path, 0777, true);

		//拼接新的文件名
		$filename = $path.$name;
		// echo $filename;
	// 6.上传
		if (is_uploaded_file($file['tmp_name'])) {
			if (move_uploaded_file($file['tmp_name'], $filename)) {
				return $name;
			} else {
				$this->errInfo = '上传失败';
				return false;
			}
		}
	} 
}
