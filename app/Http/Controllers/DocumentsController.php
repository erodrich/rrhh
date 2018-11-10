<?php

namespace App\Http\Controllers;

use App\System\Repositories\DocumentRepositoryInterface;
use App\System\Utilities\CustomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentsController extends Controller
{
    protected $class = "DocumentsController";
    protected $documentDao;

    /**
     * DocumentsController constructor.
     */
    public function __construct(DocumentRepositoryInterface $documentDao)
    {
        $this->documentDao = $documentDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = $this->documentDao->retrieveAll();
        return $documents;
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
            'filename' => 'required',
            'filepath' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(["message" => "Error en la validacion de campos"], 400);
        }
        $newDocument = $this->documentDao->save($request->all());
        if($newDocument){
            return $newDocument;
        }
        return response()->json(["message" => "Error en la creacion del documento"], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = $this->documentDao->retrieveById($id);
        return $document;
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
            'filename' => 'required',
            'filepath' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Error en la validacion de campos"], 400);
        }
        $updateDocument = $this->documentDao->update($request->all(), $id);
        if($updateDocument){
            return $updateDocument;
        }
        return response()->json(["message" => "Error en la actualizacion del documento"], 400);
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

        if($this->documentDao->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el documento: ".$id);
            return response()->json(["message" => "Eliminado"], 400);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el documento: ".$id);
            return response()->json(["message" => "No existe el documento"], 400);
        }
    }
}
