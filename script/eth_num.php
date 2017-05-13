<?php
// Процесс выявления номеров интерфейсов
$eth_names=snmpwalk("10.11.12.101", "public", ".1.3.6.1.2.1.31.1.1.1.1");
$eth_name[count]=count($eth_names);
for($y=0; $y<=count($eth_names)-1; $y++)
{
$obj=explode(":", $eth_names[$y]);
$obj=explode('"', $obj[1]);
$eth_name[$y+1]= $obj[1];
$eth_num[$y+1]= $y+1;
}

$string=trim(json_encode($eth_name));
            echo $string;
?>