<?php
include_once(__DIR__.'/phpmailer/PHPMailerAutoload.php');
function sendMail($destino, $assunto, $mensagem) 
{
    /* Envia email de notificação */
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.jobx.com.br';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'anuncios@jobx.com.br';               // SMTP username
    $mail->Password = 'J0bx@2o25';                        // SMTP password
    $mail->SMTPSecure = false;                            // Define se é utilizado SSL/TLS - Mantenha o valor "false"
    $mail->SMTPAutoTLS = false;                           // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->setFrom('noreply@jobx.com.br', 'JobX');
    $mail->addAddress($destino);                          // Name is optional
    // $mail->addReplyTo('contato@jobx.com.br');
    $mail->isHTML(true);                                   // Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $assunto;
    $mail->Body    = $mensagem; 
    $send = $mail->send();
    
    if ($send) {
        return true;
    } else {
        return false;
    }
}

?>