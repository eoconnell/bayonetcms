<?php //define('BLOCK_RIGHT_DISABLE','block_right_disable'); ?>

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

    <table class="rudi" align="center" style="width: 100%;">
      <tr>
        <th scope="col">Image</th>
        <th scope="col">Rank</th>
      </tr>
            <?php foreach($this->ranks as $rank): ?>
                <tr>
                  <td><img src="<?php echo "modules/rudi/images/ranks/small/{$rank->image}"; ?>" />&nbsp;</td>
                  <td><?php echo $rank->longname; ?>&nbsp;</td>
                </tr>
            <?php endforeach; ?>
            
    </table>

</body>
</html>