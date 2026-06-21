<?php
require_once __DIR__ . '/../models/equipo_model.php';
require_once __DIR__ . '/../models/jugador_model.php';

class EquipoApiController{
    private $model;
    private $jugadorModel;

    public function __construct(){
        $this->model = new EquipoModel();
        $this->jugadorModel = new JugadorModel();
    }

    public function getAll($request, $response){
        $equipos = $this->model->getAll();
        $response->json($equipos, 200);
    }

    public function getEquipo($request, $response){
        $id = $request->params->id;

        if (!is_numeric($id)) {
            return $response->json(['error' => 'ID inválido'], 400);
        }

        $equipo = $this->model->getById($id);

        if($equipo){
            return $response->json($equipo, 200);
        }else{
            $response->json(['error' =>'equipo no encontrado'], 404);
        }
    }

    public function addEquipo($req, $res){

        if (!isset($req->body->nombre) || !isset($req->body->descripcion) || !isset($req->body->fecha_creacion)) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }

        $data = [
            'nombre' => $req->body->nombre,
            'descripcion' => $req->body->descripcion,
            'fecha_creacion' => $req->body->fecha_creacion,
            'foto' => $req->body->foto ?? null
        ];

        $id = $this->model->create($data);

        $equipo = $this->model->getById($id);

        return $res->json($equipo, 201);
    }

    public function updateEquipo($req, $res){

        $id = $req->params->id;

        if (!is_numeric($id)) {
            return $res->json(['error' => 'ID inválido'], 400);
        }

        $equipo = $this->model->getById($id);

        if (!$equipo) {
            return $res->json(['error' => 'Equipo no encontrado'], 404);
        }

        if (!isset($req->body->nombre) || !isset($req->body->descripcion) || !isset($req->body->fecha_creacion)) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }

        $data = [
            'nombre' => $req->body->nombre,
            'descripcion' => $req->body->descripcion,
            'fecha_creacion' => $req->body->fecha_creacion,
            'foto' => $req->body->foto ?? null
        ];

        $this->model->update($id, $data);

        $equipoActualizado = $this->model->getById($id);

        return $res->json($equipoActualizado, 200);
    }

    public function deleteEquipo($req, $res){

        $id = $req->params->id;

        if (!is_numeric($id)) {
            return $res->json(['error' => 'ID inválido'], 400);
        }

        $equipo = $this->model->getById($id);

        if (!$equipo) {
            return $res->json(['error' => 'Equipo no encontrado'], 404);
        }

        $jugadores = $this->jugadorModel->getByEquipo($id);

        if (!empty($jugadores)) {
            return $res->json(['error' => 'No se puede eliminar porque tiene jugadores asociados'], 400);
        }

        $this->model->delete($id);

        return $res->json(['message' => 'equipo eliminado'], 204);
    }
}
?>