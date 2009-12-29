
<?php
if(isset($_POST['id']))
{
  $id = $_POST['id'];
  //unset($_POST);
	$modify = new AdminModify((int)$id);
  $edit =& $common->data[(int)$id];
}  
?>

<form method="POST">
<select name="id">
<?php foreach($common->data as $member):?>
  <option value="<?php echo $member->member_id ?>" <?php if(!is_null($id) && $id == $member->member_id) echo ' selected '; ?>><?php echo $member->name ?></option>
<?php endforeach; ?>
</select>
<button value="Select">Select</button>
</form>

<form action="" method="GET">
<table>
<tr><th>Modify Soldier</th></tr>
<tr><th>Last Name</th><td><input type="text" name="last" value="<?php echo $edit->last_name ?>" /></td></tr>
<tr><th>First Name</th><td><input type="text" value="<?php echo $edit->first_name ?>" /></td></tr>
<tr><th>Rank</th><td><select name="rank">
<?php foreach($common->getRanks() as $ranks): ?>
  <option value="<?php echo $ranks->rank_id ?>"><?php echo $ranks ?></option>
<?php endforeach; ?>
</select></td></tr>
<tr><th colspan="2"><input type="submit" value="submit"/></th></tr>
</table>
</form>

<?php decho($_POST); decho($common->data[$id]); //decho($common->getRanks())?>