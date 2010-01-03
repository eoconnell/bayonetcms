<table width="100%" class="rudi">
<?php
	$result = $this->db->query("SELECT * FROM `rudi_combat_units` WHERE `detachment` = 0");
	$row = $this->db->fetch($result);
	foreach($row as $unit){
		echo "<tr><th colspan=\"5\">{$unit['name']}</th></tr>";
?>
	<tr>
      <!-- Table header -->
      <th class="header">Rank</th>
      <th class="header">Name</th>
      <th class="header">Role</th>
      <th class="header">Weapon</th>
      <th class="header">Status</th>
    </tr>
<?php
		$this->printRoster($unit['unit_id'], $unit['leader_id']); 
		$this->displayUnitsRec($unit['unit_id']);
	}

?>
</table>

