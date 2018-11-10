<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 4:46 PM
 */

namespace App\System\Repositories;


use App\Document;
use App\System\Utilities\CustomLog;
use App\System\Utilities\DocumentFileManager;
use Exception;
use Illuminate\Http\UploadedFile;

class DocumentRepositoryImpl implements DocumentRepositoryInterface
{
    protected $class = "DocumentRepositoryImpl";
    protected $document;

    /**
     * DocumentRepositoryImpl constructor.
     */
    public function __construct()
    {
        $this->document = new Document();
    }

    public function retrieveAll()
    {
        $documents = $this->document->all();
        return $documents;
    }

    public function retrieveById(int $id)
    {
        $document = $this->document->find($id);
        return $document;
    }

    public function save(array $data)
    {
        $method = "save";

        try {
            $this->document->filename = $data['filename'];
            $path = DocumentFileManager::saveFile(UploadedFile::createFromBase($data['filepath']));
            $this->document->filepath = $path;
            $this->document->save();
            return $this->document;
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getMessage());
            return null;
        }    }

    public function update(array $data, int $id)
    {
        $method = "update";
        try {
            $document = $this->document->find($id);
            if ($document) {
                $document->filename = $data['filename'];
                $path = DocumentFileManager::updateFile(UploadedFile::createFromBase($data['filepath']), $document->filepath);
                $document->filepath = $path;
                $document->save();
                return $document;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getTrace());
            return null;
        }
    }

    public function delete(int $id)
    {
        $document = $this->document->find($id);
        if ($document) {
            $document->delete();
            return true;
        }
        return false;
    }
}