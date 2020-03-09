<?php
//var_dump(123);exit;
# 载入composer自动加载文件
require 'vendor/autoload.php';
# 给类文件的命名空间起个别名
use PhpOffice\PhpSpreadsheet\Spreadsheet;
# 实例化 Spreadsheet 对象
$spreadsheet = new Spreadsheet();
# 获取活动工作薄
$sheet = $spreadsheet->getActiveSheet();

# 获取单元格
$cellA = $sheet->getCell('A1');
# 设置单元格值
$cellA->setValue('欧阳克');

# 获取单元格
$cellB = $sheet->getCellByColumnAndRow(1,2);
# 设置单元格值
$cellB->setValue('黄蓉');

# 获取设置单元格，链式操作
$sheet->getCell('A3')->setValue('郭靖');
$sheet->getCellByColumnAndRow(1,4)->setValue('杨康');

# Xlsx类 将电子表格保存到文件
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$writer = new Xlsx($spreadsheet);
$writer->save('1.xlsx');