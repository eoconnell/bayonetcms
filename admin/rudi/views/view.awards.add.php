<?php
	$class_id = $_GET['cid'];
	$form = new BayonetForm("", "POST");
	if($form->verifySubmit('processed'))
	{
		global $db;
		$name = $form->request['name'];
		$text = $form->request['text'];
		$db->Query("INSERT INTO `rudi_awards` SET `class_id` = '$class_id', `name` = '$name', `image` = '', `description` = '$text'");
		
		PageRedirect(1, "?op=rudi&show=awards&cid={$class_id}");
		return;		
	}
	echo LinkInternal("Cancel","?op=rudi&show=awards&cid={$class_id}");
	OpenTable();
?>

<tr><th>Name:</th><td><?php $form->textField('name', "", false, "50"); ?></td><tr>
<tr><th>Image:</th><td><?php ?></td></tr>
<tr><th>Text:</th><td><?php $form->textArea('text',10,30); ?></td></tr>
<tr><td><?php $form->submitButton('processed', 'Add'); ?></td></tr>

<?php
	CloseTable();
	$form->__destruct();
?>

