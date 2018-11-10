<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 4:11 PM
 */

namespace App\System\Utilities;


class ArticleImageManager extends StorageManager
{
    protected static $folder = 'articles';

    static function getFolder()
    {
        return static::$folder;
    }
}