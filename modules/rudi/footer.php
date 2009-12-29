<?php
$real = sprintf("%.2fkb", memory_get_usage() / 1024);
$peak = sprintf("%.2fkb", memory_get_peak_usage() / 1024);
?>

<center><?php echo "Connections: $db_connections | Queries: $db_queries | Fetches: $db_fetches | Released: $db_frees | Memory: (real): $real (peak): $peak"?></center>
</body>
</html>