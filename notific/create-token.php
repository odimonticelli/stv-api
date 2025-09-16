<?php
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

include('../config/inc.autoload.php');
include('../config/inc.globals.php');

$api = new ApiRest();

$payload_register = $api->encode(array("sub"=>"20250901", "role"=>"register"), 'https://odix.com.br/stv-api-secret');
echo 'Register: <br>';
echo ($payload_register); 
echo '<br><br>';

$payload_settings = $api->encode(array("sub"=>"20250901", "role"=>"settings"), 'https://odix.com.br/stv-api-secret');
echo 'Settings: <br>';
echo ($payload_settings); 
echo '<br><br>';


?>