<?php 
/**
 * Bayonet Content Management System - RUDI
 * Copyright (C) 2008-2011  Joseph Hunkeler & Evan O'Connell
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

?>
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

<?php $classes = $this->getAwardClasses(); ?>
<table class="rudi" align="center" style="width: 100%;">

  <?php     
    $i = 0;
    $cl = 0;
    while($cl != count($classes))
    {
      echo "<tr>";
      echo "<th colspan=\"3\">{$classes[$cl]->name}s</th>";
      echo "</tr>";
      echo '<th scope="col">Image</th>';
      echo '<th scope="col" width=\"100px\">Award</th>';
      echo '<th scope="col">Description</th>';
      
      foreach($this->awards as $award)
      {
        if($classes[$cl]->class_id == $award->class_id)
        {
          echo "
          <tr>
          <td><img src=\"modules/rudi/images/medals/{$award->image}\" alt=\"{$award->image}\"/></td>
          <td>{$award->name}&nbsp;</td>
          <td style=\"text-align:left;\">{$award->description}&nbsp;</td>
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
