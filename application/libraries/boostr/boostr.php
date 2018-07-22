<?php

/*
|----------------------------------------------------------------------------------------------------------------------|
|                                    |Boostr| Easy Database Query Library                                              |      
|----------------------------------------------------------------------------------------------------------------------|
|  Author  : Furkan Gürel                                                                                              |
|  Github  : https://github.com/furkangurel                                                                            |
|  Youtube : https://youtube.com/c/codeigniterhocasi                                                                   |
|----------------------------------------------------------------------------------------------------------------------|
*/
define('EXT', '.php');
class Boostr {

	function __construct()
	{
		$mod_path = APPPATH . 'models/';
		if(file_exists($mod_path)) $this->_read_model_dir($mod_path);
	}

	private function _read_model_dir($dirpath)
	{
		$ci =& get_instance();
		$handle = opendir($dirpath);
		if(!$handle) return;
		while (false !== ($filename = readdir($handle)))
		{
			if($filename == "." or $filename == "..") continue;

			$filepath = $dirpath.$filename;
			if(is_dir($filepath))
				$this->_read_model_dir($filepath);
			elseif(strpos(strtolower($filename), '.php') !== false)
			{
				$name = strtolower($filepath);
				require_once $name;
			}
			else continue;
		}
		closedir($handle);
	}

}

	spl_autoload_register(function($class){
	if(strpos($class, "Boostr\\") === 0)
	{
		$classname = str_replace("Boostr\\", "", $class);
		$path = 'src/' . strtolower( str_replace("\\", "/", $classname) ) . EXT;
		require_once $path;
	}

});
