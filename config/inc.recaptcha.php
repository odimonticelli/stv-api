<?php
/**
 * Google reCAPTCHA (v2)
 * Recebe o código enviado do form (g-recaptcha-response)
 * Usa a chave secret gerada no Google Admin (console ou developer)
 * Retorna o resultado 
 * @param   $code - código do form
 * @param   $bypass - se true retorna sempre sucesso
 */
function reCaptcha($code, $bypass=false)
{
    $content = http_build_query(array(
        'secret' => '6LcwprErAAAAANQ68wrWlzr_9ZEyaJUxJvtqr1AV',
        'response' => $code
    ));
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'content' => $content
        )
    ));
    $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', null, $context);
    $result = json_decode($result);
    if ($bypass) {
        $result->success = true; 
    }
    
    return $result;
}
?>