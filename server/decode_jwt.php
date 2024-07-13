
<?php


function redirect_js($location) {
    echo "<script>window.location.href = '$location';</script>";
    exit();
}

function getJwtPayload($jwt, $req_roles)
{
    if (!isset($jwt)) {
        redirect_js("/unauthorized");
        exit();
    }
    $jwtParts = explode(".", $jwt);
    if (count($jwtParts) < 2) {
        redirect_js("/unauthorized");
        exit();
    }
    $payload = base64_decode($jwtParts[1]);
    $payload = json_decode($payload);
    if (!isset($payload->role)) {
        redirect_js("/unauthorized");
        exit();
    }
    if (!in_array($payload->role, $req_roles)) {
        redirect_js("/unauthorized");
        exit();
    }
    if (time() > $payload->exp) {
        redirect_js("/unauthorized");
        exit();
    }
    return $payload;
}