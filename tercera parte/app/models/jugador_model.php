<?php
require_once __DIR__ . '/../models/database_model.php';
class JugadorModel extends DatabaseModel{
    
    public function getById($id){
        $query = $this->db->prepare('SELECT * FROM jugador WHERE id = ?');
        
        $query->execute([$id]);
        $jugador = $query->fetch();
        
        return $jugador;
    }

    public function getAll($sort = null, $order = 'asc', $limit = null, $offset = 0, $filterField = null, $filterValue = null){
        $sql = 'SELECT * FROM jugador';
        $params = [];

        if($filterField !== null && $filterValue !== null){
            $allowedFilters = ['nombre', 'precio', 'id_equipo', 'id_posicion'];
            if (in_array($filterField, $allowedFilters)) {
                $sql .= " WHERE $filterField = ?";
                $params[] = $filterValue;
            }
        }

        if ($sort) {
            $allowedSorts = ['id', 'nombre', 'precio', 'id_equipo', 'id_posicion'];
            if (in_array($sort, $allowedSorts)) {
                $sql .= " ORDER BY $sort " . ($order === 'DESC' ? 'DESC' : 'ASC'); 
            }
        }

        if ($limit !== null) {
            $limit = (int) $limit;
            $offset = (int) $offset;

            if ($limit > 0) {
                $sql .= " LIMIT $limit OFFSET $offset";
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);

        return $query->fetchAll();
    }

    public function getByEquipo($id_equipo){
        $query = $this->db->prepare("SELECT * FROM jugador WHERE id_equipo = ?");

        $query->execute([$id_equipo]);

        return $query->fetchAll();
    }

    public function getByPosicion($id_posicion){
        $query = $this->db->prepare("SELECT * FROM jugador WHERE id_posicion = ?");

        $query->execute([$id_posicion]);

        return $query->fetchAll();
    }

    public function count ($filterField = null, $filterValue = null){
        $sql = 'SELECT COUNT(*) as total FROM jugador';
        $params = [];

        if($filterField !== null && $filterValue !== null){
            $allowedFilters = ['nombre', 'precio', 'id_equipo', 'id_posicion'];
            if (in_array($filterField, $allowedFilters)) {
                $sql .= " WHERE $filterField = ?";
                $params[] = $filterValue;
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
        $result = $query->fetch();

        return $result->total;
    }

    public function create($data){
        $query = $this->db->prepare("INSERT INTO jugador(nombre, precio, id_equipo, id_posicion, foto) VALUES (?, ?, ?, ?, ?)");
        $query->execute([
            $data['nombre'],
            $data['precio'],
            $data['id_equipo'],
            $data['id_posicion'],
            $data['foto'] ?? null
        ]); 
        return $this->db->lastInsertId();
    }

    public function delete($id){
        $query = $this->db->prepare("DELETE FROM jugador WHERE id = ?");
        return $query->execute([$id]);
    }

    public function update($id, $data){
        $query = $this->db->prepare("UPDATE jugador SET nombre = ?, precio = ?, id_equipo = ?, id_posicion = ?, foto = ? WHERE id = ?");
        
        return $query->execute([
            $data['nombre'],
            $data['precio'],
            $data['id_equipo'],
            $data['id_posicion'],
            $data['foto'] ?? null,
            $id
        ]);    
    }
}
?>