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

$api = new ApiRest('https://exp.host/--/api/v2/push/send');
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
            $daousu = new Stv_usuarios_onlineDAO();
            $daopus = new Stv_push_notificationDAO();

            //busca as push cadastradas no banco e os usuarios para envio
            //somente as que ainda não foram enviadas, onde a data de envio seja hoje
            $now = date('Y-m-d');
            $sqlpus = "select pus.*, pnu.id_usuario, usu.token_expo
                        from stv_push_notification pus 
                        inner join stv_push_notification_usuarios pnu on pnu.id_push_notification = pus.id
                        inner join stv_usuarios_online usu on usu.id = pnu.id_usuario
                        where pus.status = 1 and usu.token_ativo = 1";
            $respus = $daopus->execSql($sqlpus);
            //monta os blocos de 100 em 100 
            $jsnenv = array();
            foreach ($respus as $vetpus) {
                $idp = $vetpus['id'];
                $idu = $vetpus['id_usuario'];
                $exp = $vetpus['token_expo'];
                $cam = $vetpus['campanha'];
                $tit = $vetpus['titulo'];
                $txt = $vetpus['texto'];
                $dth = $vetpus['data_hora_agendamento'];
                $dat = datetime_date($dth);
                if ($dat == $now || $dat == '0000-00-00') {
                    //envia para a api do expo e obtem o resultado
                    $itnenv['to'] = $exp;
                    $itnenv['title'] = $tit;
                    $itnenv['body'] = "$cam - $txt";
                    $itnenv['data'] = array('type'=>'message');
                    $jsnenv[] = $itnenv;
                    $body = json_encode($jsnenv);
                    $head = array('Content-Type: application/json','Content-Length: '.strlen($body));
                    $resapi = $api->post($body, $head); 
                    $vetapi = json_decode($resapi, true);
                    
                    //verifica se o retorno deu "ok"
                    //$retorno = json_decode($vetapi['data']);
                    print_r($retorno); exit;
                    if ($vetapi['success']) {
                        $return = ["success" => true, "response" => $vetapi ];

                        //cria objeto para atualizar os dados do usuario
                        $objusu = new Stv_usuarios_online();
                        $objusu->setId($idu);
                        $objusu->setToken_expo($exp);
                        $objusu->setData_atualiza($now);
                        
                        //atualizar
                        // $resusu = $daousu->update($objusu);
                        // if ($resusu) {
                        //     $return = ["success" => true, "response" => "ok" ];
                        // }
                        // else {
                        //     $return = ["success" => false, "response" => "Falha"];
                        // }
                    }
                    else {
                        $return = ["success" => false, "response" => 'Falha de envio com o Expo'];
                    }
                }
            }
        break;
    }
}

header('Content-Type: application/json');
echo json_encode($return);
?>