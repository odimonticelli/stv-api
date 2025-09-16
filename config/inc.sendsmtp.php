<?php
//INI - envio de email API SMTP IAGENTE
function sendSmtp($destino, $assunto, $mensagem) 
{
    $smtp_host = 'api.iagentesmtp.com.br/api/v3/send/';
    $smtp_user = 'contato@odix.com.br';
    $smtp_pass = '4715afd95a17c37645e40899154c437e';

    $body = '{
                "api_user": "'.$smtp_user.'",
                "api_key" : "'.$smtp_pass.'",
                "to":
                    [{
                    "email": "'.$destino.'"
                    }]
                ,
                "from": 
                {
                    "name": "JobX",
                    "email": "jobx-anuncios@odix.com.br",
                    "reply_to": "contato@odix.com.br"
                }
                ,
                "subject": "'.$assunto.'",
                "html": "'.$mensagem.'"
            }';
    $head = array(
                'Content-Type:application/json' , 
                'Content-Length:'.strlen($body) , 
                'Accept: text/json'
            );
    
    $vetres = array();
    try {
        $api = new ApiRest($smtp_host);
        $res = $api->post($body, $head); 
        $vetres = json_decode($res); 
    } 
    catch(Exception $ex) {
        $vetres[0] = $ex->getMessage();
    }

    return $vetres;
}
//FIM - envio de email API SMTP IAGENTE