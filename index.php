<?php

define('BAYONET_ROOT', basename(dirname('.')));
define('BAYONET_INCLUDE', BAYONET_ROOT . '/include');
define('BAYONET_CONFIG', 'include/config.ini');

require_once BAYONET_CONFIG;
require BAYONET_INCLUDE . '/config.php'; 
require BAYONET_INCLUDE . '/debug.php';
require BAYONET_INCLUDE . '/sql.class.php';
require BAYONET_INCLUDE . '/functions.php';

$db = new Bayonet_SQL();
$db->Connect(
  $config['sql']['hostname'],
  $config['sql']['username'],
  $config['sql']['password']
  );
$db->Select_db($config['sql']['database']);

class Bayonet_Theme
{
	static public $index;
	static public $header;
	static public $footer;
	
	static public $name;
	static public $root_path;
	static public $include_path;
	static public $image_path;
	static public $config;
	static public $primary_css;
	
	static function init()
	{
		self::$name = Bayonet_Config::$ini['Theme']['name'];
		decho('Initializing theme variables for \'' . self::$name . '\'');
		self::$root_path = dirname(BAYONET_ROOT) . '/themes/' . self::$name;
		self::$include_path = self::$root_path . '/include';
		self::$image_path = self::$root_path . '/images';
		self::$primary_css = self::$include_path . '/' . self::$name . '.css';
		self::$config = parse_ini_file(self::$include_path . '/' . self::$name . '.ini', true);

		self::$index = self::$root_path . '/index.php';
		self::$header = self::$root_path . '/header.php';
		self::$footer = self::$root_path . '/footer.php';
		
		decho(get_class_vars(Bayonet_Theme));
		self::load(); 
	}
	
	static function load()
	{
		global $db;
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