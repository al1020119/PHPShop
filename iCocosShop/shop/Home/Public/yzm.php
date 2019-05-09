<?php
/**
* 验证码类
*/
session_start();
class Verify
{
	protected $conf = [
		'length'	=>	4,
		'fontSize' 	=> 	25,
		'useNoise' 	=> 	true,	//是否使用干扰
        'useZh'     =>  false,  // 使用中文验证码 
        'zhSet'     =>  '嫖娼犇猋骉蟲麤毳淼掱焱垚灥吃屎龃龉魍魉鳜饕餮耄耋踟躇倥偬蹀躞髑髅鳏踽耆嘦巭孬嫑莪',     // 使用中文验证码
        'codeSet'	=>	'2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
        'ttf'		=> 	'c:/windows/fonts/msyh.ttf',
	];
	private $_im = null; //存储画布资源
	private $_color = null;//存储字体颜色
	
	function __construct($conf = [])
	{
		$this->conf = array_merge($this->conf, $conf);
	}

	/**
     * 使用 $this->key 获取配置
     * @param  string $key 配置名称
     * @return mixed    配置值
     */
	public function __get($key)
	{
		return $this->conf[$key];
	}

	/**
     * 设置验证码配置
     * @param  string $k 配置名称
     * @param  string $v 配置值     
     * @return void
     */
	public function __set($k, $v)
	{
		$this->$k = $v;
	}

	/**
	 * 输出验证码
	 */
	public function yzm()
	{
		//根据字体大小计算画布宽高
		$w = $this->fontSize * $this->length + $this->fontSize*5;
		$h = $this->fontSize + $this->fontSize*2;
		$this->_w = $w;
		$this->_h = $h;

		//创建画布
		$im = imagecreatetruecolor($w, $h);
		$this->_im = $im;
		$this->_color = imagecolorallocate($im, 255, 255, 255);
		$bg = imagecolorallocate($im, 150, 150, 150);
		//填充背景
		imagefill($im, 0, 0, $bg);

		//写字并存入session
		$this->write();

		//画干扰
		if ($this->useNoise) $this->_noise();

		//输出图像
		header('Content-type:image/png');
		imagepng($im);

		//回收垃圾
		imagedestroy($im);
	}

	/**
	 * 写验证码字符并将其存入session中
	 */
	protected function write()
	{
		//写字
		$code = '';
		for ($i = 0; $i < $this->length; $i++) {
			//判断是否是中文验证码
			if ($this->useZh) {
				$str = $this->zhSet;
				//截取中文不会乱码
				$chr = mb_substr($str, mt_rand(0, mb_strlen($str)-1), 1);
			} else {
				$str = str_shuffle($this->codeSet);
				$chr = $str[$i];
			}
			imagefttext($this->_im, $this->fontSize, mt_rand(-$this->fontSize, $this->fontSize), $this->fontSize+($i*($this->fontSize+$this->fontSize)), $this->fontSize*2, $this->_color, $this->ttf, $chr);
			$code .= $chr;
		}

		//将验证码写入session
		$_SESSION['code'] = $code;
	}

	protected function _noise()
	{
		//干扰小字符
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
		for ($i = 0; $i < $this->fontSize; $i++) {
			$sj = imagecolorallocate($this->_im, mt_rand(150,225), mt_rand(150,225), mt_rand(150,225));
            imagestring($this->_im, 5, mt_rand(-10, $this->_w),  mt_rand(-10, $this->_h), $codeSet[mt_rand(0, 29)], $sj);
		}

        //干扰点
		for ($i = 0; $i < ceil($this->fontSize*10); $i++) {
			$sj = imagecolorallocate($this->_im, mt_rand(150,225), mt_rand(150,225), mt_rand(150,225));
			imagesetpixel($this->_im, mt_rand(0, $this->_w), mt_rand(0, $this->_h), $sj);
		}

		//干扰线
		for ($i = 0; $i < ceil($this->fontSize/3); $i++) {
			$sj = imagecolorallocate($this->_im, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
			imageline($this->_im, mt_rand(0, $this->_w), mt_rand(0, $this->_h), mt_rand(0, $this->_w), mt_rand(0, $this->_h), $sj);
		}
	}
}

$yzm = new Verify();
// $yzm->useZh = true;
$yzm->fontSize = 10;
$yzm->useNoise = false;
$yzm->length = 4;
$yzm->yzm();