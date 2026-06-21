<?php

require_once __DIR__ . '/../../config.php';
class DatabaseModel {

    protected $db;

    public function __construct() {

        try {

            // Conexión inicial sin seleccionar base de datos
            $this->db = new PDO(
                "mysql:host=" . MYSQL_HOST . ";charset=utf8mb4",
                MYSQL_USER,
                MYSQL_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );

            $this->deploy();

            // Conexión definitiva a la base de datos
            $this->db = new PDO(
                "mysql:host=" . MYSQL_HOST .
                ";dbname=" . MYSQL_DB .
                ";charset=utf8mb4",
                MYSQL_USER,
                MYSQL_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );

        } catch (PDOException $e) {
            throw $e;
        }
    }

    private function deploy() {

        // Crea la base de datos si no existe
        $this->db->exec(
            "CREATE DATABASE IF NOT EXISTS `" . MYSQL_DB . "`
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci"
        );

        $this->db->exec("USE `" . MYSQL_DB . "`");

        // Verifica si existe alguna tabla principal
        $query = $this->db->query("SHOW TABLES LIKE 'usuario'");

        $tableExists = $query->fetchColumn();

        // Si no existe, importa el SQL
        if (!$tableExists) {

            $sql = file_get_contents(__DIR__ . '/../../database/equipo_de_futbol.sql');

            if ($sql === false) {
                throw new Exception(
                    'No se pudo leer equipo_de_futbol.sql'
                );
            }

            $this->db->exec($sql);
        }
    }
}