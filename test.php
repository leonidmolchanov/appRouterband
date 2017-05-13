<?php

$sysres = snmpwalk("10.0.0.11", "public", ".1.3.6.1.2.1.1.3.0");
echo $sysres;
?>
