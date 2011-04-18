<?php
/**
 * Bayonet Content Management System - RUDI
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
