<?php
/**
 *================================================================
 * Framework.class.php 基础框架类
 * @Author: Happydong
 * @Date:   2017-07-24 16:34:11
 * @Last Modified by:   Happydong
 * @Last Modified time: 2017-07-25 19:44:54
 *================================================================
 */

/**
 * 定义目录常量 init()
 * 完成自动加载 auto_load()
 * 路由分发功能 router()
 */

class Framework {

    /**
     * init 初始化方法
     * @access private
     */
    private function _init(){
        // 定义项目根目录，相当于获取当前目录
        define("ROOT_PATH", getcwd() . "/");
        define("FRAMEWORK_PATH", ROOT_PATH . "Framework/");
        define("APP_PATH", ROOT_PATH . "App/");
        define("PUBLIC_PATH", ROOT_PATH . "Public/");
        define("CORE_PATH", FRAMEWORK_PATH . "Core/");
        define("HELPER_PATH", FRAMEWORK_PATH . "Helper/");
        define("LIB_PATH", FRAMEWORK_PATH . "Lib/");
        define("CONFIG_PATH", APP_PATH . "Config/");

        // 确定是否是前后台
        define("PLATFORM", isset($REQUEST['p']) ? ucfirst($REQUEST['p']) : "Admin");
        define("CONTROLLER", isset($REQUEST['c']) ? ucfirst($REQUEST['c']) : "Index");
        define("ACTION", isset($REQUEST['a']) ? ucfirst($REQUEST['a']) : "Index");

        // 定义当前MVC的目录常量
        define("CUR_CONTROLLER_PATH", APP_PATH . PLATFORM . "/Controller/");
        define("CUR_MODEL_PATH", APP_PATH . PLATFORM . "/Model/");
        define("CUR_VIEW_PATH", APP_PATH . PLATFORM . "/View/");

        // 引入核心类
        require CORE_PATH . 'Controller.class.php';
    }

    /**
     * run 方法
     * @access public
     */
    public static function run(){
        // echo "Framework is running!!!";
        // echo getcwd();
        self::_init();
        self::register_load();
        self::router();
    }

    /**
     * register_load() 注册自动加载的类文件
     * @access public
     */
    public function register_load(){
        spl_autoload_register(array(__CLASS__, "auto_load"));
    }

    /**
     * auto_load 自动加载函数 主要负责加载MVC中的类文件
     * @access public static
     * @param  $classname
     */
    public static function auto_load($classname){
        if(substr($classname, -10) == "Controller"){
            require CUR_CONTROLLER_PATH . "{$classname}.class.php";
        } elseif(substr($classname, -5) == "Model"){
            require CUR_MODEL_PATH . "{$classname}.class.php";
        } else {

        }
    }
    /**
     * router() 路由分发函数 实例化控制器类和调用ACTION操作方法
     * @access public
     */
    public function router(){
        $controller_name = CONTROLLER . "Controller";
        $action_name     = ACTION . "Action";
        $controller = new $controller_name();
        $controller->$action_name();
    }

}