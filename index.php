<?php
/**
 * Bayonet Conent Management System
 * Copyright (C) Joseph Hunkeler & Evan O'Connell
 * 
 * Purpose of this software is to allow users to manage their website
 * with ease and without needing to have any coding knowledge in order 
 * to maintain it. Visit www.eodesign.com/cms for any updates or feedback. 
 */

/* Begin try/catch block */
try {

include './includes/config.php'; 
include './includes/debug.php';
include './includes/sql.class.php';
include './includes/functions.php';

/* Setup error handing callbacks */
ob_start("fatal_error_handler");
set_error_handler("handle_error");

$db = new Bayonet_SQL();
$db->Connect(
  $config['sql']['hostname'],
  $config['sql']['username'],
  $config['sql']['password']
  );
$db->Select_db($config['sql']['database']);

include 'header.php';
//session_start(); 
?>

<div class="container">

<!-- banner -->
<div class="banner"><a href="index.php"><img src="images/logo.jpg" alt="3rd Infantry Division - ArmAII Unit" /></a></div>

<!-- navigation -->
 <div class="nav"><?php require_once 'navigation.php'; ?></div>

<!-- content -->
<table border="0" cellspacing="10px" cellpadding="0"  class="main" width="100%">
	<tr>
		<td class="leftcol">
	    	<?php  require_once 'modules.php'; ?>
 		</td>
 		
	  <!-- block area RIGHT -->
	  <?php  if(!defined('BLOCK_RIGHT_DISABLE')): ?>
	    <td class="rightcol">
	      	<?php GetBlocks(BLOCK_RIGHT); ?>
	    </td>    
	  <?php endif; ?>
  
	</tr>
</table>

</div>
<?php include 'footer.php'; ?>
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