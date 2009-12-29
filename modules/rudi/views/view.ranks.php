<?php define('BLOCK_RIGHT_DISABLE','block_right_disable'); ?>

<html>
<head>
  <title>Awards and Medals</title>

<style type="text/css">
p {color: white; }
body {background-color: black; }
th.header {
  width:175px;
  background:#333;
}

td.rudi {
  text-align: center;
  vertical-align: middle;
}
</style>
  
</head>
<body>

    <table align="center" style="width: 100%;">
      <tr>
        <th scope="col" class="header">Image</th>
        <th scope="col" class="header">Rank</th>
      </tr>
            <?php foreach($this->ranks as $rank): ?>
                <tr>
                  <td align='center' class="rudi"><img src="<?php echo "{$this->images_path}/ranks/small/{$rank->image}"; ?>"></img>&nbsp;</td>
                  <td align='center' class="rudi"><?php echo $rank->longname; ?>&nbsp;</td>
                </tr>
            <?php endforeach; ?>
            
    </table>

</body>
</html>