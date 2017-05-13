<?php

// Процесс вычисления скорости
for($i=1; $i<=5; $i++){
 $down = snmpwalk($router_ip, "public", ".1.3.6.1.2.1.31.1.1.1.6.".$metod);
$obj_1 = explode(":", $down[0]);
settype($obj_1[1], "integer");
$a_1[$i]= $obj_1[1];
 $up = snmpwalk($router_ip, "public", ".1.3.6.1.2.1.31.1.1.1.10.".$metod);
$obj_2 = explode(":", $up[0]);
settype($obj_2[1], "integer");
$a_2[$i]= $obj_2[1];
usleep(1000000);
};
$b_1[1]=$a_1[2]-$a_1[1] ;
$b_1[2]=$a_1[3]-$a_1[2] ;
$b_1[3]=$a_1[4]-$a_1[3] ;
$b_1[4]=$a_1[5]-$a_1[4] ;
$b_1=$b_1[1]+$b_1[2]+$b_1[3]+$b_1[4];
$speed_1=$b_1/4000000;
$speed_1=$speed_1*8;
$speed_1=round($speed_1, 3);

$b_2[1]=$a_2[2]-$a_2[1] ;
$b_2[2]=$a_2[3]-$a_2[2] ;
$b_2[3]=$a_2[4]-$a_2[3] ;
$b_2[4]=$a_2[5]-$a_2[4] ;
$b_2=$b_2[1]+$b_2[2]+$b_2[3]+$b_2[4];
$speed_2=$b_2/4000000;
$speed_2=$speed_2*8;
$speed_2=round($speed_2, 3);
$arr=array(
'in'=>$speed_1,
'out'=>$speed_2);
$string=trim(json_encode($arr));
            echo $string;
?>