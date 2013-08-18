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

<div class="container">

<!-- banner -->
 <div class="banner"><h1>Bayonet CMS</h1></div>
<!-- navigation -->
 <div class="nav"><?php require_once self::$root_path . '/navigation.php'; ?></div>

<!-- content -->
<table border="0" cellspacing="0px" cellpadding="0" class="main" width="100%">
	<tr>
		<td class="midcol">
	    	<?php  require_once 'modules.php'; ?>
 		</td>
 		
	  <!-- block area RIGHT -->
	  <?php  if(!defined('BLOCK_RIGHT_DISABLE')): ?>
	    <td class="rightcol" style="padding-left: 15px;">
	      	<?php GetBlocks(BLOCK_RIGHT); ?>
	    </td>    
	  <?php endif; ?>
  		
	</tr>
</table>

</div>
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
