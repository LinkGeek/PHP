<?php

/**
 * 获取指定文件夹所有文件路径
 * @param $dir 文件夹路径
 * @return array 文件地址（绝对路径）
 */
function get_file_path($dir)
{
    $files = [];

    if(!is_dir($dir)) {
        return $files;
    }

    $handle = opendir($dir);
    if ($handle) {
        while(false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..' && $file != '.svn') {
                $filename = $dir . "/"  . $file;
                if(is_file($filename)) {
                    $files[] = $filename;
                }else {
                    $files[$file] = get_file_path($filename);
                    //$files = array_merge($files, get_file_path($filename));
                }
            }
        }

        closedir($handle);
    }

    return $files;
}