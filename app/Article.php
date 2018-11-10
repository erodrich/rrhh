<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\System\Utilities\CustomLog;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $class = "Article";
    //
    public function saveImage(UploadedFile $file){

        $method = "saveImage";

        CustomLog::debug($this->class, $method, "Saving Image: ");

        $path = $file->store('articles');

        return $path;

    }

    public function deleteImage(string $filename){
        $method = "deleteImage";
        try{
            Storage::delete($filename);
        } catch ( Exception $ex) {
            CustomLog::error($this->class, $method, "Error al eliminar imagen");
            return null;
        }

    }

    public function updateImage(UploadedFile $file, string $filename){
        $this->deleteImage($filename);
        return $this->saveImage($file);
    }
}
