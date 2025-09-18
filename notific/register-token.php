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

$return = ["success" => false, "response" => "Parâmetros inválidos."];

$api = new ApiRest();
$headers = $api->getHeaders();
$token = $api->getToken($headers);
$vetpay = $api->payload($token);
$method = $api->getMethod();

// -- ----------------------------------------------------
$authorization = false;
if ($method == 'GET') 
    $authorization = true;
elseif (isset($vetpay['role']) && $vetpay['role']=='register' && isset($vetpay['sub']) && $vetpay['sub']=='20250901') 
    $authorization = true; 
// -- ----------------------------------------------------
if ($authorization) 
{
    switch($method)
    {
        case 'POST': 
            $obj = $api->getPost(); 

            //pega os dados
            $now = date('Y-m-d H:i:s');
            $exp = $obj['expo_push_token'];
            $idu = $obj['user_id'];
            $cpf = $obj['cpf'];
            $pla = $obj['platform'];
            $dev = $obj['device_info'];
                $bra = $dev['brand'];
                $mod = $dev['model'];
                $sys = $dev['os'];

            //cria objeto para atualizar os dados do usuario
            $objusu = new Stv_usuarios_online();
            $objusu->setId($idu);
            $objusu->setToken_expo($exp);
            $objusu->setDevice_plat($pla);
            $objusu->setDevice_brand($bra);
            $objusu->setDevice_model($mod);
            $objusu->setDevice_os($sys);
            $objusu->setData_atualiza($now);
            
            //objeto para atualizar
            $objdao = new Stv_usuarios_onlineDAO();
            $resusu = $objdao->update($objusu);
            if ($resusu) {
                $return = ["success" => true, "response" => "Token e infos do usuario atualizado com sucesso"];
            }
            else {
                $return = ["success" => false, "response" => "Falha ao atualizar o token do usuario"];
            }
        break;


        case 'GET':
        case 'PUT':
        case 'DELETE':
            $return = ["success" => false, "response" => "Método de envio não suportado - apenas POST"];
        break;
    }
}
else 
{
    $return = ["success" => false, "response" => "Falha de autorizacao - JWT"];
}

header('Content-Type: application/json');
echo json_encode($return);
?>