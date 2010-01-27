<?php
/**
 * Bayonet Conent Management System
 * Copyright (C) Joseph Hunkeler & Evan O'Connell
 * 
 * Purpose of this software is to allow users to manage their website
 * with ease and without needing to have any coding knowledge in order 
 * to maintain it. Visit [link] for any updates or feedback. 
 */

/* Begin try/catch block */
try {

/* Setup error handing callbacks */
ob_start("fatal_error_handler");
set_error_handler("handle_error");



include self::$header;
//session_start(); 
?>

<div class="container">

<!-- banner -->
 <div class="banner"><a href="index.php"><img src="<?php echo self::$image_path . '/logo.jpg'; ?>" alt="3rd Infantry Division - ArmAII Unit" /></a></div>
<!-- navigation -->
 <div class="nav"><?php require_once self::$root_path . '/navigation.php'; ?></div>

<!-- content -->
<table border="0" cellspacing="15px" cellpadding="0"  class="main" width="100%">
	<tr>
		<td class="midcol">
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
