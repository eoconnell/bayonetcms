<?php
  global $db;
  
  $result = $db->Query("SELECT `name`, `class_id` FROM `rudi_awards` WHERE `award_id` = '$award_id' LIMIT 1");
  $award = $db->FetchRow($result);
  $form = new BayonetForm("", "POST");
  
  if(isset($_POST['proceed']))
  {
    echo "Award '{$award['name']}', was deleted.";
    $db->Query("DELETE FROM `rudi_awards` WHERE `award_id` = '$award_id' LIMIT 1");
    PageRedirect(2, "?op=rudi&show=awards&cid={$award['class_id']}");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of award: '{$award['name']}'";
    PageRedirect(2, "?op=rudi&show=awards&cid={$award['class_id']}");
    return;
  }
  
  OpenTable();
?>
  <th>Are you <u>SURE</u> you want to delete the award titled: '<?php echo $award['name'];?>'?<br />All users who have recieved this award will lose it off their records (not yet at least).</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
<?php
	CloseTable();
	$form->__destruct();
?>