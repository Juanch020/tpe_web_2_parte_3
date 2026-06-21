<?php

require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/../router/middleware.php';

class JWTMiddleware extends Middleware
{
    public function run($request, $response)
    {
        $authHeader = $request->authorization;

        // Si no hay token, continua
        if (empty($authHeader)) {
            return;
        }

        $parts = explode(' ', $authHeader);

        if (count($parts) !== 2 || $parts[0] !== 'Bearer') {
            return;
        }

        $jwt = $parts[1];

        $user = validateJWT($jwt);

        if (!$user) {
            return;
        }

        $request->user = $user;
    }
}
?>