<?php
$command = escapeshellcmd('python CommissionScript.py');
$output = shell_exec($command);
echo $output;
?>
