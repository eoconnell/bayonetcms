<?php

/**
 *  DO NOT MOVE THESE DEFINES 
 */
define('BAYONET_ROOT', basename(dirname('.')));
define('BAYONET_INCLUDE', BAYONET_ROOT . '/include');
define('BAYONET_CONFIG', BAYONET_ROOT . '/include/config.ini');

require BAYONET_INCLUDE . '/debug.php';
require BAYONET_INCLUDE . '/sql.class.php';
require BAYONET_INCLUDE . '/functions.php';


class Bayonet_Theme
{
	static public $index;
	static public $header;
	static public $footer;
	
	static public $name;
	static public $root_path;
	static public $include_path;
	static public $image_path;
	static public $config_path;
	static public $config;
	static public $primary_css;
	
	static function init()
	{
		if(!isset($_GET['theme']))
		{
			self::$name = Bayonet_Config::$ini['site']['theme'];	
		}
		else
		{
			self::$name = $_GET['theme'];
		}
		
		decho('Initializing theme variables for \'' . self::$name . '\'');
		self::$root_path = dirname(BAYONET_ROOT) . '/themes/' . self::$name;
		self::$include_path = self::$root_path . '/include';
		self::$image_path = self::$root_path . '/images';
		self::$primary_css = self::$include_path . '/primary.css';
		self::$config_path = self::$include_path . '/theme.ini';

		if(!self::is_valid())
		{
			die('Theme failed during initialization.');
		}
		self::$config = parse_ini_file(self::$config_path, true);

		self::$index = self::$root_path . '/index.php';
		self::$header = self::$root_path . '/header.php';
		self::$footer = self::$root_path . '/footer.php';
		
		//decho(get_class_vars(Bayonet_Theme)); //do not re-enable this
		self::load(); 
	}
	
	static private function is_valid()
	{
		if(
		file_exists(self::$root_path) && 
		file_exists(self::$include_path) &&
		file_exists(self::$config_path)
		)
			return true;
		else
			return false;		
	}
	
	static function load()
	{
		global $db, $config;
		
		// Globally referenced configuration and database variables
		$config = Bayonet_Config::$ini;
		$db = new Bayonet_SQL();
		
		$db->Connect(
		  $config['sql']['hostname'],
		  $config['sql']['username'],
		  $config['sql']['password']
		  );
		$db->Select_db($config['sql']['database']);
		
		decho("Loading theme: '" . self::$name . "'");	
		require self::$index;
	}
}

class Bayonet_Config
{
	static $ini;
	static function init()
	{
		decho('Parsing configuration data');
		if(file_exists(BAYONET_CONFIG))
		{
			self::$ini = parse_ini_file(BAYONET_CONFIG, true);
			decho(self::$ini);
		}
		else
			die(BAYONET_CONFIG . ' not found');
	}
}

class Bayonet
{
	static function init()
	{
		decho('Initializing Bayonet');
		Bayonet_Config::init();
		Bayonet_Theme::init();
	}
}

Bayonet::init();



?>