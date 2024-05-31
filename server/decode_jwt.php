<?php

function getJwtPayload($jwt, $req_roles)
{
    if (!isset($jwt)) {
        header("Location: /");
        exit();
    }
    $jwtParts = explode(".", $jwt);
    if (count($jwtParts) < 2) {
        header("Location: /");
        exit();
    }
    $payload = base64_decode($jwtParts[1]);
    $payload = json_decode($payload);
    if (!isset($payload->role)) {
        header("Location: /");
        exit();
    }
    if (!in_array($payload->role, $req_roles)) {
        header("Location: /");
        exit();
    }
    if (time() > $payload->exp) {
        header("Location: /");
        exit();
    }
    return $payload;
}