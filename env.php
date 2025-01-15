<?php
$g_Enviroment = [
    "KC_CLIENT_ID" => "task-manager-web",
    "COMMON_TITLE" => "task-manager-web",

    "KC_SECRET" => "D2Sq7wizqi8X0YYpQg8qIFqHgcuAZ9pb",
    "KC_REDIRECT_URI" => "http://localhost/index.php?r=site/auth-callback",
    // "KC_ISSUER_URL" => "http://sso.dev.buketov.edu:8080/realms/buketov-edu/",
    // "KC_ISSUER_URL" => "http://localhost:8180/realms/task-manager/",
    // "KC_APIBASE_URL" => "http://192.168.3.42:8080/realms/buketov-edu/protocol/openid-connect",
    // "KC_AUTH_ENDPOINT" => "http://localhost:8080/realms/buketov-edu/protocol/openid-connect/auth",
    // "KC_TOKEN_ENDPOINT" => "http://sso.dev.buketov.edu:8080/realms/buketov-edu/protocol/openid-connect/token",
    "KC_LOGOUT_REDIRECT_URI" => "http://localhost/",
    "PROXY" => "0", # TODO(annad): Check is on production!,
    "PROXY_USR" => "zal",
    "PROXY_PWD" => "zal",
    "PROXY_HOST" => "192.168.1.101",
    "PROXY_PORT" => "3128",
    "COMMON_TITLE" => "task-manager.v2",
];
function g_env(string $key, bool $exception = true)
{
    $g_Enviroment = $GLOBALS['g_Enviroment'];

    if ($exception && !isset($g_Enviroment[$key])) {
        throw new \Exception("Undefined enviroment variable '$key'!");
        return isset($g_Enviroment[$key]) ? $g_Enviroment[$key] : null;
    }
}