<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler & Evan O'Connell
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
 
	function EditPoints(){
		
		global $db;
		
		$result = $db->Query("SELECT * FROM `rudi_unit_members` JOIN `rudi_ranks` ON rudi_unit_members.rank_id=rudi_ranks.rank_id WHERE rudi_unit_members.status_id < 4  ORDER BY rudi_ranks.weight DESC , rudi_unit_members.date_promotion ASC , rudi_unit_members.date_enlisted ASC");
		$row = $db->Fetch($result);
		
		if(isset($_POST['processed'])){
			echo "Updating data... Please wait.";
			foreach($row as $soldier){
				$mID = $soldier['member_id'];
		    	$missed = $_POST[$mID.'missed'];
		    	$attended = $_POST[$mID.'attended'];
		    	$points = $_POST[$mID.'points'];
	
		    	if($missed !="" && $points != ""){
		    		$db->Query("UPDATE `rudi_unit_members` SET `points` = $points, `drillcount` = $missed, `attendcount` = $attended WHERE `member_id` = $mID LIMIT 1");
	    		}else{
	    			ReportError("Error updating points for soldier id# '$mID'. Please contact administrator.");    		
	    		}			
			}
			PageRedirect(1,"?op=adjutant&edit=points");
			return;		
		}
?>
		<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
		<table style="text-align:center;" width="100%" cellspacing="0">
		<?php //OpenTable(); ?>
		<tr><th>Rank</th><th>Soldier</th><th>Status</th><th>Points</th><th>Drills Missed</th><th>Drills Attended</th></tr>
<?php
		foreach($row as $soldier){
			$memberID = $soldier['member_id'];
			if($soldier['status_id'] != 1)
				echo "<tr class=\"inactive\">";
			else
				echo "<tr>";
			echo "<td>{$soldier['shortname']}</td>
	  <td>{$soldier['first_name']} {$soldier['last_name']}</td>
	  <td>".getStatus($soldier['status_id'])."</td>
	  <td><input type=\"text\" class=\"lrg\" value=\"{$soldier['points']}\" name=\"{$memberID}points\" size=\"1\" maxlength=\"3\" />/100</td>
	  <td><input type=\"text\" class=\"lrg\" value=\"{$soldier['drillcount']}\" name=\"{$memberID}missed\" size=\"1\" maxlength=\"1\" />/3</td>
	  <td><input type=\"text\" class=\"lrg\" value=\"{$soldier['attendcount']}\" name=\"{$memberID}attended\" size=\"1\" maxlength=\"1\" />/3</td>";		
			
			
		echo "<input type=\"hidden\" value=\"{$memberID}\" name=\"{$memberID}id\" />\n";
		}
		CloseTable();
		echo "<input type=\"submit\" name=\"processed\" value=\"Update Points\" /></form>";

	}

/****** NEW CODE ADDED LARRABEE 11-20-2012 ********/
        function EditPoints2(){

                global $db;

                $result = $db->Query("SELECT * FROM `rudi_unit_members` JOIN `rudi_ranks` ON rudi_unit_members.rank_id=rudi_ranks.rank_id WHERE rudi_unit_members.status_id < 4  ORDER BY rudi_ranks.weight DESC , rudi_unit_members.date_promotion ASC , rudi_unit_members.date_enlisted ASC");
                $row = $db->Fetch($result);

                if(isset($_POST['processed'])){
                        echo "Updating data... Please wait.";
                        foreach($row as $soldier){
                                $mID = $soldier['member_id'];
                        $missed = $_POST[$mID.'missed'];
                        $attended = $_POST[$mID.'attended'];
                        $points = $_POST[$mID.'points'];

                        if($missed !="" && $points != ""){
                                $db->Query("UPDATE `rudi_unit_members` SET `points` = $points, `drillcount` = $missed, `attendcount` = $attended WHERE `member_id` = $mID LIMIT 1");
                        }else{
                                ReportError("Error updating points for soldier id# '$mID'. Please contact administrator.");
                        }
                        }
                        PageRedirect(1,"?op=adjutant&edit=pointsnew");
                        return;
                }
?>
                <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                <table style="text-align:center;" width="100%" cellspacing="0">
                <?php //OpenTable(); ?>
                <tr><th>Rank</th><th>Soldier</th><th>Status</th><th>Points</th><th>Drills Missed</th><th>Drills Attended</th></tr>
<?php
                foreach($row as $soldier){
                        $memberID = $soldier['member_id'];
                        if($soldier['status_id'] != 1)
                                echo "<tr class=\"inactive\">";
                        else
                                echo "<tr>";
                        echo "<td>{$soldier['shortname']}</td>
          <td>{$soldier['first_name']} {$soldier['last_name']}</td>
          <td>".getStatus($soldier['status_id'])."</td>
          <td><input type=\"text\" class=\"lrg\" value=\"{$soldier['points']}\" name=\"{$memberID}points\" size=\"1\" maxlength=\"3\" />/100</td>
          <td><input type=\"text\" class=\"lrg\" value=\"{$soldier['drillcount']}\" name=\"{$memberID}missed\" size=\"1\" maxlength=\"1\" />/3</td>
          <td><input type=\"text\" class=\"lrg\" value=\"{$soldier['attendcount']}\" name=\"{$memberID}attended\" size=\"1\" maxlength=\"1\" />/3</td>";


                echo "<input type=\"hidden\" value=\"{$memberID}\" name=\"{$memberID}id\" />\n";
                }
                CloseTable();
                echo "<input type=\"submit\" name=\"processed\" value=\"Update Points\" /></form>";

        }
/****** END NEW CODE ADDED *******/
	
	function EditLOAs($status_id = 1){
	
		global $db;

		$result = $db->Query("SELECT * FROM `rudi_unit_members` JOIN `rudi_ranks` ON rudi_unit_members.rank_id=rudi_ranks.rank_id WHERE rudi_unit_members.status_id = '$status_id' ORDER BY rudi_ranks.weight DESC , rudi_unit_members.date_promotion ASC , rudi_unit_members.date_enlisted ASC");
		$row = $db->Fetch($result);
?>		
 	<script type="text/javascript">

		function switchOption(id)
		{ 
			var op = document.getElementById(id).value;
			location.href="?op=adjutant&edit=loas&id="+op+"";	
		}
	</script>
<?php
	 
	 $opArr = Array();
	 $opArr[1] = "Active Soldiers";
	 $opArr[2] = "Soldiers on Leave";
	 $opArr[3] = "Soldiers on Extended Leave";
	 
	 echo 'Viewing: <select id="option" name="option" onchange="switchOption(this.id)">';
		for($x=1; $x<4; $x++){
			if($status_id == $x)
				echo '<option value="'.$x.'" selected>'.$opArr[$x].'</option>';
			else
				echo '<option value="'.$x.'">'.$opArr[$x].'</option>';	
		}
	 echo '</select>';
		
?>
		<table style="text-align:center;" width="100%">
		<tr><th>Rank</th><th>Soldier</th><th>Status</th></tr>
<?php
$num = 1;
		foreach($row as $member){
			if($num %2 == 0)
				echo "<tr style=\"background-color:#dfdfdf;\">";
			else
				echo "<tr>";
			echo "<td>{$member['shortname']}</td><td>{$member['first_name']} {$member['last_name']}</td><td><a href=\"?op=adjutant&edit=loas&member={$member['member_id']}\">Edit</a></td></tr>";
			$num++;
		}
		CloseTable();
	}
	
	function EditStatus($member_id){
		global $db;
		
		$form = new BayonetForm("", "POST");
		if($form->VerifySubmit('processed')){
			echo "Please wait while your information is being processed...";
			$status_id = $form->request['status'];
			$db->query("UPDATE `rudi_unit_members` SET `status_id` = '$status_id' WHERE `member_id` = '$member_id' LIMIT 1");
			PageRedirect(1, "?op=adjutant&edit=loas&member={$member_id}");
			return;
		}
		
		$result = $db->Query("SELECT * FROM `rudi_unit_members` JOIN `rudi_ranks` ON rudi_unit_members.rank_id=rudi_ranks.rank_id WHERE `member_id` = '$member_id' LIMIT 1");
		$row = $db->FetchRow($result);
?>
		<center>
		<table width="50%" style="text-align:center;">
		<tr><th>Rank</th><th>Soldier</th><th>Status</th></tr>
		<tr>
			<td><?php echo $row['shortname']; ?></td>
			<td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
			<td style="text-align:left;">
				<?php $form->radioButton('status', 1, $row['status_id'] == 1 ? true : false); ?>Active<br />
				<?php $form->radioButton('status', 2, $row['status_id'] == 2 ? true : false); ?>On Leave<br />
				<?php $form->radioButton('status', 3, $row['status_id'] == 3 ? true : false); ?>On Extended Leave
			</td>
		</tr>
		<tr><td colspan="3"><?php $form->submitButton('processed'); ?></td></tr>
		</table>
		</center>
<?php

		$form->__destruct();
		
	}
	
  function getStatus($sID){
  	global $db;
  	$gStatusName = "N/A";
  	
 		$result = $db->Query("SELECT `name` FROM `rudi_statuses` WHERE `status_id` = $sID LIMIT 1");
	    $row = $db->FetchRow($result);    	
		
	return $row['name'];
  }
 ?>
