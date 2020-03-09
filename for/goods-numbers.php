<?php

$str = "";
$end = 15;
$start = 1;
$g_rows = 3;
$g_lines = 2;
$prefix = "YX-HL-";
$width = strlen($end);
$groups = ceil($end / ($g_lines * $g_rows));
$space = str_pad(" ", strlen($prefix) + $width);

for ($g = 0; $g < $groups; $g++) {
    // 组首部
    $g_start = $start + $g * $g_lines * $g_rows;
    for ($i = 0; $i < $g_lines; $i++) {
        // 行首部
        $line_start = $g_start + $i;
        for ($j = 0; $j < $g_rows; $j++) {
            // 列元素
            $code = $line_start + $j * $g_lines;
            // 拼接元素
            if ($code > $end) {
                if ($j == 0)
                    break 3;
                $str .= $space;
            } else {
                // 编码补0
                $str .= sprintf("%s%s", $prefix, str_pad($code, $width, "0", STR_PAD_LEFT));
            }
            // 元素留白
            if ($j != ($g_rows - 1)) {
                $str .= $space;
            }
        }
        $str .= "\n";
    }
    $str .= "\n";
}
echo $str;