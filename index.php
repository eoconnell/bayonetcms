<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008-2011  Joseph Hunkeler & Evan O'Connell
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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
