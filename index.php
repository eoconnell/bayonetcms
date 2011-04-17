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
require_once BAYONET_INCLUDE . '/classes.php';

/* Initialize Bayonet CMS */
Bayonet::init();


?>