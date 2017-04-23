<?php

namespace Bootta\Util;

use Exception;

class Config{
	private static $global_config_path;
	private static $global_config;
	
	private $local_config;
	private $local_config_path;
	
	
	
	public function __construct($path){
		
	    $this->local_config_path = $path;
		if(!file_exists($path)){
			if(!file_exists(dirname($path))){
				mkdir(dirname($path),'0711', true);
			}
			
			$config_file = fopen($path, "w") or die("Unable to open file!");
			$init_config_content = "<?php\n\nreturn array(\n\t\"sample_conf\" => \"sample_conf value\",\n\t\"sample_conf2\" => \"sample_conf value 2\"\n);";
			fwrite($config_file, $init_config_content);
			fclose($config_file);
		}
		$this->local_config = include($path);
	}
	
	public static function set_global_config($path){
		Config::$global_config_path = $path;
		if(!file_exists($path)){
			if(!file_exists(dirname($path))){
				mkdir(dirname($path),'0711', true);
			}
			
			$config_file = fopen($path, "w") or die("Unable to open file!");
			$init_config_content = "<?php\n\nreturn array(\n\t\"sample_conf\" => \"sample_conf value\",\n\t\"sample_conf2\" => \"sample_conf value 2\"\n);";
			fwrite($config_file, $init_config_content);
			fclose($config_file);
		}
		Config::$global_config = include($path);
	}
	
	public static function get_global($key=""){
		
		if(Config::$global_config){
			if(array_key_exists($key,Config::$global_config)){
				return Config::$global_config[$key];
			}else{
				throw new Exception("Global config entry with key = ".$key." not exist");
			}
		}else{
			throw new Exception("Global config not initialized");
		}
	}
	
	public function get_local($key=""){
		
		if($this->local_config){
			if(array_key_exists($key,$this->local_config)){
				return $this->local_config[$key];
			}else{
				throw new Exception("Local config entry with key = ".$key." not exist");
			}
		}else{
			throw new Exception("Local config not initialized");
		}
	}
	
}

?>