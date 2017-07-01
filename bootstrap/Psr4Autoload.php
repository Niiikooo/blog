<?php
class Psr4AutoLoad
{
	protected $namespaces = array();
	
	public function register()
	{
		spl_autoload_register(array($this , 'loadClass'));
	}
	
	public function loadClass($className)
	{
		//echo $className;
		$pos = strrpos($className , '\\');
		
		//截取空间名
		$namespace = substr($className , 0 , $pos+1);  //Test/TestController
		
		//截取类名
		
		$realClassName = substr($className , $pos+1);//TestController
		
		$this->mapload($namespace , $realClassName);
	}
	
	public function mapload($namespace , $realClassName)
	{
		//var_dump($namespace , $realClassName);
		
		//处理两种情况
		
		if (isset($this->namespaces[$namespace]) == false) {
			
			$path = strtolower($namespace . $realClassName) . '.php';
			$filePath = str_replace('\\' , '/' , $path);
			
			$this->requireFile($filePath);
			
		} else {
			//echo 1111;
			//var_dump($this->namespaces[$namespace]);
			foreach ($this->namespaces[$namespace] as $path) {
				$filePath = strtolower($path . '/' . $realClassName . '.php');
				
				//执行包含
				$this->requireFile($filePath);
			}
		}
	}
	
	//执行包含的函数
	public function requireFile($filePath)
	{
		if (file_exists($filePath)) {
			include $filePath;
			return true;
		} else {
			return false;
		}
	}
	
	
	public function addNamespace($namespace , $path)
	{
		$this->namespaces[$namespace][] = $path;
		
		//var_dump($this->namespaces);
	}
}