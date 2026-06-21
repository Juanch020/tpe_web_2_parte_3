<?php

require_once __DIR__ . '/../../config.php';

/**
 * Convierte datos a Base64 URL Safe.
 */
function base64url_encode($data){
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Decodifica datos Base64 URL Safe.
 */
function base64url_decode($data){
    $padding = strlen($data) % 4;

    if ($padding) {
        $data .= str_repeat('=', 4 - $padding);
    }

    return base64_decode(strtr($data, '-_', '+/'));
}

/**
 * Genera un JWT firmado con HS256.
 */
function createJWT($payload){
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    $encodedHeader = base64url_encode(json_encode($header));

    $encodedPayload = base64url_encode(json_encode($payload));

    $signature = hash_hmac('sha256',$encodedHeader . '.' . $encodedPayload, JWT_SECRET, true);

    $encodedSignature = base64url_encode($signature);

    return
        $encodedHeader . '.' .
        $encodedPayload . '.' .
        $encodedSignature;
}

/**
 * Valida un JWT y devuelve el payload.
 */
function validateJWT($jwt){
    $parts = explode('.', $jwt);

    if (count($parts) !== 3) {
        return null;
    }

    [$header, $payload, $signature] = $parts;

    $expectedSignature = base64url_encode(hash_hmac('sha256', $header . '.' . $payload, JWT_SECRET, true));

    if (!hash_equals($expectedSignature, $signature)) {
        return null;
    }

    $decodedPayload = json_decode(base64url_decode($payload));

    if (!$decodedPayload) {
        return null;
    }

    if (!isset($decodedPayload->exp) || $decodedPayload->exp < time()) {
        return null;
    }

    return $decodedPayload;
}