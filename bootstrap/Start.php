<?php
//框架启动文件
class Start
{
	static $loader;
	//框架初始化
	static public function run()
	{
		include 'bootstrap/Psr4Autoload.php';
		$namespaces = include 'config/namespaces.php';
		//var_dump($namespaces);
		
		self::$loader = new Psr4AutoLoad();
		self::$loader->register();
		self::addNamespaces($namespaces);
		//$loader->addNamespace('Framewrok\\' , 'cm/framewrok/src');
		
		/*
		
		foreach ($namespaces as $path=> $namespace) {
			//echo $path.'----'.$namespace.'<br />';
			$loader->addNamespace($namespace , $path);
		}
		*/
	}
	//使用静态方法实现添加命名空间
	static public function addNamespaces($namespaces)
	{
		foreach ($namespaces as $path=> $namespace) {
			//echo $path.'----'.$namespace.'<br />';
			self::$loader->addNamespace($namespace , $path);
		}
	}
	
	
	//关于路由的方法
	static public function route()
	{
		//$c = new Controller\UserController();
		//$c->info();
		//$t = new Test\TestController();
		//$t->test();

		//var_dump($_GET);
		$_GET['m'] = isset($_GET['m']) ? $_GET['m'] : 'Index';
		$_GET['a'] = isset($_GET['a']) ? $_GET['a'] : 'index';
		$_GET['m'] = ucfirst($_GET['m']);

		//var_dump($_GET);
		//new Controller\UserContrller();
		$controller = 'Controller\\' . $_GET['m'] . 'Controller';

		$c = new $controller();
		/*
		$id = $_GET['id'];
		$action = $_GET['a'];
		$c->$action($id);
		*/

		call_user_func(array($c , $_GET['a']));
	}
}