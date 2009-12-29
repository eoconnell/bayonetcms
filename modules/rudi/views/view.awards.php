<?php define('BLOCK_RIGHT_DISABLE','block_right_disable'); ?>
<?php $medals_path = $this->images_path . "/medals/"; ?>

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

<?php $classes = $this->getAwardClasses(); ?>
<table align="center" style="width: 100%;">

  <?php     
    $i = 0;
    $cl = 0;
    while($cl != count($classes))
    {
      echo "<tr>";
      echo "<th colspan=\"3\">{$classes[$cl]->name}s</th>";
      echo "</tr>";
      echo '<th scope="col" class="header" style="width:1px;">Image</th>';
      echo '<th scope="col" class="header" style="width:1px;">Award</th>';
      echo '<th scope="col" class="header" style="width:85%;">Description</th>';
      
      foreach($this->awards as $award)
      {
        if($classes[$cl]->class_id == $award->class_id)
        {
          echo "
          <tr>
          <td align=\"center\" class=\"rudi\"><img src=\"{$medals_path}{$award->image}\" alt=\"{$award->image}\"/></td>
          <td align=\"center\" class=\"rudi\">{$award->name}&nbsp;</td>
          <td align=\"left\" class=\"rudi\" style=\"text-align:left;\">{$award->description}&nbsp;</td>
          </tr>";             
        }                        

      }
      
      ++$cl;
    }
  ?>

</table>

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