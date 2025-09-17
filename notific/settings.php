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
elseif (isset($vetpay['role']) && $vetpay['role']=='settings' && isset($vetpay['sub']) && $vetpay['sub']=='20250901') 
    $authorization = true; 
// -- ----------------------------------------------------
if ($authorization) 
{
    switch($method)
    {
        case 'GET': 
            $obj = $api->getGet(); 
            $idu = $obj['user_id'];

            //busca no banco
            $daousu = new Stv_usuarios_onlineDAO();
            $sqlusu = "id = '$idu'";
            $resusu = $daousu->select();
            $return = array();
            if (isset($resusu[0]) && isset($resusu[0]['push_tipo']) ) {
                $tip = $resusu[0]['push_tipo'];
                $vet = explode(',' , $tip);
                $return[0] = $tip;
            }

            //monta o json de retorno
            $return = ["success" => true, "response" => $return];
        break;



        case 'PUT':
            $obj = json_decode($api->getPut(), true); 

            //pega os dados
            $now = date('Y-m-d H:i:s');
            $idu = $obj['user_id'];
            $avi = $obj['avisos_enabled'];
            $cha = $obj['chamados_enabled'];
            $doc = $obj['docs_enabled'];
            $nov = $obj['novidades_enabled'];
            $pro = $obj['promos_enabled'];

            //monta os valores separados por vírgula para gravar na tabela
            $tip = '';
            if ($avi) $tip .= 'avisos,';
            if ($cha) $tip .= 'chamados,';
            if ($doc) $tip .= 'docs,';
            if ($nov) $tip .= 'novidades,';
            if ($pro) $tip .= 'promos,';
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
        break;
    }
}

header('Content-Type: application/json');
echo json_encode($return);
?>