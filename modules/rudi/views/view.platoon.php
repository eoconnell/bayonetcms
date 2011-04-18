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

?>
<?php $data = $info->Platoon($unit_id, $platoon_id); ?>

<table align="center">
	<tr>
		<th>&nbsp;</th>
		<td><img src="<?php echo '/cms/modules/rudi/images/units/' . $data->logo; ?>" alt="<?php echo $data->logo; ?>"/></td>
	</tr>
	<tr>
		<th width="25%">Platoon</th>
		<td><?php echo $data->name; ?></td>
	</tr>
	<tr>
		<th>Creed</th>
		<td><?php echo $data->creed; ?></td>
	</tr>
	<tr>
		<th valign="top">Biography</th>
		<td><?php echo $data->bio; ?></td>
	</tr>
</table>

<?php decho($data); ?>
