<?php
require_once __DIR__ . '/../models/posicion_model.php';

class PosicionApiController{
    private $model;

    public function __construct(){
        $this->model = new PosicionModel();
    }

    public function getAll($request, $response){
        $posiciones = $this->model->getAll();
        $response->json($posiciones, 200);
    }

    public function getPosicion($request, $response){
        $id = $request->params->id;

        if (!is_numeric($id)) {
            return $response->json(['error' => 'ID inválido'], 400);
        }

        $posicion = $this->model->getById($id);

        if($posicion){
            return $response->json($posicion, 200);
        }else{
            $response->json(['error' =>'posicion no encontrada'], 404);
        }
    }
}
?>