<?php
// API RESPONSE CODE
define('RC_PROCESS_SUCCESS', [
    'code' => 200,
    'rc_code' => "0",
    'message' => "success"
]);

define('RC_INVALID_TOKEN', [
    'code' => 400,
    'rc_code' => "RC1",
    'message' => "Invalid Token"
]);

define('RC_EXPIRED_TOKEN', [
    'code' => 400,
    'rc_code' => "ET2",
    'message' => "Token Has Expired"
]);

define('RC_INVALID_PUBLIC_KEY', [
    'code' => 400,
    'rc_code' => "IPK3",
    'message' => "Invalid Public Key"
]);

define('RC_PARAMETER_KEY_NOT_FOUND', [
    'code' => 400,
    'rc_code' => "PKNF4",
    'message' => "Parameter Key Not Found"
]);

define('RC_NIP_NOT_FOUND', [
    'code' => 400,
    'rc_code' => "NNF5",
    'message' => "NIP Not Found"
]);

define('RC_PARAMETER_NOT_FOUND', [
    'code' => 400,
    'rc_code' => "PNF6",
    'message' => "Parameter Not Found"
]);
