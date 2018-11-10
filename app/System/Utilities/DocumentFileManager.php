<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 4:53 PM
 */

namespace App\System\Utilities;


class DocumentFileManager extends StorageManager
{
    static protected $folder = "documents";

    static function getFolder()
    {
        return static::$folder;
    }
}