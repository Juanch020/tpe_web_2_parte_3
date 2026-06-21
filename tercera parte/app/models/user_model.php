<?php 
require_once __DIR__ . '/../models/database_model.php';
class UserModel extends DatabaseModel{
    
    public function getByUsername($username){
        $query = $this->db->prepare("SELECT * FROM usuario WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch();
    }

    public function getById($id){
        $query = $this->db->prepare("SELECT * FROM usuario WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }
}
?>