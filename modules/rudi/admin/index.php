<?php

//include '../includes/debug.php';
//include '../includes/sql.class.php';
//include '../includes/common.class.php';
include 'includes/admin.class.php';
//include '../header.php';

ob_start();
$common = new AdminCommon();
include 'views/view.admin.php';

if(isset($_GET['soldier']) && $_GET['soldier'] == 'modify')
{
  include 'views/view.modifysoldier.php';
  
}

//include '../footer.php';
ob_flush();
?>