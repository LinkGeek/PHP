<?php
var_dump(phpinfo());exit;
$a = 1;
xdebug_debug_zval('a');

$b = $a;
xdebug_debug_zval('a');

$b = 2;
xdebug_debug_zval('a');
