<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting(0);

/**
 * @author 		odix.com.br
 * @version 	1.0
 * @description	recebe um input (get ou post) e retorna tratado
 * @return		string
 * @use 		<?php $valor = request('user'); ?>
 */
function request($input) 
{
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$return = filter_input(INPUT_GET, $input, FILTER_SANITIZE_SPECIAL_CHARS);
	}
	elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
		$return = filter_input(INPUT_POST, $input, FILTER_SANITIZE_SPECIAL_CHARS);
	}
	else {
		$input = htmlspecialchars($_REQUEST[$input]);
		$return = addslashes($_REQUEST[$input]);
	}
	
	return $return;
}

/**
 * @author 		odix.com.br
 * @version 	1.0
 * @description	recebe um tipo de autenticacao, manipula os dados e retorna
 * @return		array
 * @use 		<?php $valor = request_auth('basic'); ?>
 */
function request_auth($type) 
{
	switch ($type) {
		case 'basic': 
			$auth = array();
			if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
				$auth['user'] = '';
				$auth['pass'] = ''; 
			} 
			else {
				$auth['user'] = $_SERVER['PHP_AUTH_USER'];
				$auth['pass'] = $_SERVER['PHP_AUTH_PW']; 
			}
			return $auth;
			break;
	}
}

/**
 * @author 		odix.com.br
 * @version 	1.0
 * @description	recebe um objeto e mostra os dados estruturados
 * @return		array
 */
function showObject($obj) {
	echo '<pre>';
	print_r($obj);
	echo '</pre>';
	exit;
}

/**
 * log em txt
 */
function logtxt($arq, $txt) {
	$ref = fopen($arq, 'a+');
	fwrite($ref, $txt."\n");
	fclose($ref);
}


#### - Funcoes que agrupam recursos da propria linguagem
#### - Funcoes especificas de terceiros estao em arquivos especificos

/**
 * @author 		odix.com.br
 * @version 	1.0
 * @description	verifica acesso por session (usar em toda página restrita)
 * @return		string
 */
function checkSession() 
{
	$destino = './login.php';
	/*if ($_SERVER['SERVER_PORT'] == 80) {
		header('location: '.$destino);
		exit;
	}*/
	session_start();
	if (!isset($_SESSION['login'])) {
		//volta pra página de login
		session_destroy();
		$msg = base64_encode(03);
		header('location: '.$destino);
		exit;
	}
}

/**
 * recebe um valor no formato moeda BR e retorna um n?mero
 */
 function numero($val) {
	$val = str_replace('.', '', $val); //primeiro tira o ponto 1.519,80
	$val = str_replace(',', '.', $val); //troca a v?rgula por ponto 1519.8
	return $val * 1; //gambeta pra tirar o zero do final se existir
}


/**
 * recebe uma data no formato aaaa-mm-dd e retorna no formato BR
 */
function date_ptbr($val, $sep = '-') {
	$vet = explode($sep, $val);
	return $vet[2].'/'.$vet[1].'/'.$vet[0];
}


/**
 * recebe uma hora no formato hh:mm:ss e retorna no formato 00h00
 */
function time_ptbr($val, $sep = ':') {
	$vet = explode($sep, $val);
	return $vet[0].'h'.$vet[1];
}


/**
 * recebe uma data no formato dd/mm/aaaa e retorna no formato MySQL
 */
function date_mysql($val, $sep = '/') {
	$vet = explode($sep, $val);
	return $vet[2].'-'.$vet[1].'-'.$vet[0];
}


/**
 * recebe um datetime e retorna somente a data em pt-br
 */
function datetime_date_ptbr($val, $sep = '-') {
	$vet = explode(' ', $val);
	$vet = explode($sep, $vet[0]);
	return $vet[2].'/'.$vet[1].'/'.$vet[0];
}


/**
 * recebe um datetime e retorna somente a hora em pt-br
 */
function datetime_time_ptbr($val, $sep = ':') {
	$vet = explode(' ', $val);
	$vet = explode($sep, $vet[1]);
	return $vet[0].':'.$vet[1];
}


/**
 * recebe a data e a hora e converte para datetime de mysql
 */
function datetime_mysql($dat, $hor, $sep = '/') {
	$vet = explode($sep, $dat);
	$dat = $vet[2].'-'.$vet[1].'-'.$vet[0];
	return $dat.' '.$hor;
}


/**
 * recebe uma data no formato dd/mm/aaaa e retorna no formato Oracle (ddmmYY)
 */
 function date_oracle($val, $sep = '/') {
	$datora = "to_date($val, 'dd/mm/yyyy')";
	return $datora;
}

/**
 * recebe a data e a hora retorna somente a data
 */
function datetime_date($dathor, $sep=' ') {
	$vet = explode($sep, $dathor);
	$dat = $vet[0];
	return $dat;
}

/**
 * recebe a data e a hora retorna somente a hora
 */
function datetime_time($dathor, $sep=' ') {
	$vet = explode($sep, $dathor);
	$hor = $vet[1]; 
	return $hor;
}

/**
 * formata o telefone para o padrao somente nros
 */
function fone_pagseg($n)
{
    $tam = strlen(preg_replace("/[^0-9]/", "", $n));
	$n = preg_replace("/[^0-9]/", "", $n);
    
    if ($tam == 13) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
        return "+".substr($n, 0, $tam-11)." (".substr($n, $tam-11, 2).") ".substr($n, $tam-9, 5)."-".substr($n, -4);
    }
    if ($tam == 12) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
        return "+".substr($n, 0, $tam-10)." (".substr($n, $tam-10, 2).") ".substr($n, $tam-8, 4)."-".substr($n, -4);
    }
    if ($tam == 11) {
        // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
        return substr($n, 0, 2) . substr($n, 2, 5) . substr($n, 7, 11);
    }
    if ($tam == 10) {
        // COM CÓDIGO DE ÁREA NACIONAL
        return substr($n, 0, 2) . substr($n, 2, 4) . substr($n, 6, 10);
    }
    if ($tam <= 9) {
        // SEM CÓDIGO DE ÁREA - fixo 51
        return 51 . substr($n, 0, $tam-4) . substr($n, -4);
    }
}

/**
 * funcao para formatacao do valor moeda para o PagSeguro (PS)
 */
function moeda_pagseg($val){
	$val = number_format($val, 2, '', '');
	return $val;
}


/**
 * funcao para formatacao do valor numerico para moeda 
 */
function moeda($val, $cif=''){
	$val = number_format($val, 2, ',', '.');
	return $cif.$val;
}
?>