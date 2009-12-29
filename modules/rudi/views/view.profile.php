<?php
define('BLOCK_RIGHT_DISABLE','block_right_disable');
$member =& $this->data[$_GET['profile']];
$uniform_image = strtolower($member->first_name[0] . $member->last_name . ".png");
$uniform_image[0] = strtoupper($uniform_image[0]);
$uniform_image[1] = strtoupper($uniform_image[1]);
?>

<html>
<head>
<title>Profile page of, <?php echo $member->last_name ?></title>
<style type="text/css">

p {color: white; }
body {background-color: black; }
th.header {
  width:100px;
  background:#333;
}

td {
  vertical-align: middle;
}

#thin {
  border:1px outset #333;
}
</style>
</head>
<body>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <th>Viewing Profile of: <?php echo $member->rank_long . " " . $member->first_name . " " . $member->last_name; ?></th>
  </tr>
  <tr>
    <td><center><img src="<?php echo $this->images_path ?>/uniform/<?php echo $uniform_image; ?>" />&nbsp;</center></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1">
        <tr>
          <td width="20%">
            <table width="100%" border="0" cellpadding="5" align="center" style="border: 0px;">
              <tr>
                <td><center><img src="<?php echo $this->images_path ?>/ranks/large/<?php echo $member->rank_image ?>" />&nbsp;</center></td>
              </tr>
              <tr>
                <td><center><img src="<?php echo $this->images_path ?>/flags/<?php echo $member->country_image?>" />&nbsp;</center></td>
              </tr>
            </table>
            </td>
          <td width="100%">
          <table width="100%" border="0" cellpadding="5">
              <tr>
                <th class="header" scope="row">Location</th>
                <td ><?php echo $this->evalData($member->location) ?>&nbsp;</td>
                <th class="header">Superior</th>
                <td><?php
                if(!is_null($member->superior_next->leader_id))
                  echo "<a href=\"?load=rudi&profile={$member->superior_next->leader_id}\">";
                
                echo $this->evalData($member->superior_next->name);      
                echo "</a>&nbsp;";
                  ?>
                  </td>
              </tr>
              <tr>
                <th class="header" scope="row">Status</th>
                <td><?php echo $this->evalData($member->status) ?>&nbsp;</td>
                <th class="header">Position</th>
                <td><?php echo $this->evalData($member->position) ?>&nbsp;</td>
              </tr>
              <tr>
                <th class="header" scope="row">Unit</th>
                <td><?php echo $this->evalData($member->unit_name) ?>&nbsp;</td>
                <th class="header">Weapon</th>
                <td><?php echo $this->evalData($member->weapon_name) ?>&nbsp;</td>
              </tr>
              <tr>
                <th class="header" scope="row">Platoon</th>
                <td><?php echo $this->evalData($member->platoon_name) ?>&nbsp;</td>
                <th class="header" scope="row">Enlisted</th>
                <td><?php echo $this->evalData($member->enlist_date) ?>&nbsp;</td>                
              </tr>
              <tr>
                <th class="header" scope="row">Squad</th>
                <td><?php echo $this->evalData($member->squad_name) ?>&nbsp;</td>
                <th class="header">Time In Service</th>
                  <?php if($member->discharge_date): ?>
                    <td><?php echo $this->getDiffTime($member->enlist_date_st, $member->discharge_date)?>&nbsp;</td>
                  <?php else: ?>
                 	  <td><?php echo $this->getDiffTime($member->enlist_date_st)?></td>
                  <?php endif; ?>
                
              </tr>
              <tr>
                <th class="header">Team</th>
                <td><?php echo $this->evalData($member->team_name) ?>&nbsp;</td>
                <th class="header">Time In Grade</th>
                <td><?php echo $this->getDiffTime($member->promo_date_st) ?>&nbsp;</td>
              </tr>
              <tr>
                <?php if($member->discharge_date): ?>
                <td colspan="2"></td>
				        <th class="header" scope="row">Separated</th>
                <td><?php echo $this->evalData($member->discharge_date) ?>&nbsp;</td>
                <?php endif; ?>
              </tr>
              
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" id="thin">
        <tr>
          <th class="header" scope="col">Biography</th>
        </tr>
        <tr >
          <td style="text-align:left;"><?php echo $member->bio ?>&nbsp;</td>
        </tr>
      </table>
      
      &nbsp;
      
      <table width="100%" border="0" cellpadding="1" id="thin">
        <tr>
          <th class="header" scope="col" colspan="3">Service Record</th>
        </tr>
        <tr>
       	<?php if(is_null($member->service_record)):?>
          <td>No service record available&nbsp;</td>
        <?php else:?>
        <?php foreach($member->service_record as $record): ?>
        <tr>
          <th class="header" width="25%"><?php echo $record->date_added ?>&nbsp;</th>
          <td><?php echo $record->record_note ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tr>
      </table>
      
      &nbsp;
      
      <table width="100%" border="0" cellpadding="1" id="thin">
        <tr>
          <th class="header" scope="col" colspan="4">Award Record</th>
        </tr>
        <tr>
       	<?php if(is_null($member->award_record)):?>
          <td>No award record available&nbsp;</td>
        <?php else:?>
        <?php foreach($member->award_record as $record): ?>
        <tr>
          <th class="header" width="25%"><?php echo $record->date_added?>&nbsp;</th>
          <td ><?php echo $this->evalData($record->award_name); ?>&nbsp;</td>
          <td style="vertical-align:middle;"><center><img src="<?php echo $this->images_path; ?>/medals/<?php echo $record->image; ?>"/></center></td>
          <td width="40%"><?php echo $record->record_note ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tr>
      </table>
      
      &nbsp;
      
            <table width="100%" border="0" cellpadding="1" id="thin">
        <tr>
          <th class="header" scope="col" colspan="3">Combat Record</th>
        </tr>
        <tr>
       	<?php if(is_null($member->combat_record)):?>
          <td>No combat record available&nbsp;</td>
        <?php else:?>
        <?php foreach($member->combat_record as $record): ?>
        <tr>
          <th class="header" width="25%"><?php echo $record->date ?>&nbsp;</th>
          <td><a href="<?php echo $record->website ?>"><?php echo $record->name ?></a>&nbsp;</td>
          <td><?php echo $record->status ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>