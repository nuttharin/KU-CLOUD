<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/30/2018
 * Time: 9:12 PM
 */

namespace App\LogViewer;

use Log;
use SplFileInfo;


class SizeLog
{
    /**
     * @param $bytes
     * @param int $precision
     * @return string
     */
    public static  function formatSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);

        return round($bytes / pow(1024, $pow), $precision).' '.$units[$pow];
    }

    /**
     * @param $folder
     * @return string
     */
    public static function getSizeFolder($folder){
        $size = 0;
        $path = storage_path('logs').'/'.$folder;
        foreach (glob(rtrim($path, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : folderSize($each);
        }
        return SizeLog::formatSize($size);
    }

    public  static  function getSizeFile($path){
        $info_file = new SplFileInfo($path);
        return SizeLog::formatSize($info_file->getSize());
    }
}