<?php
$unit_id = $_GET['unit_id'];
$platoon_id = $_GET['platoon_id'];
switch($_GET['info'])
{
	case 'unit':
		if(isset($unit_id))
			include_once 'view.unit.php';
	break;
	
	case 'platoon':
		if(isset($unit_id, $platoon_id))
			include_once 'view.platoon.php';
	break;
	
	default:
		ReportError('Invalid info entry');
		return;
}
?>