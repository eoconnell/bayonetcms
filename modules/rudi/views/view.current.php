<?php 
  $platoon_temp_count = 0; $squad_temp_count = 0;
  
?>

<html>
<head>
  <title>Roster Current</title>

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

  <?php
  /*
    echo "<table align=\"center\">";
    
    echo "<tr>
      <th>Rank</th>
      <th>Name</th>
      <th>Weapon</th>
      <th>Status</th>
    </tr>";
    
    $p = 1;
    $s = 1;
    $u = 1;
    $members = $this->data;
    while($u != count($members))
    {
      while($p != $stats['platoon'])
      {
        echo "<tr>
          <th>a platoon</th>
        </tr>";
        
        while($s != $stats['squad'])
        {
          if($members[$u]->squad_id)
          echo "<tr>
            <td>{$members[$u]->rank_short}</td>
            <td>{$members[$u]->name}</td>
            <td>{$members[$u]->weapon_name}</td>
            <td>{$members[$u]->status}</td>
          </tr>";
          
          echo "<tr>
            <th>a squad</th>
          </tr>";
          
          ++$s;      
        }
        
        ++$p;    
      }

      ++$u;
    }
    echo "</table>";
    */ 
  ?>

  <table align="center">    
  
  <?php for($platoon_count = 0; $platoon_count <= $stats['platoon']; ++$platoon_count): ?>
  
    <?php if($this->getMembersOfPlatoon($platoon_count) > 0): ?>    
      <?php if($platoon_count):?>
        <tr>
        <!-- Platoon table marker -->
        <th class="header" colspan="5"><?php echo $platoon_count . ' Platoon'; ?></th></tr>
      <?php endif; ?>
    
    <tr>
      <!-- Table header -->
      <th class="header">Rank</th>
      <th class="header">Name</th>
      <th class="header">Role</th>
      <th class="header">Weapon</th>
      <th class="header">Status</th>
    </tr>
      <?php foreach($this->data as $member): ?>
        <?php if($member->platoon_id == $platoon_count && $member->status_id < 2): ?>
        <tr>
          <!-- Rank -->
          <td class="rudi"><img src="<?php echo "{$this->images_path}/ranks/small/{$member->rank_short}.png"; ?>" alt="<?php echo $member->rank_short; ?>" /></td>
          <!-- Name -->
          <td class="rudi"><a href="?load=rudi&amp;profile=<?php echo $member->member_id ?>"><?php echo $member->last_name . ', ' . $member->first_name; ?></a></td>
            <!-- Roles -->
            <td class="rudi">
            <?php
            decho(count($member->Roles) . ' roles attached to: ' . $member->last_name);
            for($role = 0; $role < count($member->Roles); ++$role)
            { 
              if($member->Roles[$role]->role_name)
              {
                decho($role . " = (" . $member->Roles[$role]->role_name . ")");
                echo $member->Roles[$role]->role_name;
                echo '&nbsp;';
              } 
              else
              {
                echo "Soldier";
              }
            }
            ?> 
            </td>
          <!-- Weapon -->        
          <td class="rudi"><?php echo $member->weapon_manufacturer . ' ' . $member->weapon_model; ?></td>
          <!-- Status -->
          <td class="rudi"><?php echo $member->status; ?></td>
        </tr>
        <?php endif; ?>
        
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endfor; ?>
  
  </table>
</body>
</html>
