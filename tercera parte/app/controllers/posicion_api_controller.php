<?php
require_once __DIR__ . '/../models/posicion_model.php';
require_once __DIR__ . '/../models/jugador_model.php';
class PosicionApiController {

    private $model;
    private $jugadorModel;

    public function __construct() {
        $this->model = new PosicionModel();
        $this->jugadorModel = new JugadorModel();
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

    public function addPosicion($req, $res){

        if (empty($req->body->nombre)) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }

        $this->model->create($req->body->nombre);

        return $res->json(['message' => 'Posición creada'], 201);
    }

    public function updatePosicion($req, $res){

        $id = $req->params->id;

        if (!is_numeric($id)) {
            return $res->json(['error' => 'ID inválido'], 400);
        }

        $posicion = $this->model->getById($id);

        if (!$posicion) {
            return $res->json(['error' => 'Posición no encontrada'], 404);
        }

        if (empty($req->body->nombre)) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }

        $this->model->update($id, $req->body->nombre);

        return $res->json($this->model->getById($id), 200);
    }

    public function deletePosicion($req, $res){

        $id = $req->params->id;

        if (!is_numeric($id)) {
            return $res->json(['error' => 'ID inválido'], 400);
        }

        $posicion = $this->model->getById($id);

        if (!$posicion) {
            return $res->json(['error' => 'Posición no encontrada'], 404);
        }

        $jugadores = $this->jugadorModel->getByPosicion($id);

        if (!empty($jugadores)) {
            return $res->json(['error' => 'No se puede eliminar porque tiene jugadores asociados'], 400);
        }

        $this->model->delete($id);

        return $res->json(null, 204);
    }
}
?>