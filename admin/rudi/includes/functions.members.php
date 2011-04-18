<?php
	function selectUnits($previous_unit, $indent, $members_unit){
			global $db;
			
		  	$indent++;
		 	$formatting = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $indent); 
		
		    $result = $db->Query("SELECT `unit_id`, `name` FROM `rudi_combat_units` WHERE `detachment` = '$previous_unit'");
	 		$row = $db->Fetch($result);
	 		foreach($row as $unit){
				$unit_id = $unit['unit_id'];
				$unit_name = $unit['name'];
				if($members_unit==$unit_id)
		    		echo '<option value="'.$unit_id.'" selected>'.$formatting.$unit_name.'</option>';
       			else
	 				echo '<option value="'.$unit_id.'">'.$formatting.$unit_name.'</option>'; 
	 					
					selectUnits($unit_id, $indent, $members_unit);
			}
  	} 

 	function GetMember($member_id){
 		
		 global $db;
		 $result = $db->Query("SELECT * FROM `rudi_unit_members` WHERE `member_id` = '$member_id' LIMIT 1");
		 $row = $db->FetchRow($result);
		 return $row;		  	 	 	 	
 	}
 	
 	function GetWeapons(){
 		global $db;
		$result = $db->Query("SELECT * FROM `rudi_weapons` ORDER BY `model` DESC");
		$row = $db->Fetch($result);
		return $row; 	
 	}
 	
 	function GetMembersRoles($member_id){
 		global $db;
	  	$row = NULL;
		$query = sprintf("SELECT r.role_id, r.name AS role_name FROM rudi_roles AS r LEFT OUTER JOIN rudi_roles_container AS rl USING(role_id) INNER JOIN rudi_unit_members AS rm USING(member_id) WHERE rm.member_id = %d AND r.name IS NOT NULL ORDER BY r.role_id ASC", 
		(int)$member_id);	
	    
	    $result = $db->Query($query);
	    $row = $db->Fetch($result);
	    
	    return $row;
 	}
 	
 	function GetRoles(){
 		global $db;
 		$data = array();
		$result = $db->Query("SELECT * FROM `rudi_role_classes` ORDER BY `weight` ASC");
		$classes = $db->Fetch($result);
		
		foreach($classes as $class){
			$rclass_id = $class['rclass_id'];
			$result2 = $db->Query("SELECT * FROM rudi_roles WHERE rclass_id = '$rclass_id' ORDER BY `weight` ASC");
			$data[] = array("name" => $class['name'], "roles" => $db->Fetch($result2));	
		}
		
		return $data; 	
 	}
 	
 	function GetCountry(){
 		global $db;
		$result = $db->Query("SELECT `country_id`, `name` FROM `rudi_countries` ORDER BY `name`");
		$row = $db->Fetch($result);
		return $row; 	
 	}
 	
 	function GetRanks(){
 		global $db;
		$result = $db->Query("SELECT * FROM `rudi_ranks` ORDER BY `weight` DESC");
		$row = $db->Fetch($result);
		return $row; 	
 	}
 	
 	function GetStatuses(){
 		global $db;
		$result = $db->Query("SELECT * FROM `rudi_statuses`");
		$row = $db->Fetch($result);
		return $row; 	
 	}
 	
 	function GetServiceRecord($member_id){
 		global $db;
 		$result = $db->Query("SELECT `record_id`, `date_added`, `record_note`, `added_by` FROM `rudi_service_record` WHERE `member_id` = '$member_id'");
 		$row = $db->Fetch($result);
  		return $row;
 	}
 	
 	 function ListServiceRecord($member_id){
 		global $db;

		echo "<a href=\"?op=rudi&show=members&service={$member_id}&add=true\">Add New Record</a>";
		
		$records = GetServiceRecord($member_id);
		echo "<table width=\"100%\" style=\"text-align:center;\" >";
		echo "<tr><th>Record Date</th><th>Record Details</th></tr>";
		foreach($records as $record){
			echo "<tr><td>".date("M j Y", strtotime($record['date_added']))." <a href=\"?op=rudi&show=members&service={$member_id}&edit={$record['record_id']}\">Edit</a>&nbsp;<a href=\"?op=rudi&show=members&service={$row['member_id']}&delete={$record['record_id']}\">Delete</a></td><td>{$record['record_note']}</td></tr>";		
		}	
		CloseTable();			
 	}
 	
 	function EditServiceRecord($record_id){
 		global $db;
 		$result = $db->Query("SELECT `date_added`, `record_note`, `member_id` FROM `rudi_service_record` WHERE `record_id` = '$record_id' LIMIT 1"); 	
		$row = $db->FetchRow($result);
		
 		$form = new BayonetForm("", "POST");
 		if($form->verifySubmit('processed')){
			$date = $form->request['date'];
			$details = $form->request['details'];
			
			$db->Query("UPDATE `rudi_service_record` SET `date_added` = '$date', `record_note` = '$details' WHERE `record_id` = '$record_id' LIMIT 1");
			PageRedirect(1, "?op=rudi&show=members&service={$row['member_id']}&edit=".$record_id);
			return;
		}
		 	
		echo "<a href=\"?op=rudi&show=members&service={$row['member_id']}\">Cancel</a>";
		OpenTable();
?>	
		<tr><td>Date:</td><td><?php $form->textField('date', date('Y-m-d', strtotime($row['date_added']))); ?></td></tr>
		<tr><td>Details:</td><td><?php $form->textArea('details', 10, 30, $row['record_note']); ?></td></tr> 
		<tr><td colspan="2"><?php $form->submitButton('processed', 'Update'); ?></td></tr>
<?php
		CloseTable();
		$form->__destruct();
		
 	}
 	
 	function AddServiceRecord($member_id){
 		global $db;
 		
	 	$form = new BayonetForm("", "POST");
 		if($form->verifySubmit('processed')){
			$date = $form->request['date'];
			$details = $form->request['details'];
			decho($form->request);
			$db->Query("INSERT INTO `rudi_service_record` SET `member_id` = '$member_id', `date_added` = '$date', `record_note` = '$details', `added_by` = 1");
			PageRedirect(1, "?op=rudi&show=members&service={$member_id}");
			return;
		}
		 		
		$result = $db->Query("SELECT `date_added`, `record_note`, `member_id` FROM `rudi_service_record` WHERE `record_id` = '$record_id' LIMIT 1"); 	
		$row = $db->FetchRow($result);
		echo "<a href=\"?op=rudi&show=members&service={$member_id}\">Cancel</a>";
		OpenTable();
?>	
		<tr><td>Date:</td><td><?php $form->textField('date'); ?></td></tr>
		<tr><td>Details:</td><td><?php $form->textArea('details', 10, 30); ?></td></tr> 
		<tr><td colspan="2"><?php $form->submitButton('processed', 'Add'); ?></td></tr>
<?php
		CloseTable();
		$form->__destruct(); 	
 	}
 	
 	function GetAwardRecord($member_id){
 		global $db;
 		$result = $db->Query("SELECT r.record_id, r.date_added, r.record_note, r.added_by, a.name FROM rudi_award_record AS r LEFT OUTER JOIN rudi_awards AS a ON a.award_id = r.award_id WHERE r.member_id = '$member_id'");
 		$row = $db->Fetch($result);
  		return $row;
 	}
 	
 	function GetAllAwards(){
 		 global $db;
		 $result = $db->Query("SELECT `award_id`, `name` FROM `rudi_awards` ORDER BY `name`");
		 $row = $db->Fetch($result);	
		 return $row;
 	}
 		
	function ListAwardRecord($member_id){
 		global $db;

		echo "<a href=\"?op=rudi&show=members&award={$member_id}&add=true\">Add New Record</a>";
		
		$records = GetAwardRecord($member_id);
		echo "<table width=\"100%\" style=\"text-align:center;\" >";
		echo "<tr><th>Award Name</th><th>Record Date</th><th>Record Details</th><td></td><td></td></tr>";
		foreach($records as $record){
?>
			<tr>
				<td><?php echo $record['name']; ?></td>
				<td><?php echo date("M j Y", strtotime($record['date_added'])); ?></td>
				<td><?php echo $record['record_note']; ?></td>
				<td><a href="?op=rudi&show=members&award=<?php echo $member_id; ?>&edit=<?php echo $record['record_id']; ?>">Edit</a></td>
				<td><a href="?op=rudi&show=members&award=<?php echo $member_id; ?>&delete=<?php echo $record['record_id']; ?>">Delete</a></td>
			</tr>	
<?php	
		}	
		CloseTable();			
 	}
 	
 	function EditAwardRecord($record_id){
 		global $db;
 		$result = $db->Query("SELECT `award_id`, `date_added`, `record_note`, `member_id` FROM `rudi_award_record` WHERE `record_id` = '$record_id' LIMIT 1"); 	
		$row = $db->FetchRow($result);
		
 		$form = new BayonetForm("", "POST");
 		if($form->verifySubmit('processed')){
			$date = $form->request['date'];
			$details = $form->request['details'];
			$award_id = $_POST['award'];
			
			$db->Query("UPDATE `rudi_award_record` SET `date_added` = '$date', `award_id` = '$award_id', `record_note` = '$details' WHERE `record_id` = '$record_id' LIMIT 1");
			PageRedirect(1, "?op=rudi&show=members&award={$row['member_id']}&edit=".$record_id);
			return;
		}
	
		echo "<a href=\"?op=rudi&show=members&award={$row['member_id']}\">Cancel</a>";
		OpenTable();
?>
		<tr><td>Award:</td><td>
		<select name="award">
<?php 		$awards = GetAllAwards();
			foreach($awards as $award){
				if($award['award_id'] == $row['award_id'])
					echo "<option value=\"{$award['award_id']}\" selected>{$award['name']}</option>";
				else
					echo "<option value=\"{$award['award_id']}\">{$award['name']}</option>";			
			}
?>
		</select>
		</td></tr>
		<tr><td>Date:</td><td><?php $form->textField('date', date('Y-m-d', strtotime($row['date_added']))); ?></td></tr>
		<tr><td>Details:</td><td><?php $form->textArea('details', 10, 30, $row['record_note']); ?></td></tr> 
		<tr><td colspan="2"><?php $form->submitButton('processed', 'Update'); ?></td></tr>
<?php
		CloseTable();
		$form->__destruct();
		
 	}
 	
 	function DeleteAwardRecord($record_id){
 		  global $db;
  
		  $result = $db->Query("SELECT r.date_added, r.record_note, r.member_id, a.name FROM rudi_award_record AS r LEFT OUTER JOIN rudi_awards AS a ON a.award_id = r.award_id WHERE r.record_id = '$record_id' LIMIT 1");
		  $record = $db->FetchRow($result);
		  decho($record_id);
		  decho($record);
		  $form = new BayonetForm("", "POST");
		  
		  if(isset($_POST['proceed']))
		  {
		    echo "Award '{$record['name']}', was deleted from that soldiers record.";
		    $db->Query("DELETE FROM `rudi_award_record` WHERE `record_id` = '$record_id' LIMIT 1");
		    PageRedirect(2, "?op=rudi&show=members&award={$record['member_id']}");
		    return;
		  }
		  if(isset($_POST['cancel']))
		  {
		    echo "User cancelled deletion of award: '{$record['name']}'";
		    PageRedirect(2, "?op=rudi&show=members&award={$award['member_id']}");
		    return;
		  }
		  
		  OpenTable();
?>
		  <th>Are you <u>SURE</u> you want to delete the award record: '<?php echo $record['name'];?>'? for this member?<br />All changes are final.</th>
		  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
<?php
  		  CloseTable();
		  $form->__destruct(); 	
 	}
 	
 	function AddAwardRecord($member_id){
 		global $db;
 		
	 	$form = new BayonetForm("", "POST");
 		if($form->verifySubmit('processed')){
			$date = $form->request['date'];
			$details = $form->request['details'];
			$award_id = $_POST['award'];
			decho($form->request);
			$db->Query("INSERT INTO `rudi_award_record` SET `member_id` = '$member_id', `award_id` = '$award_id', `date_added` = '$date', `record_note` = '$details', `added_by` = 1");
			PageRedirect(1, "?op=rudi&show=members&award={$member_id}");
			return;
		}
		 		
		$result = $db->Query("SELECT `date_added`, `record_note`, `member_id` FROM `rudi_service_record` WHERE `record_id` = '$record_id' LIMIT 1"); 	
		$row = $db->FetchRow($result);
		echo "<a href=\"?op=rudi&show=members&award={$member_id}\">Cancel</a>";
		OpenTable();
?>	
		<tr><td>Award:</td><td>
		<select name="award">
<?php 		$awards = GetAllAwards();
			foreach($awards as $award){
					echo "<option value=\"{$award['award_id']}\">{$award['name']}</option>";			
			}
?>
		</select>
		</td></tr>
		<tr><td>Date:</td><td><?php $form->textField('date'); ?></td></tr>
		<tr><td>Details:</td><td><?php $form->textArea('details', 10, 30); ?></td></tr> 
		<tr><td colspan="2"><?php $form->submitButton('processed', 'Add'); ?></td></tr>
<?php
		CloseTable();
		$form->__destruct(); 	
 	}
?>