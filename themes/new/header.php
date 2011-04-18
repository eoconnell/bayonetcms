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

global $config;
ob_start();
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" dir="ltr">

<head>
<title>Bayonet CMS Default Theme</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php if(isset($config['site']['favicon'])): ?>
<!--<link rel="shortcut icon" href="<?php echo $config['site']['favicon']; ?>" type="image/x-icon" />-->
<link rel="shortcut icon" href="<?php echo $config['site']['favicon']; ?>" type="image/png" />
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php echo self::$primary_css; ?>" media="screen"/>


<script type="text/javascript" src="functions.js"></script>

<!-- jQuery -->
<script type="text/javascript" src="markitup/jquery.pack.js"></script>
<!-- markItUp! -->
<script type="text/javascript" src="markitup/markitup/jquery.markitup.pack.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="markitup/markitup/sets/bbcode/set.js"></script>
<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="markitup/markitup/skins/markitup/style.css" />
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="markitup/markitup/sets/bbcode/style.css" />       

</head>

<body>
