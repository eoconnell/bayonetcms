<?php
  global $db;
  
  $result = $db->Query("SELECT CONCAT(last_name,', ',first_name) AS name FROM `rudi_unit_members` WHERE `member_id` = '$member_id' LIMIT 1");
  $member = $db->FetchRow($result);
  $form = new BayonetForm("", "POST");
  
  if(isset($_POST['proceed']))
  {
    //echo "Soldier '{$member['name']}', was deleted.";
    ReportError("This is not completed yet.");
    // DELETE unit_members, service_record, award_record FOR member_id
    //DeleteMember($member_id);
    PageRedirect(2, "?op=rudi&show=members");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of soldier: '{$member['name']}'";
    PageRedirect(2, "?op=rudi&show=members&profile={$member_id}");
    return;
  }
  
  OpenTable();
?>
  <th>Are you <u>SURE</u> you want to delete soldier: '<?php echo $member['name'];?>'?<br />All records for this soldier will be permenantly removed.</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
<?php
	CloseTable();
	$form->__destruct();
?>