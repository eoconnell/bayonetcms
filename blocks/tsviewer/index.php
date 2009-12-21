<?php

/** 
* The overlaying css div.content class is messing up the padding of the text.
* Apparently I cannot override this...
*/
echo "<div style=\"padding:0px; margin: 5px;\">\n";
$ts = implode('',file("http://www.tsviewer.com/ts_viewer_pur.php?ID=902437&bg=&type=8f8f8f&type_size=11&type_family=5&info=1&channels=1&users=1&type_s_color=000000&type_s_weight=bold&type_s_style=normal&type_s_variant=normal&type_s_decoration=none&type_s_color_h=525284&type_s_weight_h=bold&type_s_style_h=normal&type_s_variant_h=normal&type_s_decoration_h=underline&type_i_color=000000&type_i_weight=normal&type_i_style=normal&type_i_variant=normal&type_i_decoration=none&type_i_color_h=525284&type_i_weight_h=normal&type_i_style_h=normal&type_i_variant_h=normal&type_i_decoration_h=underline&type_c_color=000000&type_c_weight=normal&type_c_style=normal&type_c_variant=normal&type_c_decoration=none&type_c_color_h=525284&type_c_weight_h=normal&type_c_style_h=normal&type_c_variant_h=normal&type_c_decoration_h=underline&type_u_color=000000&type_u_weight=normal&type_u_style=normal&type_u_variant=normal&type_u_decoration=none&type_u_color_h=525284&type_u_weight_h=normal&type_u_style_h=normal&type_u_variant_h=normal&type_u_decoration_h=none"));
echo $ts;
echo "</div>\n";

?>
