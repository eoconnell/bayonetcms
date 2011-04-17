<?php 
	$award = getAward($award_id);
	$form = new BayonetForm("", "POST");
	if($form->verifySubmit('processed'))
	{
		global $db;
		$name = $form->request['name'];
		$text = $form->request['text'];
		$db->Query("UPDATE `rudi_awards` SET `name` = '$name', `description` = '$text' WHERE `award_id` = '$award_id' LIMIT 1");
		
		PageRedirect(1, "?op=rudi&show=awards&award={$award_id}");
		return;		
	}
	echo LinkInternal("Cancel","?op=rudi&show=awards&cid={$award['class_id']}");
	OpenTable();
?>

<tr><th>Name:</th><td><?php $form->textField('name', $award['name'], false, "50"); ?></td><tr>
<tr><th>Image:</th><td><?php ?></td></tr>
<tr><th>Text:</th><td><?php $form->textArea('text',10,30,$award['description']); ?></td></tr>
<tr><td><?php $form->submitButton('processed', 'Update'); ?></td></tr>

<?php
	CloseTable();
	$form->__destruct();
?>

