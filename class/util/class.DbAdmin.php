<?php
/**
 * Classe de abstração da PDO, para ajustes de versões quando necessário
 * @author  ODIX.com.br
 * @version 3.0 - usando PDO 
 */

class DbAdmin extends PDO
{
    //definição das variáveis e constantes (propriedades)
    private $tipo;
    private $conn;

    /*
     * metodo que inicializa variáveis (propriedades) - chamado de MÉTODO CONSTRUTOR
     */
    public function __construct($tipo)
    {
        if (empty($tipo)) {
            $this->tipo = 'mysqli';
        }
        $this->tipo = $tipo;
    }

    /*
     * fecha conexao quando classe deixa de ser utilizada
     */
    public function __destruct(){
        $this->conn = NULL;
    }

	/*
	 * metodo de retorno da instância caso ja exista. Caso nao exista cria uma nova.
	 */
	public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static('mysqli');
        }
        return $instance;
    }	

    /*
     * metodos GET para os atributos da classe
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /*
     * metodos GET para os atributos da classe
     */
    public function getConn()
    {
        return $this->conn;
    }

    /*
     * metodo que le parametros do arquivo de propriedades da aplicacao
     */
    public function getProperties() 
    {
        $vetprp = array();
        $parse = [];

        if (is_file('./.env'))
            $parse = parse_ini_file('./.env');
        if (is_file('../.env'))
            $parse = parse_ini_file('../.env');
        if (is_file('../../.env'))
            $parse = parse_ini_file('../../.env');
        
        foreach ($parse as $key => $value) {
            $_ENV[$key] = $value;
        }
        if (isset($_ENV['DB_HOST'])) {
            array_push($vetprp,$_ENV['DB_HOST']);
            array_push($vetprp,$_ENV['DB_BASE']);
            array_push($vetprp,$_ENV['DB_USER']);
            array_push($vetprp,$_ENV['DB_PASS']);
            array_push($vetprp,$_ENV['DB_TYPE']);
        }
        return $vetprp;
    }

    /*
     * metodo que conecta e seleciona a base sem receber parâmetros
     */
    public function connectDefault()
    {
        //obtem a lista de parametros do arquivo application.properties
        $vetprp = $this->getProperties();
        $host = $base = $user = $pass = $type = '';
        if (count($vetprp)>0) {
            list($host, $base, $user, $pass, $type) = $vetprp;
        }
        if (empty($this->conn)) {
            $this->conn = $this->connect($host, $base, $user, $pass, $type);
        }
    }

    //metodo que conecta e seleciona a base de dados
    public function connect($host, $base, $user, $pass, $tipo)
    {
        $this->tipo = $tipo;
        $opts = array(
            PDO::ATTR_AUTOCOMMIT     => TRUE 
            //,PDO::MYSQL_ATTR_SSL_CA   => true 
            //,PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        );
        
        switch ($this->tipo) 
        {
            case 'mysql':
            case 'mysqli':
                $link = "mysql:host=$host;dbname=$base;charset=utf8mb4";
                $this->conn = new PDO($link, $user, $pass, $opts);
                //mysqli_set_charset($this->conn, 'utf8');
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            break;

            case 'oracle':
                $link = "oci:dbname=$base;charset=UTF8";
                $this->conn = new PDO($link, $user, $pass, $opts);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            break;
        }

        return $this->conn;
    }

    //metodo para fechar a conexao..
    public function close() 
    {
        $this->conn = null;
    }

    //-----------------------------------


    //metodo que retorna false caso ocorra algum bug
    public function bug($msg)
    {
        return false;
    }

    /*
     * metodo clone do tipo privado previne a clonagem dessa instância da classe
     */
    //private function __clone(){}
	
    /*
     * metodo unserialize do tipo privado para prevenir a desserialização da instância dessa classe.
     */
    //private function __wakeup(){}

    //-----------------------------------

    //metodo que adiciona "escapes" para caracteres especiais
    public function antiInjection($valor)
    {
        $val = '';
        $val = mysqli_real_escape_string($this->conn, $valor);
        return $val;
    }

    //Prepara valores para instruções SQL
    //@param string $valor
    public static function prepareVal($valor) 
    {    
        //faz os ajustes caso venham caracteres especiais (de escape, principalmente)
        //$valor = DbAdmin::antiInjection($valor);
        //$valor = $this->conn->quote($valor);
        
        //Caso a string iniciar com "!" e terminar com "!" será considerada uma função / palavra reservada do MySQL
        //Exemplos: !NULL!      !CURDATE()!     !NOW()!
        if (substr($valor,0,1) == "!" && substr($valor,-1) == "!") {
            $valor = substr($valor, 1);
            $valor = substr($valor, 0, -1);
        } 
        elseif (empty($valor) && !is_numeric($valor)) {
            //Somente no método insert será capaz de chegar nessa condição
            $valor = "NULL";
        }
        else {
            //Coloca o valor entre aspas simples ''
            $valor = "'".$valor."'";
        }
        return $valor;
    }

    /*
     * método auxiliar para função MySQLi inexistente
     */
    private function mysqli_result($result, $row, $field=0) {
        if ($result===false) return false;
        if ($row>=mysqli_num_rows($result)) return false;
        if (is_string($field) && !(strpos($field,".")===false)) {
            $t_field=explode(".",$field);
            $field=-1;
            $t_fields=mysqli_fetch_fields($result);
            for ($id=0;$id<mysqli_num_fields($result);$id++) {
                if ($t_fields[$id]->table==$t_field[0] && $t_fields[$id]->name==$t_field[1]) {
                    $field=$id;
                    break;
                }
            }
            if ($field==-1) return false;
        }
        mysqli_data_seek($result,$row);
        $line=mysqli_fetch_array($result);
        return isset($line[$field])?$line[$field]:false;
    }

    //metodo para iniciar o controle de transacoes
    public static function transaction1() 
    {
        $dba = DbAdmin::getInstance();
        mysqli_query('SET AUTOCOMMIT = 0', $dba->getConn());
        mysqli_query('START TRANSACTION', $dba->getConn());
    }

    //metodo para validar os comandos da transacao
    public static function commit1()
    {
        $dba = DbAdmin::getInstance();
        mysqli_query('COMMIT', $dba->getConn());
    }

    //metodo para desfazer os comandos da transacao
    public static function rollback1()
    {
        $dba = DbAdmin::getInstance();
        mysqli_query('ROLLBACK', $dba->getConn());
    }
}
?>