<?php
		 global $db;
		 
		 if(isset($_POST['processed'])){
		 	
	 		echo "Please wait while the information is processed...";
		 	
		 	$rank_id = $_POST['rank'];
		 	$country_id = $_POST['country'];
		 	$status_id = $_POST['status'];
		 	$role_id = $_POST['role'];
		 	$unit_id = $_POST['unit'];
			$weapon_id = $_POST['weapon'];
		 	$first_name = addslashes($_POST['first']);
		 	$last_name = addslashes($_POST['last']);
		 	$username = addslashes($_POST['username']);
		 	$city = addslashes($_POST['city']);
		 	$province = addslashes($_POST['province']);
		 	$primary_mos = addslashes($_POST['primmos']);		 	
		 	$enlisted = addslashes($_POST['enlist']);
		 	$promoted = addslashes($_POST['promote']);
		 	$discharged = addslashes($_POST['discharge']);
		 	$xfire = addslashes($_POST['xfire']);
		 	$email = addslashes($_POST['email']);
		 	$bio = addslashes($_POST['bio']);
		 	
		 	//$discharged = empty($discharged) ? NULL : "'{$discharged}'";

 			$query = "UPDATE `rudi_unit_members` SET"
			 		." `rank_id` = '$rank_id',"
			 		." `country_id` = '$country_id',"
					." `status_id` = '$status_id',"
					." `cunit_id` = '$unit_id',"
					." `weapon_id` = '$weapon_id',"
					." `username` = '$username',"
					." `email` = '$email',"
					." `xfire` = '$xfire',"
					." `first_name` = '$first_name',"
					." `last_name` = '$last_name',"
					." `location_city` = '$city',"
					." `location_province` = '$province',"
					." `bio` = '$bio',"
					." `date_enlisted` = '$enlisted',"
					." `date_promotion` = '$promoted',"
					." `primary_mos` = '$primary_mos',";
			if(empty($discharged))
				$query = $query." `date_discharged` = null";
			else
				$query = $query." `date_discharged` = '$discharged'";	
			$query = $query." WHERE `member_id` = '$member_id' LIMIT 1";
			decho($query);
		 	$db->Query($query);
		 	
		 	/* do the role query as well */
		 	PageRedirect(1, "?op=rudi&show=members&profile={$member_id}");
		 	return;		 
		 } 	
		 $member = GetMember($member_id);
?>
		<a href="?op=rudi&show=members">Cancel</a><br />
		<form method="POST" action="">
		<table width="100%" style="text-align:center;">
		<tr><th colspan="2" style="background-color:#c4c4c4;">Personnel File of <?php echo $member['first_name']." ".$member['last_name']; ?></th></tr>
		<tr><td class="right" width="50%">Rank:</td><td class="left">
			<select name="rank">
<?php		$ranks = GetRanks();
			foreach($ranks as $rank){
				if($rank['rank_id'] == $member['rank_id'])
					echo "<option value=\"{$rank['rank_id']}\" selected>{$rank['longname']}</option>";
				else
					echo "<option value=\"{$rank['rank_id']}\">{$rank['longname']}</option>";			
			}
?>
			</select>
		</td></tr>
		<tr><td class="right">Country:</td><td class="left">
			<select name="country">
<?php		$countries = GetCountry();
			foreach($countries as $country){
				if($country['country_id'] == $member['country_id'])
					echo "<option value=\"{$country['country_id']}\" selected>{$country['name']}</option>";
				else
					echo "<option value=\"{$country['country_id']}\">{$country['name']}</option>";			
			}
?>
			</select>
		</td></tr>
		</table>
		<table width="100%" style="text-align:center;">
		<tr><th colspan="2" style="background-color:#c4c4c4;">Vital Statistics</th></tr>
		<tr>
			<td class="right" width="50%">First:</td>
			<td class="left"><input type="text" name="first" value="<?php echo $member['first_name']; ?>" /></td>
		</tr>
		<tr>
			<td class="right">Last:</td>
			<td class="left"><input type="text" name="last" value="<?php echo $member['last_name']; ?>" /></td>
		</tr>
		<tr><td class="right">Username:</td><td class="left"><input type="text" name="username" value="<?php echo $member['username']; ?>" /></td></tr>
		<tr><td class="right">City:</td><td class="left"><input type="text" name="city" value="<?php echo $member['location_city']; ?>"/></td></tr>
		<tr><td class="right">Province:</td><td class="left"><input type="text" name="province" value="<?php echo $member['location_province']; ?>" /></td></tr>
		<tr><td class="right">Status:</td><td class="left">
			<select name="status">
<?php		$statuses = GetStatuses();
			foreach($statuses as $status){
				if($status['status_id'] == $member['status_id'])
					echo "<option value=\"{$status['status_id']}\" selected>{$status['name']}</option>";
				else
					echo "<option value=\"{$status['status_id']}\">{$status['name']}</option>";			
			}
?>
		</select>
		</td></tr>
		<tr><td class="right">Primary MOS:</td><td class="left"><input type="text" name="primmos" value="<?php echo $member['primary_mos']; ?>" /></td></tr>
		<tr>
			<td class="right">Role:</td>
			<td class="left">
			<select name="role">
<?php
			$member_roles = GetMembersRoles($member['member_id']);
			$roles = GetRoles();	
			foreach($member_roles as $member_role){}
			foreach($roles as $role){
				if($role['role_id']==$member_role['role_id'])
					echo "<option value=\"{$role['role_id']}\" selected>{$role['name']}</option>";
				else
					echo "<option value=\"{$role['role_id']}\">{$role['name']}</option>";			
			}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="right" style="font-weight:bold;">Unit:</td>
			<td class="left">
			<select name="unit">
		    	<option value="0">N/A</option>
<?php
					$result = $db->Query("SELECT `unit_id`, `name` FROM `rudi_combat_units` WHERE `detachment` = 0 ");
	    			$row = $db->Fetch($result);
	    			foreach($row as $unit){
	    				$unit_name = $unit['name'];
	    				$unit_id = $unit['unit_id'];
						if($member['cunit_id']==$unit_id)
	    					echo '<option value="'.$unit_id.'" selected>'.$unit_name.'</option>';
	       				else
 							echo '<option value="'.$unit_id.'">'.$unit_name.'</option>';
						selectUnits($unit_id, 0, $member['cunit_id']);
					}
?>
		    	</select>
			</td>
		</tr>
		<tr><td class="right">Weapons:</td><td class="left">
			<select name="weapon">
<?php		$weapons = GetWeapons();
			foreach($weapons as $weapon){
				if($weapon['weapon_id'] == $member['weapon_id'])
					echo "<option value=\"{$weapon['weapon_id']}\" selected>{$weapon['model']}</option>";
				else
					echo "<option value=\"{$weapon['weapon_id']}\">{$weapon['model']}</option>";			
			}
?>
		</select>
		</td></tr>
		<tr>
			<td class="right">Enlisted Date:</td>
			<td class="left"><input type="text" name="enlist" value="<?php echo !empty($member['date_enlisted']) ? date('Y-m-d', strtotime($member['date_enlisted'])) : ""; ?>" /></td>
		</tr>
		<tr>
			<td class="right">Promotion Date:</td>
			<td class="left">
				<input type="text" name="promote" value="<?php echo !empty($member['date_promotion']) ? date('Y-m-d', strtotime($member['date_promotion'])) : ""; ?>" />
			</td>
		</tr>
		<tr>
			<td class="right">Discharge Date:</td>
			<td class="left"><input type="text" name="discharge" value="<?php echo !empty($member['date_discharged']) ? date('Y-m-d', strtotime($member['date_discharged'])) : ""; ?>" /></td>
		</tr>
		<tr>	
			<td class="right">Xfire:</td>
			<td class="left"><input type="text" name="xfire" value="<?php echo $member['xfire']; ?>"/></td>
		</tr>
		<tr>
			<td class="right">E-Mail:</td>
			<td class="left"><input type="text" name="email" value="<?php echo $member['email']; ?>"/></td>
		</tr>
		</table>
		<br />
		<table width="100%" style="text-align:center;">
		<tr><th colspan="2" style="background-color:#c4c4c4;">Personal Bio</th></tr>
		<tr><td><textarea rows="7" name="bio" cols="60"><?php echo $member['bio'];?></textarea></td></tr>
		<tr><td colspan="2"><input type="submit" value="Submit" name="processed" /></td>
		</table>
		</form>