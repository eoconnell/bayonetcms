<?php
		include $basedir.'rudi/includes/functions.awards.php';
		if(isset($_GET['award'])){
			$award_id = $_GET['award'];
			include 'view.awards.edit.php';
		}else if(isset($_GET['add'])){
			include 'view.awards.add.php';
		}else if(isset($_GET['delete'])){
			$award_id = $_GET['delete'];
			include 'view.awards.delete.php';
		}else{
			echo "<h3>Award Classes</h3>";
			$classes = getAwardClasses();
			OpenTable();
			echo "<tr style=\"text-align:center\">";
			foreach($classes as $class){
				echo "<td>".LinkInternal($class['name'],'?op=rudi&show=awards&cid='.$class['class_id'])."</td>";	
			}
			echo "</tr>";
			CloseTable();
			
			if(isset($_GET['cid'])){
				$class_id = $_GET['cid'];
				$awards = getAwardsByClass($class_id);
				echo "<h3>Awards</h3>";
				echo LinkInternal('<img src="images/add.png" />&nbsp;Add New Award','?op=rudi&show=awards&cid={$class_id}&add=true');
				OpenTable();
				foreach($awards as $award){
					echo "<tr><td>".$award['name']."</td>
						 <td><a href=\"?op=rudi&show=awards&award={$award['award_id']}\">Edit</a></td>
						 <td><a href=\"?op=rudi&show=awards&delete={$award['award_id']}\">Delete</a></td></tr>";				
				}
				CloseTable();
				//include 'view.members.profile.php';	
			}else if(isset($_GET['aid'])){
				$award_id = $_GET['aid'];
				//include 'view.members.service.php';
			}
		}
?>