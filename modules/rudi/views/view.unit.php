<?php $data = $info->Unit($unit_id); ?>

<table align="center">
	<tr>
		<th>&nbsp;</th>
		<td><img src="<?php echo '/cms/modules/rudi/images/units/' . $data->logo; ?>" alt="<?php echo $data->logo; ?>"/></td>
	</tr>
	<tr>
		<th width="25%">Unit</th>
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