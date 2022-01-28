<?php

use Firebase\JWT\JWT;
use App\Models\OtentikasiModel;

function getJWT($otentikasiHeader)
{
    if (is_null($otentikasiHeader)) {
        throw new Exception("Authentication failed!");
    }
    return explode(" ", $otentikasiHeader)[1];
}

function validateJWT($encodedToken)
{
    // $key = getenv('JWT_SECRET_KEY');
    // $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    // $modelOtentikasi = new OtentikasiModel();
    // $modelOtentikasi->getUsername($decodedToken->username);
}

function createJWT($username)
{
    // $waktuRequest = time();
    // $waktuToken = getenv('JWT_TIME_TO_LIVE');
    // $waktuExpired = $waktuRequest + $waktuToken;
    $payload = [
        'username' => $username,
        'iat' => 0,
        'exp' => 0
    ];
    $jwt = JWT::encode($payload, getenv('JWT_SECRET_KEY'));
    return $jwt;
}
