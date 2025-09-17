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

$json  	= file_get_contents('php://input');
$obj   	= json_decode($json, true); // var_dump($obj);
$return = ["success" => false, "response" => "Parâmetros inválidos."];

$api = new ApiRest();
$headers = $api->getHeaders();
$token = $api->getToken($headers);
$vetpay = $api->payload($token);
switch($vetpay['role'])
{
    case 'settings':
        if(isset($vetpay['sub']) && $vetpay['sub']=='20250901') 
        {
            $now = date('Y-m-d H:i:s');
            showObject($obj);

            //pega os dados
            $idu = $obj['user_id'];
            $avi = $obj['avisos_enabled'];
            $cha = $obj['chamados_enabled'];
            $doc = $obj['docs_enabled'];
            $nov = $dev['novidades_enabled'];
            $pro = $dev['promos_enabled'];

            //monta os valores separados por vírgula para gravar na tabela
            $tip = '';
            if ($avi) $tip .= $avi . ',';
            if ($cha) $tip .= $cha . ',';
            if ($doc) $tip .= $doc . ',';
            if ($nov) $tip .= $nov . ',';
            if ($pro) $tip .= $pro . ',';
            $tip = substr($tip, 0, strlen($tip)-1);

            //cria objeto para atualizar os dados do usuario
            $objusu = new Stv_usuarios_online();
            $objusu->setId($idu);
            $objusu->setPush_tipo($tip);
            $objusu->setData_atualiza($now);
            
            //objeto para atualizar
            $objdao = new Stv_usuarios_onlineDAO();
            $resusu = $objdao->update($objusu);
            if ($resusu) {
                $return = ["success" => true, "response" => "Configs de notificação atualizadas"];
            }
            else {
                $return = ["success" => false, "response" => "Falha ao atualizar as configs de notificação"];
            }
        }
    break;
}

header('Content-Type: application/json');
echo json_encode($return);
?>