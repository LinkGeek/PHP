<?php

# 载入composer自动加载文件
require 'vendor/autoload.php';
# 给类文件的命名空间起个别名
use PhpOffice\PhpSpreadsheet\Spreadsheet;
# 实例化 Spreadsheet 对象
$spreadsheet = new Spreadsheet();
# 获取活动工作薄
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1','ID');
$sheet->setCellValue('B1','姓名');
$sheet->setCellValue('C1','年龄');
$sheet->setCellValue('D1','身高');

$sheet->setCellValueByColumnAndRow(1, 2, 1);
$sheet->setCellValueByColumnAndRow(2, 2, '欧阳克');
$sheet->setCellValueByColumnAndRow(3, 2, '18岁');
$sheet->setCellValueByColumnAndRow(4, 2, '188cm');

// MIME 协议，文件的类型，不设置，会默认html
header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// MIME 协议的扩展
header('Content-Disposition:attachment;filename=导出.xlsx');
// 缓存控制
header('Cache-Control:max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// php://output 它是一个只写数据流, 允许你以 print 和 echo一样的方式写入到输出缓冲区。
$writer->save('php://output');