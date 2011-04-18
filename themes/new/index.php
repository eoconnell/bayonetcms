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

/* Begin try/catch block */
try {

/* Setup error handing callbacks */
ob_start("fatal_error_handler");
set_error_handler("handle_error");

require_once self::$root_path . '/include/functions.php';

include self::$header;
//session_start(); 
?>
<div id="headerContainer">

	<div id="header"> 
		<div id="topBar">
			<div id="searcher"><form method="get" id="searchform" action=""> 
			<label class="hidden" for="s">Search for:</label> 
			<input type="text" value="Search Site" onfocus="this.value=''; this.onfocus=null;" name="s" id="s" /> 
	        <input type="submit" id="searchsubmit" value="GO!" /> 
	        
			</form></div> 
				<div id="today"><?php //echo date('l | F jS, Y'); ?></div>
		</div><!--end topBar-->	
		<h1>Bayonet CMS</h1><!--end logo-->    
 
	
		<div id="navigation">
			<?php require_once self::$root_path . '/navigation.php'; ?>
		</div><!--end navigation--> 
	
	</div><!--end header--> 
</div><!--end headerContainer--> 
	
<div id="contentContainer"> 
	<div id="content"> 

<?php  if(!defined('BLOCK_RIGHT_DISABLE')): ?>		
	<div id="main"> 
 		<?php  require_once 'modules.php'; ?>
	</div><!--end main--> 
 
		<!-- block area RIGHT -->
		
	<div id="sidebar"> 
		<?php GetBlocks(BLOCK_RIGHT); ?>
		
	</div><!--end sidebar--> 
<?php endif; ?>
<?php if(defined('BLOCK_RIGHT_DISABLE')): ?>
	<div id="main-full"> 
	THIS IS SOME MAIN TEXT
 		<?php  require_once 'modules.php'; ?>
	</div><!--end main--> 
<?php endif; ?>
 

<div class="clear"></div> 
</div><!--end content--> 
</div><!--end contentContainer--> 

<?php include self::$footer; ?>
<?php
/* Flushing is needed by the error handler */
ob_end_flush();

} //try ^^    
catch(Exception $e)
{
  ReportError( 
    "<style>td.short{width:100%;}</style><table style=\"width:0;\"><tr><th>Code</th>" . "<td class=\"short\">" . $e->getCode() . "</td>" . "</tr><tr><th>In File</th>" . "<td class=\"short\">" . $e->getFile() . "</td>" . "</tr></table>" . $e->getLine() . " - " . $e->getMessage() . "<br/>" 
  );        
}
?> 
