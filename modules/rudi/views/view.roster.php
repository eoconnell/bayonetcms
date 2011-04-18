<div style="text-align: center">
<?php 
	
	echo LinkInternal('Active Roster','?load=rudi');
	echo '&nbsp;&nbsp;&nbsp;'.LinkInternal('Past Member Roster','?load=rudi&select=past').'<br /><br />';

?>
</div>
<center>
<table width="100%" cellspacing="1" cellpadding="0" class="rudiroster">
<?php

	if(isset($_GET['select']) && $_GET['select'] == "past"){
		
?>
		<tr><th colspan="5">Past Members Roster</th></tr>
		<tr>
	      <!-- Table header -->
	      <th class="header" width="90px">Rank</th>
	      <th class="header" width="280px">Name</th>
	      <th class="header" width="174px">Role</th>
	      <th class="header" width="160px">Time in Service</th>
	      <th class="header" width="140px">Status</th>
	    </tr>	    
<?php
		$this->printPastRoster();
		
	}else {
			
		$result = $this->db->query("SELECT * FROM `rudi_combat_units` WHERE `detachment` = 0");
		$row = $this->db->fetch($result);
		foreach($row as $unit){
			$unit_id = $unit['unit_id'];
			decho("SELECT `member_id` FROM `rudi_unit_members` WHERE `cunit_id` = '$unit_id' AND `date_discharged` IS NULL LIMIT 1");
			$num = 0;
	 		$check = $this->db->Query("SELECT `member_id` FROM `rudi_unit_members` WHERE `cunit_id` = '$unit_id' AND `date_discharged` IS NULL LIMIT 1");
	 		$num = $this->db->Rows($check);
	 		if($num >= 1){
				echo "<tr><th colspan=\"5\">{$unit['name']} : {$unit['callsign']}</th></tr>";
?>
		<tr>
	      <!-- Table header -->
	      <th class="header" width="90px">Rank</th>
	      <th class="header" width="300px">Name</th>
	      <th class="header" width="214px">Role</th>
	      <th class="header" width="120px">Weapon</th>
	      <th class="header" width="120px">Status</th>
	    </tr>
<?php
				$this->printRoster($unit['unit_id'], $unit['leader_id']); 
				$this->displayUnitsRec($unit['unit_id']);
		    }
		}
		$this->printReserves();
	}

?>
</table>
</center>
