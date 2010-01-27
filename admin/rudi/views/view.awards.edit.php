<?php 
	$award = getAward($award_id);
	$form = new BayonetForm("", "POST");
	if($form->verifySubmit('processed'))
	{
		echo "Key states<br/>\n";
		$keydump = print_r($form->getKeyStates($form->request), true);
		echo "<pre>{$keydump}</pre>\n";
			
		echo "<p>Transaction processed</p>\n";
			
	}
	OpenTable();
?>

<tr><th>Name:</th><td><?php $form->textField('name', $award['name'], false, "50"); ?></td><tr>
<tr><th>Image:</th><td><?php ?></td></tr>
<tr><th>Text:</th><td><?php $form->textArea('text',10,30,$award['description']); ?></td></tr>

<?php
	CloseTable();
	$form->__destruct();
?>

