<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008-2011  Joseph Hunkeler & Evan O'Connell
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
$debug_output = sprintf("Page generated in %.3f seconds | Memory: real(%.3fmb) peak(%.3fmb) | PHP: %s<br/>Connections: %d | Queries: %d | Fetches: %d | Frees: %d<br/>\n",
                $totaltime, ((float)memory_get_usage()/1024/1024), ((float)memory_get_peak_usage()/1024/1024), $phpversion, $db_connections, $db_queries, $db_fetches, $db_frees);
?>

<div class="footer">

<a href="admin/">Administrative Control Panel</a><br />
<?php echo $config['product']['name'] . ' ' . $config['product']['version'] . ' ' . $config['product']['release'] ?><br />
<?php echo stripslashes($config['product']['copyright']); ?><br />
<?php if($config['debug']['enabled']) echo $debug_output ?><br />

</div>

<?php
if($config['debug']['enabled']){
	logQueueFlush();
}
?>

</body>
</html>
<?php ob_flush();?>