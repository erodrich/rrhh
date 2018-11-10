<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 4:04 PM
 */

namespace App\System\Utilities;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

abstract class StorageManager
{
    abstract static function getFolder();

    public static function saveFile(UploadedFile $file)
    {
        $folder = static::getFolder();
        $path = $file->store($folder);
        return $path;
    }

    public static function deleteFile(string $filename)
    {
        $method = "deleteFile";
        try {
            Storage::delete($filename);
        } catch (Exception $ex) {
            CustomLog::error("StorageManager", $method, "Error al eliminar imagen: ".$ex->getMessage());
            return null;
        }
    }

    public static function updateFile(UploadedFile $file, string $filename)
    {
        static::deleteFile($filename);
        return static::saveFile($file);
    }
}