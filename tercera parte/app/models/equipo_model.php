<?php
require_once __DIR__ . '/../models/database_model.php';

class EquipoModel extends DatabaseModel{
    public function getById($id){
        $query = $this->db->prepare("SELECT * FROM equipo WHERE id = ?");
        $query->execute([$id]);

        return $query->fetch();
    }

    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM equipo ORDER BY id DESC");
        $query->execute();
        
        return $query->fetchAll();
    }

    public function create($data){
        $query = $this->db->prepare("INSERT INTO equipo (nombre, descripcion, fecha_creacion, foto) VALUES (?, ?, ?, ?)");
        $query->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_creacion'],
            $data['foto']
        ]);
        return $this->db->lastInsertId();    
    }

    public function delete($id){
        $query = $this->db->prepare("DELETE FROM equipo WHERE id = ?");
        
        return $query->execute([$id]);
    }

    public function update($id, $data){
        $query = $this->db->prepare("UPDATE equipo SET nombre = ?, descripcion = ?, fecha_creacion = ?, foto = ? WHERE id = ?");
        return $query->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_creacion'],
            $data['foto'],
            $id
        ]);
    }
}
?>