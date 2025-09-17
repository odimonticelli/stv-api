<?php
/**
 * Comentários sobre a classe e etc, etc.
 * @author  ODIX.com.br
 * @version 1.0
 */

class ApiRest
{
    //definição das variáveis e constantes (propriedades)
    private $conn;
    private $body;
    private $head;
    private $curl;

    private $method;
	private $entity;
	private $params;

    private $headers;

	private $_GET = array(); 
    private $_POST = array(); 
    private $_PUT = array();
    private $_DELETE = array(); 

    /**
     * metodo clone do tipo privado previne a clonagem dessa instância da classe
     */
    public function __clone()
    {
    }
	
    /**
     * metodo unserialize do tipo privado para prevenir a desserialização da instância dessa classe.
     */
    public function __wakeup()
    {
    }

    /**
     * fecha conexao quando classe deixa de ser utilizada
     */
    public function __destruct()
    {
    }

	/**
	 * metodo de retorno da instância caso ja exista. Caso nao exista cria uma nova.
	 */
	public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }	

    /**
     * metodos GET para os atributos da classe
     */
    public function getConn()
    {
        return $this->conn;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHead()
    {
        return $this->head;
    }

    public function getCurl()
    {
        return $this->curl;
    }

    public function getMethod() 
    {
		return $this->method;
	}

	public function getEntity() 
    {
		return $this->entity;
	}

	public function getParams() 
    {
		return $this->params;
	}

	public function getGet() 
    {
		return $_GET;
	}

	public function getPost() 
    {
		return $_POST;
	}

	public function getPut() 
    {
		return $this->_PUT;
	}

	public function getDelete() 
    {
		return $this->_DELETE;
	}
	

    /**
     * metodo que inicializa variaveis (propriedades)
     */
    public function __construct($conn='')
    {
        $this->conn = $conn;
        $this->curl = curl_init($this->conn);

        //Comunicacao via https
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //get
		//direto pelo $_GET
		if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'GET')) {
			//parse_str(file_get_contents('php://input'), $_GET);
            $this->_GET = file_get_contents('php://input');
			$this->method = 'GET';
		}

		//post
		//direto pelo $_POST
		if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'POST')) {
			//parse_str(file_get_contents('php://input'), $_POST);
			$this->_POST = file_get_contents('php://input');
			$this->method = 'POST';
		}

		//put
		if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
			//parse_str(file_get_contents('php://input'), $this->_PUT);
			$this->_PUT = file_get_contents('php://input');
			$this->method = 'PUT';
		}
		//delete
		if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
			//parse_str(file_get_contents('php://input'), $_DELETE);
			$this->_DELETE = file_get_contents('php://input');
			$this->method = 'DELETE';
		}

		//pegar dados enviados
		$this->extract();
    }

    /**
     * metodo que ajusta os headers do envio
     */
    public function header($head) 
    {
        $this->head = $head;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->head);
    }

    /**
     * metodo que obtem os headers enviados (get ou post)
     */
    public function getHeaders() {
        $this->headers = getallheaders();
        return $this->headers;
    }

    /**
     * metodo que recebe um header e retorna o token (Bearer)
     */
    public function getToken($headers) {
        $token = '';
        if (!isset($headers["Authorization"]) && !isset($headers["authorization"])) {
            $_bearer_token = '';
        }
        elseif (isset($headers["Authorization"])) {
            $_bearer_token = $headers["Authorization"];
        }
        elseif (isset($headers["authorization"])) {
            $_bearer_token = $headers["authorization"];
        }
        
        // Check if the header starts with "Bearer " and extract the token
        if (preg_match('/Bearer\s(\S+)/', $_bearer_token, $matches)) {
            $token = $matches[1];
        }
        //$token = str_replace('Bearer ','', $_bearer_token);

        return $token;
    }

    /**
     * metodos especificos de acesso 
     * post
     */
    public function post($body, $head) 
    {
        $this->body = $body;
        $this->head = $head;

        //Marca que vai enviar por POST (1=SIM)
        curl_setopt($this->curl, CURLOPT_POST, 1);
        
        //Passa o conteúdo para o campo de envio por POST
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->body);
        
        //Marca que vai receber string
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        //Headers
        $this->header($this->head);
        
        //executa e retorna o response
        $response = $this->exec();
        return $response;
    }

    /**
     * metodos especificos de acesso 
     * get
     */
    public function get($body, $head) 
    {
        $this->body = $body;
        $this->head = $head;

        //Marca que vai enviar por GET (1=SIM)
        //curl_setopt($this->curl, CURLOPT_GET, 1);
        
        //Passa o conteúdo para o campo de envio por GET
        //curl_setopt($this->curl, CURLOPT_GETFIELDS, $this->body);
        
        //Marca que vai receber string
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        //Headers
        $this->header($head);

        //executa e retorna o response
        $response = $this->exec();
        return $response;
    }


    /**
     * metodos especificos de acesso 
     * put
     */
     public function put($body, $head) 
     {
         $this->body = $body;
         $this->head = $head;

         //Marca que vai enviar por PUT 
         curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PUT");
         
         //Passa o conteúdo para o campo de envio por PUT
         curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($this->body));
         
         //Marca que vai receber string
         curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
 
         //Headers
         $this->header($this->head);
         
         //executa e retorna o response
         $response = $this->exec();
         return $response;
     }


    /**
     * metodo que executa o envio e retorna a resposta
     */
    public function exec() 
    {
        //executa a comunicacao
        $resposta = curl_exec($this->curl);
        
        //Fecha a conexao
        //curl_close($this->curl);

        return $resposta;
    }

    /**
     * metodo que exibe infos do objeto cURL
     */
    public function info()
    {
        $opt = 0;

        echo '<pre>'; 
        print_r( curl_getinfo($this->curl) );
        exit;
    }


    /**
	 * @method 	extract() extrai os dados da URL (só para GET)
	 */
	public function extract() 
    {
		if (isset($_GET['url'])) {
            //pega o parametro URL definido no .htaccess
            $arr = explode('/', $_GET['url']);

            //1ro paramentro depois da "/"
            $entity = ucfirst($arr[0]);
            $this->entity = $entity;
            array_shift($arr);

            //demais parametros
            if (!empty($arr[0])) {
                $params = array();
                $params = $arr;
                $this->params = $params;
            }
        }
	}

    // ########################################
    /** 
     * Métodos para criação e manipulação de JWT
     */

    private function base64url_encode($data)
    {
        return str_replace(['+','/','='], ['-','_',''], base64_encode($data));
    }

    private function base64_decode_url($string) 
    {
        return base64_decode(str_replace(['-','_'], ['+','/'], $string));
    }

    // retorna JWT
    public function encode(array $payload, string $secret): string
    {
        $header = json_encode([
            "alg" => "HS256",
            "typ" => "JWT"
        ]);
        $payload = json_encode($payload);
        $header_payload = $this->base64url_encode($header) . '.'. static::base64url_encode($payload);
        $signature = hash_hmac('sha256', $header_payload, $secret, true);
        return 
            $this->base64url_encode($header) . '.' .
            $this->base64url_encode($payload) . '.' .
            $this->base64url_encode($signature);
    }

    // retorna payload em formato array, ou lança um Exception
    public function decode(string $token, string $secret): array
    {
        $token = explode('.', $token);
        $header = $this->base64_decode_url($token[0]);
        $payload = $this->base64_decode_url($token[1]);
        $signature = $this->base64_decode_url($token[2]);
        $header_payload = $token[0] . '.' . $token[1];
        if (hash_hmac('sha256', $header_payload, $secret, true) !== $signature) {
            throw new \Exception('Invalid signature');
        }
        return json_decode($payload, true);
    }

    // retorna payload em formato array, sem verificar secret
    public function payload(string $token): array
    {
        $token = explode('.', $token);
        if (is_array($token) && count($token) == 3) {
            $header = $this->base64_decode_url($token[0]);
            $payload = $this->base64_decode_url($token[1]);
            $signature = $this->base64_decode_url($token[2]);
            $header_payload = $token[0] . '.' . $token[1];
        }
        else {
            $payload = "{}";
        }
        return json_decode($payload, true);
    }

}
?>