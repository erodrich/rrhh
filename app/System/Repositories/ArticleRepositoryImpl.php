<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 9:22 AM
 */

namespace App\System\Repositories;

use App\Article;
use App\System\Utilities\ArticleImageManager;
use App\System\Utilities\CustomLog;
use Exception;
use Illuminate\Http\UploadedFile;


class ArticleRepositoryImpl implements ArticleRepositoryInterface
{
    protected $class = "ArticleRepositoryImpl";
    protected $article;

    public function __construct()
    {
        $this->article = new Article();
    }

    public function retrieveAll()
    {
        $method = "retrieveAll";
        try {
            $articles = $this->article->all();
            return $articles;

        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getTrace());
            return null;
        }
    }

    public function retrieveById(int $id)
    {
        $method = "retrieveById";
        try {
            $article = $this->article->findOrFail($id);
            return $article;

        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getTrace());
            return null;
        }
    }

    public function save(array $data)
    {
        $method = "save";

        try {
            $this->article->title = $data['title'];
            $this->article->body = $data['body'];
            $path = ArticleImageManager::saveFile(UploadedFile::createFromBase($data['image']));
            $this->article->image = $path;
            $this->article->save();
            return $this->article;
        } catch (Exception $ex){
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getTrace());
            return null;
        }

    }

    public function update(array $data, int $id)
    {
        $article = $this->article->find($id);
        if ($article) {
            $article->title = $data['title'];
            $article->body = $data['body'];
            if(array_key_exists('image', $data)){
                $path = ArticleImageManager::updateFile(UploadedFile::createFromBase($data['image']), $article->image);

                $article->image = $path;
            }
            $article->save();
            return $article;
        } else {
            return null;
        }

    }

    public function delete(int $id)
    {
        $article = $this->article->find($id);
        if ($article) {
            $article->delete();
            return true;
        }
        return false;

    }
}