<?php

namespace App\Http\Controllers;

use App\System\Repositories\OccasionRepositoryInterface;
use App\System\Utilities\CustomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OccasionsController extends Controller
{
    protected $class = "OccasionsController";
    protected $occasionDao;

    /**
     * OccasionsController constructor.
     */
    public function __construct(OccasionRepositoryInterface $occasionDao)
    {
        $this->occasionDao = $occasionDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $occasions = $this->occasionDao->retrieveAll();
        return $occasions;
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
            'day' => 'required',
            'hour' => 'required',
            'place' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(["message" => "Error en la validacion de campos"], 400);
        }
        $data = $request->all();
        $occasion = $this->occasionDao->save($data);
        if($occasion){
            return $occasion;
        }
        return response()->json(["message" => "Error en la creacion del evento"], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $occasion = $this->occasionDao->retrieveById($id);
        return $occasion;
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
            'day' => 'required',
            'hour' => 'required',
            'place' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(["message" => "Error en la validacion de campos"], 400);
        }
        $data = $request->all();
        $updateOccasion = $this->occasionDao->update($data, $id);
        if($updateOccasion){
            return $updateOccasion;
        }
        return response()->json(["message" => "Error en la creacion del evento"], 400);
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

        if($this->occasionDao->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el evento: ".$id);
            return response()->json(["message" => "Eliminado"], 400);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el evento: ".$id);
            return response()->json(["message" => "No existe el evento"], 400);
        }
    }
}
