<?php
/**
 *================================================================
 * Mysql.class.php
 * @Author: Happydong
 * @Date:   2017-07-25 19:38:18
 * @Last Modified by:   Happydong
 * @Last Modified time: 2017-07-26 00:37:04
 *================================================================
 */
class Mysql {
    /*
     * 构造方法，负责连接服务器，选择数据库，设置字符
     * 设置字符方法
     */

    // 数据库连接资源
    protected $conn = false;
    // sql语句
    protected $sql;
    /**
     * 构造方法 负责连接服务器，选择数据库，设置字符
     * @access public
     * @param  $config string 配置数组
     */
    public function __construct($config = array()){
        $host = isset($config['host']) ? $config['host'] : "localhost";
        $user = isset($config['user']) ? $config['user'] : "root";
        $password = isset($config['password']) ? $config['password'] : " ";
        $dbname = isset($config['dbname']) ? $config['dbname'] : " ";
        $port = isset($config['port']) ? $config['port'] : "3306";
        $charset = isset($config['charset']) ? $config['charset'] : "uft8";

        $this->conn = mysql_connect("$host:$port", $user, $password) or die('连接数据库失败');
        mysql_select_db($dbname) or die('数据库选择失败');
        $this->setChar($charset);
    }


    /**
     * 设置字符集
     * @access private
     * @param  $charset string 字符集
     */
    private function setChar($charset){
        $sql = "set names " . $charset;
        $this->query($sql);
    }

    /**
     * 执行sql语句
     * @access public
     * @param  $sql string 查询sql语句
     * @return $result 成功返回资源，失败则输出错误信息，并退出
     */
    public function query($sql){
        // 获取sql语句
        $this->sql = $sql;
        // 发送一条mysql查询
        $result = mysql_query($this->sql, $this->conn);

        if(! $result){
            die($this->errno() . ':' . $this->error() . '<br />出错语句为:' . $this->sql . '<br ./>');
        }

        return $result;
    }

    /**
     * 获取第一条记录的第一个字段
     * @access public
     * @param  $sql string 查询的sql语句
     * @return 返回一个该字段的值,否则返回false
     */
    public function getOne($sql){
        $result = $this->qurey($sql);
        $row = mysql_fetch_row($result);
        if($row){
            return $row[0];
        }else{
            return false;
        }
    }

    /**
     * 获取一条记录
     * @access public
     * @param  $sql string 查询sql语句
     * @return array 返回关联数组，否则返回false
     */
    public function getRow($sql){
        if($result = $this->query($sql)){
            $row = mysql_fetch_row($result);
            return $row;
        }else{
            return false;
        }
    }

    /**
     * 获取所有记录的值
     * @access public
     * @param  $sql string 查询的sql语句
     * @return $list 返回二维关联数组
     */
    public function getAll($sql){
        $result = mysql_query($sql);
        $list = array();
        while($row = mysql_fetch_assoc($result)){
            $list[] = $row;
        }
        return $list;
    }

    /**
     * 获取某一列的值
     * @access public
     * @param  $sql string 查询sql语句
     * @return $list 返回关联数组
     */
    public function getCol($sql){
        $result = $this->query($sql);
        $list = array();
        while($row = mysql_fetch_row($result)){
            $list[] = $row[0];
        }
        return $list;
    }

    /**
     * 获取上一步insert操作产生的id
     * @access public
     * @return int 返回id值
     */
    public function getInsertId(){
        return mysql_insert_id($this->conn);
    }

    /**
     * 获取错误号
     * @access private
     * @return int 错误号
     */
    private function errno(){
        return mysql_errno($this->conn);
    }

    /**
     * 获取错误信息
     * @access private
     * @return 错误信息
     */
    private function error(){
        return mysql_error($this->conn);
    }
}