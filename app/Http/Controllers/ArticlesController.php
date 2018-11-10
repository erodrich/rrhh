<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System\Repositories\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    protected $articleDao;
    protected $class = "ArticlesController";

    public function __construct(ArticleRepositoryInterface $articleDao)
    {
        $this->articleDao = $articleDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articleDao->retrieveAll();
        return $articles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(["message" => "Error en la validacion de campos"], 400);
        }
        $newArticle = $this->articleDao->save($request->all());
        if($newArticle){
            return $newArticle;
        }
        return response()->json(["message" => "Error en la creacion de la noticia"], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->articleDao->retrieveById($id);
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Error en la validacion de campos"], 400);
        }
        $updatedArticle = $this->articleDao->update($request->all(), $id);
        if($updatedArticle){
            return $updatedArticle;
        }
        return response()->json(["message" => "Error en la actualizacion de la noticia"], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $metodo = "destroy";

        if($this->articleDao->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el beacon: ".$id);
            return response()->json(["message" => "Eliminado"], 400);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el beacon: ".$id);
            return response()->json(["message" => "No existe la noticia"], 400);
        }
    }
}
