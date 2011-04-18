<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler & Evan O'Connell
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
 
ob_start();
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>

<html>

<head>
<title>Bayonet CMS Admin Tools</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../style_bbcode.css" media="screen"/>

<!-- jQuery 1.3.2  -->
<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"></script>
<!-- PASSWORD CHECK 
<script type="text/javascript" src="../functions.js"></script> -->

<!-- markItUp! -->
<script type="text/javascript" src="scripts/markitup/markitup/jquery.markitup.pack.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="scripts/markitup/markitup/sets/bbcode/set.js"></script>
<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="scripts/markitup/markitup/skins/markitup/style.css" />
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="scripts/markitup/markitup/sets/bbcode/style.css" /> 
<script type="text/javascript">
<!--
$(document).ready(function()    {
    // Add markItUp! to your textarea in one line
    // $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
    $('#markItUp').markItUp(mySettings);
    
    // You can add content from anywhere in your page
    // $.markItUp( { Settings } );    
    $('.add').click(function() {
         $.markItUp( {     openWith:'<opening tag>',
                        closeWith:'<\/closing tag>',
                        placeHolder:"New content"
                    }
                );
         return false;
    });
    
    // And you can add/remove markItUp! whenever you want
    // $(textarea).markItUpRemove();
    $('.toggle').click(function() {
        if ($("#markItUp.markItUpEditor").length === 1) {
             $("#markItUp").markItUpRemove();
            $("span", this).text("get markItUp! back");
        } else {
            $('#markItUp').markItUp(mySettings);
            $("span", this).text("remove markItUp!");
        }
         return false;
    });
});
-->
</script>  
</head>
 
<body>