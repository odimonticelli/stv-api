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
    case 'register':
        if(isset($vetpay['sub']) && $vetpay['sub']=='20250901') 
        {
            $now = date('Y-m-d H:i:s');
            $exp = $obj['expo_push_token'];
            
            //pega os dados
            $idu = $obj['user_id'];
            $cpf = $obj['cpf'];
            $mat = $obj['matricula'];
            $pla = $obj['platform'];
            $dev = $obj['device_info'];
            $bra = $dev['brand'];
            $mod = $dev['model'];
            $sys = $dev['os'];

            //cria objeto para atualizar os dados do usuario
            $objusu = new Stv_usuarios_online();
            $objusu->setId($idu);
            
            //objeto para atualizar
            $objdao = new Stv_usuarios_onlineDAO();
            $resusu = $objdao->update($objusu);
            if ($resusu) {
                $return = ["success" => true, "response" => "Token do usuario atualizado com sucesso"];
            }
            else {
                $return = ["success" => false, "response" => "Falha ao atualizar o token do usuario"];
            }
        }
    break;



    case 'select': 
        if(isset($obj["id_usuario"])) {
            $now = date('Y-m-d H:i:s');
            $idu = $obj["id_usuario"];
            //todos os chamados do usuário 
            $chamados = array();
            $sql = "SELECT * 
                    from stv_chamados
                    where id_usuario = '$idu' order by id desc";
            $query = $dba->query($sql);
            $qntd  = $dba->rows($query); 
            if ($qntd > 0) {
                for($a=0; $a<$qntd; $a++) {
                    $vet = $dba->fetch($query);
                    $chamados[] = $vet;
                }
                $return = array("ok" => true, "msg" => $chamados);
            } else {
                $return = array("ok" => false, "msg" => "Nenhum chamado encontrado!");
            }
        }
    break;


    case 'interacao-insert':
        if(isset($obj["id_usuario"]) && isset($obj["id_chamado"])) {
            $now = date('Y-m-d H:i:s');
            $idu = $obj["id_usuario"];
            $idc = $obj["id_chamado"];
            $tipo_usuario = 4;

            //pega os dados
            $msg = $obj['mensagem'];
            $anx = $obj['anexo'];
            
            //faz os ajustes e testes
            if (empty($msg)) { $return = array("ok" => false, "msg" => "mensagem"); break; } 

            //ip de cadastro
            $ipr  = getIp();
            $sql = "INSERT INTO stv_chamados_interacao 
                    (mensagem, tipo_usuario, id_usuario, data_registro, ip_registro, id_chamado) 
                    VALUES 
                    ('$msg', $tipo_usuario, $idu, '$now', '$ipr', $idc)"; //die($sql);
            $res = $dba->query($sql);
            $idi = $dba->lastId();

            $sql2 = "UPDATE stv_chamados SET status = 2 WHERE id = $idc";
            $res2 = $dba->query($sql2);
            
            $anexo = "";
            // Verifica se foi enviado algum arquivo
            if (!empty($anx)) {  
                $type = explode('/', mime_content_type($anx))[1];
                if (in_array($type, ['exe'])) { 
                    $return = array("ok" => false, "msg" => "Tipo de anexo invalido"); break;
                } 
                // Decodifica a string Base64 em dados binários
                $data = substr($anx, strpos($anx, ',') + 1); 
                $data = base64_decode($data); 
                // Verifica se a decodificação foi bem-sucedida
                if ($data === false) { 
                    $return = array("ok" => false, "msg" => "Falha ao decodificar anexo"); break;
                } 
                // Verificar diretorio
                $diretorio_upload = "../../files/interacao/".date("Y")."-".date("m")."-".date("d")."/";
                if(!is_dir($diretorio_upload)) { 
                    mkdir($diretorio_upload, 0775, true); 
                    chmod($diretorio_upload, 0775);
                }
                $arquivo = $idi.'.'.$type;
                // Salva a imagem decodificada no caminho especificado
                file_put_contents($diretorio_upload.$arquivo, $data);
                // Caminho do arquivo anexo
                $anexo = str_replace("../../", "", $diretorio_upload).$arquivo; 
                $sqlupd = "update stv_chamados_interacao set anexo = '$anexo' where id = '$idi' ";
                $dba->query($sqlupd);
            }

            if ($res) {
                //retorno com o chamado que acabou de inserir
                $interacao = array();
                $sql = "SELECT * 
                        from stv_chamados_interacao
                        where id_chamado = '$idc'";
                $query = $dba->query($sql);
                $qntd  = $dba->rows($query); 
                if ($qntd > 0) {
                    for($a=0; $a<$qntd; $a++) {
                        $vet = $dba->fetch($query);
                        $interacao[] = $vet;
                    }
                    $return = array("ok" => true, "msg" => $interacao);
                    //busca o responsavel da unidade para enviar email
                    $sqluni = "select uni.*
                                from stv_usuarios_online usu 
                                inner join stv_unidade uni on uni.id = usu.unidade
                                where usu.id = '$idu' ";
                    $resuni = $dba->query($sqluni);
                    $qtduni = $dba->rows($resuni);
                    if ($qtduni > 0) {
                        $vetuni = $dba->fetch($resuni);
                        $emauni = $vetuni['email1'];
                    } else {
                        $emauni = 'mariane.week@stv.com.br';
                    }
                    $destino = $emauni;
                    $assunto = '[STV] Interação do Chamado - #'.$idc;
                    $mensagem = "Foi registrada uma interação em um chamado aberto pelo usuário.<br> <h3>Chamado: $idc</h3> Acesse a área administrativa do sistema para visualizar e interagir com o usuário solicitante. ";
                    $ok = sendMail($destino, $assunto, $mensagem);
                } 
                else {
                    $return = array("ok" => false, "msg" => "Nenhuma interacao encontrada!");
                }
            }
            else {
                $return = array("ok" => false, "msg" => "Falha ao gravar a interacao!");
            }
        }
    break;


    case 'interacao-select': 
        if(isset($obj["id_usuario"]) && isset($obj["id_chamado"])) {
            $now = date('Y-m-d H:i:s');
            $idu = $obj["id_usuario"];
            $idc = $obj["id_chamado"];

            //todos os chamados do usuário 
            $interacao = array();
            $sql = "SELECT * 
                    from stv_chamados_interacao
                    where id_chamado = '$idc'";
            $query = $dba->query($sql);
            $qntd  = $dba->rows($query); 
            if ($qntd > 0) {
                for($a=0; $a<$qntd; $a++) {
                    $vet = $dba->fetch($query);
                    $interacao[] = $vet;
                }
                $return = array("ok" => true, "msg" => $interacao);
            } else {
                $return = array("ok" => false, "msg" => "Nenhuma interacao encontrada!");
            }
        }
    break;
}

header('Content-Type: application/json');
echo json_encode($return);
?>