<?php

require_once __DIR__ . '/../models/user_model.php';
require_once __DIR__ . '/../../libs/jwt/jwt.php';

class AuthApiController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function login($req, $res) {

        if (!$req->body) {
            return $res->json(['error' => 'JSON inválido'], 400);
        }

        if (empty($req->body->username) || empty($req->body->password)
        ) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }

        $username = trim($req->body->username);
        $password = $req->body->password;

        $user = $this->model->getByUsername($username);

        if (!$user || !password_verify($password, $user->password)) {
            return $res->json(['error' => 'Credenciales inválidas'], 401);
        }

        $payload = ['id' => $user->id,'username' => $user->username,'exp' => time() + 3600 ];

        $token = createJWT($payload);

        return $res->json(['message' => 'Login exitoso', 'token' => $token], 200);
    }
}
?>