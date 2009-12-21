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
 
if(!defined("MODULE_FILE"))
{
  echo "Access denied...";
  return;
}

OpenTable();
echo "<div class=\"contentHeader\">How to Connect</div><div class=\"content\"><p>IP: 64.214.185.50:9004</p><p>Password: Garand</p></div>";
CloseTable();


OpenTable();
echo "<div class=\"contentHeader\">Teamspeak Server</div>";
/*echo "<div style=\"vertical-align:middle; margin-left:40%; margin-right:auto;\">\n";*/
//echo "<div style=\"width: 30%; margin-left: auto; margin-right: auto;\">\n";
echo "<div style=\"display:block; margin-left:40%;margin-right:auto;\">";
 
$ts = implode('',file("http://www.tsviewer.com/ts_viewer_pur.php?ID=902437&bg=&type=8f8f8f&type_size=11&type_family=5&info=1&channels=1&users=1&type_s_color=000000&type_s_weight=bold&type_s_style=normal&type_s_variant=normal&type_s_decoration=none&type_s_color_h=525284&type_s_weight_h=bold&type_s_style_h=normal&type_s_variant_h=normal&type_s_decoration_h=underline&type_i_color=000000&type_i_weight=normal&type_i_style=normal&type_i_variant=normal&type_i_decoration=none&type_i_color_h=525284&type_i_weight_h=normal&type_i_style_h=normal&type_i_variant_h=normal&type_i_decoration_h=underline&type_c_color=000000&type_c_weight=normal&type_c_style=normal&type_c_variant=normal&type_c_decoration=none&type_c_color_h=525284&type_c_weight_h=normal&type_c_style_h=normal&type_c_variant_h=normal&type_c_decoration_h=underline&type_u_color=000000&type_u_weight=normal&type_u_style=normal&type_u_variant=normal&type_u_decoration=none&type_u_color_h=525284&type_u_weight_h=normal&type_u_style_h=normal&type_u_variant_h=normal&type_u_decoration_h=none")); 
echo $ts;

echo "</div>\n";
CloseTable();


?>
