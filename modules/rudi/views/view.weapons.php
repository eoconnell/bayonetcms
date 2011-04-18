<?php define('BLOCK_RIGHT_DISABLE','block_right_disable'); ?>
<?php $medals_path = $this->images_path . "/medals/"; ?>

<html>
<head>
  <title>Awards and Medals</title>

<style type="text/css">
/*th.header {
  width:175px;
  background:#333;
}

td.rudi {
  text-align: center;
  vertical-align: middle;
} */
</style>
  
</head>
<body>

<?php $weapons = $this->getWeapons("ORDER BY role ASC, caliber ASC, model ASC"); ?>
<center>
<table class="rudiroster" cellspacing="1" cellpadding="0" align="center">
<tr><th width="250px">Model</th><th width="250px">Caliber</th><th width="250px">Role</th></tr>
  <?php     
	$num=0;
	$role = "Assault";
	foreach($weapons as $weapon){
		if($role != $weapon['role']){
			echo '<tr class="null" style="height:3px;"></tr>';		
		}
		if($num%2==0)
			echo '<tr class="high">';
		else	
			echo "<tr>";
		echo "<td>".$weapon['model']."</td><td>".$weapon['caliber']."</td><td>".$weapon['role']."</td></tr>";
		$role = $weapon['role'];
		$num++;
	}

  ?>

</table>
</center>
<!-- grr wtf
    <table align="center" style="width: 100%;">
      <tr>
        <th scope="col" class="header" style="width:1px;">Image</th>
        <th scope="col" class="header" style="width:1px;">Award</th>
        <th scope="col" class="header">Description</th>
      </tr>

  
  <?php //foreach($this->awards as $award): ?>

      <tr>
        <td align='center' class="rudi"><img src="/rudi/images/medals/<?php //echo $award->image; ?>"></img>&nbsp;</td>
        <td align='center' class="rudi"><?php //echo $award->name; ?>&nbsp;</td>
        <td align='left'><?php //echo wordwrap($award->description,80,"<br/>"); ?>&nbsp;</td>
      </tr>
      
  <?php //endforeach; ?>
  

    </table>
-->
</body>
</html>