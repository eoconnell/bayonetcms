<?php
//define('BLOCK_RIGHT_DISABLE','block_right_disable');
$member =& $this->data[$_GET['profile']];
$uniform_image = "modules/rudi/images/uniform/".$member->first_name[0].str_replace(array("'", "\""), "", $member->last_name).".png";
decho($member);
define('BLOCK_RIGHT_DISABLE', true);

$arrUnits = $this->getUnitArr($_GET['profile']);
decho($arrUnits);
?>

<style type="text/css">


</style>

<table class="rudi" width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <th class="header">Viewing Profile of: <?php echo $member->rank_long . " " . $member->first_name . " " . $member->last_name; ?></th>
  </tr>
  <tr>
    <td><center>
<?php
		if(file_exists($uniform_image)){
			echo '<img src="'.$uniform_image.'" />';		
		}
?>
		&nbsp;</center></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1">
        <tr>
          <td width="20%">
            <table width="100%" border="0" cellpadding="5" align="center" style="border: 0px;">
           	  <tr>
           	  	<td><center><span style="font-weight: bold; font-size: 16px; font-family: arial;"><?php echo $member->primary_mos; ?></span></center></td>
   	  		  </tr>
              <tr>
                <td><center>
			<?php 
			  	if(file_exists("modules/rudi/images/ranks/large/{$member->rank_image}")){
          		   	echo "<img src=\"modules/rudi/images/ranks/large/{$member->rank_image}\" alt=\"{$member->rank_short}\" />";       	
          		}else{
          			echo $member->rank_short;       		
          		}
		  	?>
              </center></td></tr>
              <tr>
                <td><center><img src="modules/rudi/images/flags/<?php echo $member->country_image; ?>" />&nbsp;</center></td>
              </tr>
            </table>
            </td>
          <td width="100%">
          <table width="100%" border="0" cellpadding="5">
              <tr>
                <th class="header" scope="row">Location</th>
                <td class="info"><?php echo $this->evalData($member->location); ?>&nbsp;</td>
                <th class="header">Reports To</th>
                <td class="info"><?php
                if(!is_null($member->superior->leader_id))
                  echo "<a href=\"?load=rudi&profile={$member->superior->leader_id}\">";
                
                echo $this->evalData($member->superior->name);      
                echo "</a>&nbsp;";
                  ?>
                  </td>
              </tr>
              <tr>
                <th class="header" scope="row">Status</th>
                <td class="info"><?php echo $this->evalData($member->status); ?>&nbsp;</td>
                <th class="header">Position</th>
                <td class="info"><?php echo $this->evalData($member->role_name); ?>&nbsp;</td>
              </tr>
              <tr> 
                <th class="header" scope="row">Unit</th>
                <td class="info"><?php echo $this->evalData($arrUnits[0]['name']); ?>&nbsp;</td>
                <th class="header">Weapon</th>
                <td class="info"><?php echo $this->evalData($member->weapon_model); ?>&nbsp;
						<?php if($member->weapon2_model != NULL)
								 echo "/&nbsp;&nbsp;".$member->weapon2_model;
					 	?>
				</td>
              </tr>
              <tr>
                <th class="header" scope="row">Platoon</th>
                <td class="info"><?php echo $this->evalData($arrUnits[1]['name']); ?>&nbsp;</td>
                <th class="header" scope="row">Enlisted</th>
                <td class="info"><?php echo $this->evalData($member->enlist_date); ?>&nbsp;</td>                
              </tr>
              <tr>
                <th class="header" scope="row">Squad</th>
                <td class="info"><?php echo $this->evalData($arrUnits[2]['name']); ?>&nbsp;</td>
                <th class="header">Time In Service</th>
                  <?php if($member->discharge_date): ?>
                    <td class="info"><?php echo $this->getDiffTime($member->enlist_date_st, $member->discharge_date); ?>&nbsp;</td>
                  <?php else: ?>
                 	  <td class="info"><?php echo $this->getDiffTime($member->enlist_date_st); ?></td>
                  <?php endif; ?>
                
              </tr>
              <tr>
                <th class="header">Team</th>
                <td class="info"><?php echo $this->evalData($arrUnits[3]['name']); ?>&nbsp;</td>
                <th class="header">Time In Grade</th>
                <?php if($member->discharge_date): ?>
                	<td class="info"><?php echo $this->getDiffTime($member->promo_date_st, $member->discharge_date); ?>&nbsp;</td>
               	<?php else: ?>
               		<td class="info"><?php echo $this->getDiffTime($member->promo_date_st); ?></td>
        		<?php endif; ?>
              </tr>
              <tr>
                <?php if($member->discharge_date): ?>
                <td class="info" colspan="2"></td>
				        <th class="header" scope="row">Separated</th>
                <td class="info"><?php echo $this->evalData($member->discharge_date); ?>&nbsp;</td>
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
          <td style="text-align:left;"><?php echo $member->bio; ?>&nbsp;</td>
        </tr>
      </table>
      
      &nbsp;
      
      <table width="100%" border="0" cellpadding="1" id="thin">
        <tr>
          <th class="header" scope="col" colspan="3">Service Record</th>
        </tr>
        <tr>
       	<?php if($this->evalData($member->service_record)):?>
          <td>No service record available&nbsp;</td>
        <?php else:?>
        <?php foreach($member->service_record as $record): ?>
        <tr>
          <th class="header" width="25%"><?php echo date('M j, Y', strtotime($record->date_added)); ?>&nbsp;</th>
          <td style="text-align:left; padding-left: 10px;"><?php echo $record->record_note; ?>&nbsp;</td>
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
       	<?php if($this->evalData($member->award_record)):?>
          <td>No award record available&nbsp;</td>
        <?php else:?>
        <?php foreach($member->award_record as $record): ?>
        <tr>
          <th class="header" width="25%"><?php echo date('M j, Y', strtotime($record->date_added)); ?>&nbsp;</th>
          <td style="text-align:left; padding-left: 10px;" ><?php echo $this->evalData($record->award_name); ?>&nbsp;</td>
          <td style="vertical-align:middle;"><center><img src="modules/rudi/images/medals/<?php echo $record->image; ?>"/></center></td>
          <td width="40%" style="text-align:left; padding-left: 10px;"><?php echo $record->record_note; ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tr>
      </table>
      
      &nbsp;
      
            <table width="100%" border="0" cellpadding="1" id="thin">
        <tr>
          <th class="header" scope="col" colspan="4">Combat Record</th>
        </tr>
        <tr>
       	<?php if($this->evalData($member->combat_record)):?>
          <td>No combat record available&nbsp;</td>
        <?php else:?>
        <?php foreach($member->combat_record as $record): ?>
        <tr>
          <th class="header" width="25%"><?php echo date('M j, Y', strtotime($record->date)); ?>&nbsp;</th>
          <td><a href="<?php echo $record->website; ?>"><?php echo $record->name; ?></a>&nbsp;</td>
          <td><?php echo $record->title; ?>&nbsp;</td>
          <td><?php echo $record->status . ' '. $record->home_score . '-' . $record->visit_score; ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tr>
      </table></td>
  </tr>
</table>