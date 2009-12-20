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
 
$phpversion = preg_replace('/[a-z-]/', '', phpversion());
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
$debug_output = sprintf("Page generated in %.3f seconds | Memory: real(%.3fmb) peak(%.3fmb) | PHP: %s<br/>Queries: %d | Fetches: %d<br/>\n",
                $totaltime, ((float)memory_get_usage()/1024/1024), ((float)memory_get_peak_usage()/1024/1024), $phpversion, $db_queries, $db_fetches);
?>

<div class="footer">

		<br />
		<span class="footer-text">	
			All logos and trademarks on this site are property of their respective owner. The comments are property of their posters, all the rest &copy; 2001-<?php echo date('Y'); ?> 3rd Infantry Division.</span>
		
		<br /><br />

      <a href="admin/">Administrative Control Panel</a><br />
<?php echo $config['product']['name'] . ' ' . $config['product']['version'] . ' ' . $config['product']['release'] ?><br />
<?php echo $config['product']['copyright']; ?><br />
<?php if($config['debug']) echo $debug_output ?><br />

<a href="http://www.dreamhost.com/r.cgi?145892" target="_blank"><img src="http://www.dreamhost.com/images/rewards/80x15-e.png" /></a><br /><br />

</div>

</body>
</html>
<?php ob_flush();?> 