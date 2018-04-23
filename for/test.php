<?php

$a=5;
for($i=1;$i<=$a;$i++){
	for($b=1;$b<=$a-$i;$b++){
		echo "&nbsp;";
	}
	for($c=1;$c<=($i-1)*2+1;$c++){
		echo "*";
	}
	echo "<br/>";
}

for($i=$a-1;$i>=1;$i--){
	for($b=1;$b<=$a-$i;$b++){
		echo "&nbsp;";
	}
	for($c=1;$c<=($i-1)*2+1;$c++){
		echo "*";
	}
	echo "<br/>";
}