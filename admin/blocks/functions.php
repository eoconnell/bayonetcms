<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler
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

function ListBlocks()
{
  global $db;
  $result = $db->Query("SELECT * FROM `bayonet_blocks` ORDER BY `active` DESC, `weight` ASC, `position`");
  $blocks = $db->Fetch($result);
  
  
  echo "<table align=\"center\"><tr><th colspan=\"3\">Existing Blocks</th></tr>";
  foreach($blocks as $block)
  {
    echo "<tr><td>{$block['weight']} : {$block['dir_name']}</td><td><a href=\"?load=admin&op=blocks&edit={$block['block_id']}\">Edit</a></td><td><a href=\"?load=admin&op=blocks&delete={$block['block_id']}\">Delete</a></td></tr>";
  }
  echo "</table>";
}

function NewBlock()
{
  global $db;
  if(isset($_POST['processed']))
  {
    //Secure our data to prevent injection attacks.
    $weight = addslashes($_POST['weight']);
    $dir_name = addslashes($_POST['dir_name']);
    $position = addslashes($_POST['position']);
    $active = addslashes($_POST['active']);
    $title = addslashes($_POST['title']);
    
    if(!is_int($weight) || empty($dir_name) || empty($title) || !is_int($position))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
    //Update the database with the new data.
    $db->Query("INSERT INTO `bayonet_blocks` SET `weight` = '$weight', `dir_name` = '$dir_name', `title` = '$title', `position` = '$position', `active` = '$active'");
    //die, because we have completed what we wanted to do.
    echo "New block, '$dir_name', at position '$weight' added.\n";
    return;
  }
    
  ?>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table align="center">
  <tr><th>Title</th><td><input type="text" name="title" value="<?php echo $block['title'] ?>"></td></tr>
  <tr><th>Weight</th><td><input type="text" name="weight" value="<?php echo $block['weight'] ?>"></td></tr>
  <tr><th>Position</th><td><input type="text" name="position" value="<?php echo $block['position'] ?>"></td></tr>
  <tr><th>Directory Name</th><td><input type="text" name="dir_name" value="<?php echo $block['dir_name'] ?>"></td>
  <tr><th>Active</th><td>
  <select name="active">
    <option value="1">Yes</option>
    <option value="0">No</option>
  </select></td>
  <tr><th colspan="2"><input type="submit" name="processed" value="Submit"></th></tr>
  </table>
  </form>
  <?php
}

function GetActive($block_id, &$active)
{ 
  $options = array(1 => 'Yes',0 => 'No');
  foreach($options as $option => $value)
  {
    $selected = NULL;
    if($active == $option)
    {
      $selected = "selected";
    }
    echo "<option " . $selected . " value=\"". $option ."\">" . $value . "</option>\n";  
  }
  

}

function EditBlock($block_id)
{
  global $db;
  if(isset($_POST['processed']))
  {
    //Secure our data to prevent injection attacks.
    $weight = (int) addslashes($_POST['weight']);
    $dir_name = addslashes($_POST['dir_name']);
    $position = (int) addslashes($_POST['position']);
    $active = addslashes($_POST['active']);
    $title = addslashes($_POST['title']);
    
    if(!is_int($weight) || empty($dir_name) || empty($title) || !is_int($position))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
    
    //Update the database with the new data.
    $db->Query("UPDATE bayonet_blocks SET weight = '$weight', dir_name = '$dir_name', position = '$position', active = '$active' WHERE block_id = '$block_id'");
    //$isActive = $active ? "IS" : "IS NOT";
    echo "Block, '$dir_name', at position '$weight' has been edited.\n";
    PageRedirect(3, "?op=blocks");
    //die, because we have completed what we wanted to do.
    return;
  }
  
  //Grab the page from the database according to the $page_id passed to the function.
  $result = $db->Query("SELECT weight,dir_name,position,active,title FROM bayonet_blocks WHERE block_id = '$block_id'");
  $block = $db->FetchRow($result);    

  ?>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table align="center">
  <tr><th>Title</th><td><input type="text" name="title" value="<?php echo $block['title'] ?>" /></td></tr>
  <tr><th>Weight</th><td><input type="text" name="weight" value="<?php echo $block['weight'] ?>" /></td></tr>
  <tr><th>Position</th><td><input type="text" name="position" value="<?php echo $block['position'] ?>" /></td></tr>
  <tr><th>Directory Name</th><td><input type="text" name="dir_name" value="<?php echo $block['dir_name'] ?>" /></td>
  <tr><th>Active</th><td>
    <select name="active">
      <?php GetActive($block_id, $block['active']) ?>  
    </select>
  </td>
  
  <tr><th colspan="2"><input type="submit" name="processed" value="Submit"></th></tr>
  </table>
  </form>
  <?php
}

function DeleteBlock($block_id)
{
  global $db;
  
  $result = $db->Query("SELECT dir_name FROM bayonet_blocks WHERE block_id = '$block_id'");
  $block = $db->Fetch($result);
  
  if(isset($_POST['proceed']))
  {
    echo "Block '{$block['dir_name']}', was deleted.";
    $db->Query("DELETE FROM bayonet_blocks WHERE block_id = '$block_id' LIMIT 1");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of page: '{$block['dir_name']}'";
    return;
  }
  
  ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <table align="center">
  <th>Are you SURE you want to delete the block titled: '<?php echo $block['dir_name']?>'?</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
  </table>
  </form>
  <?php  
}

?> 