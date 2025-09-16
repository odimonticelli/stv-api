<?php
/**
 * Comentários sobre a classe e etc, etc.
 * @author  ODIX.com.br
 * @version 2.7
 */

class DbAdminPDO 
{
    //definição das variáveis e constantes (propriedades)
    private $tipo;
    private $conn;


    /*
     * metodo que inicializa variáveis (propriedades) - chamado de MÉTODO CONSTRUTOR
     */
    public function __construct($tipo='mysqli')
    {
        if (empty($tipo)) {
            $this->tipo = 'mysqli';
        }
        $this->tipo = $tipo;
    }


	/*
     * metodo clone do tipo privado previne a clonagem dessa instância da classe
     */
    public function __clone()
    {
    }
	

    /*
     * metodo unserialize do tipo privado para prevenir a desserialização da instância dessa classe.
     */
    public function __wakeup()
    {
    }


    /*
     * fecha conexao quando classe deixa de ser utilizada
     */
    public function __destruct()
    {
        $this->conn = NULL;
    }


	/*
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


    /*
     * metodo GET para o atributo da classe
     */
    public function getTipo()
    {
        return $this->tipo;
    }


    /*
     * metodo GET para o atributo da classe
     */
    public function getConn()
    {
        return $this->conn;
    }


    /*
     * metodo que conecta e seleciona a base sem receber parâmetros
     */
    public function connectDefault()
    {
        //obtem a lista de parametros do arquivo application.properties.php 
        $arqprp = '../_classes/application.properties.php';
        if (file_exists($arqprp)) {
            require_once($arqprp);
        }
        $arqprp2 = '../../_classes/application.properties.php';
        if (file_exists($arqprp2)) {
            require_once($arqprp2); 
        }
        if (empty($this->conn)) {
            $this->conn = $this->connect($_HOST, $_BASE, $_USER, $_PASS);
        }
    }


    //metodo que conecta e seleciona a base de dados
    public function connect($host, $base, $user, $pass)
    {
        $opts = array(
            PDO::ATTR_AUTOCOMMIT     => TRUE ,
            PDO::MYSQL_ATTR_SSL_CA   => true ,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        );
        $link = "mysql:host=$host;dbname=$base"; 
        $this->conn = new PDO($link, $user, $pass, $opts);
        
        // $this->conn = mysqli_connect($host, $user, $pass, $base);
        // mysqli_set_charset($this->conn, 'utf8');
        
        return $this->conn;
    }

    
    //metodo que executa uma instrução SQL
    public function query($sql)
    {
        try {
            //$res = mysqli_query($this->conn, $sql);
            $stm = $this->conn->query($sql);
            $res = $stm->fetchAll();
        } 
        catch (Exception $ex) {
            $msg = $ex->getMessage();
            $res = 0;
        }
        return $res;
    }


    //metodo que recebe um "resultset" e retorna o nro de linhas
    public function rows($res)
    {
        //$num = mysqli_num_rows($res);
        $num = count($res);
        return $num;
    }


    //metodo que recebe "resultset", linha e coluna e retorna um valor
    public function result($res, $lin, $col)
    {
        $val = $this->pdo_result($res, $lin, $col);
        return $val;
    }


    //metodo que recebe o "resultset" e retorna um vetor
    public function fetch($res)
    {
        //$vet = mysqli_fetch_array($res, MYSQLI_ASSOC);
        foreach ($res as $key => $value) {
            $vet[$key] = $value;
        }
        return $vet;
    }


    //método que coloca o ponteiro de manipulacao do resultado em uma posicao escolhida
    public function seek($res, $nro)
    {
        mysqli_data_seek($res, $nro);
    }


    //metodo que retorna o id do ultimo registro inserido
    public function lastid()
    {
        //$id = mysqli_insert_id($this->conn);
        $id = $this->conn->lastInsertId();
        return $id;
    }


    //metodo para fechar a conexao..
    public function close() 
    {
        //mysqli_close($this->conn);
        $this->conn = null;
    }


    //-----------------------------------


    //metodo que adiciona "escapes" para caracteres especiais
    public function antiInjection($valor)
    {
        $val = '';
        //$val = mysqli_real_escape_string($this->conn, $valor);
        $val = $this->conn->quote($valor);
        return $val;
    }


    //Prepara valores para instruções SQL
    //@param string $valor
    public function prepare($valor) 
    {    
        //faz os ajustes caso venham caracteres especiais (de escape, principalmente)
        $valor = DbAdmin::antiInjection($valor);

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


    //metodo que retorna false caso ocorra algum bug
    public function bug($msg)
    {
        return false;
    }


    //-----------------------------------


    //metodo para iniciar o controle de transacoes
    public static function transaction() 
    {
        $dba = DbAdmin::getInstance();
        mysqli_query('SET AUTOCOMMIT = 0', $dba->getConn());
        mysqli_query('START TRANSACTION', $dba->getConn());
    }


    //metodo para validar os comandos da transacao
    public static function commit()
    {
        $dba = DbAdmin::getInstance();
        mysqli_query('COMMIT', $dba->getConn());
    }


    //metodo para desfazer os comandos da transacao
    public static function rollback()
    {
        $dba = DbAdmin::getInstance();
        mysqli_query('ROLLBACK', $dba->getConn());
    }


    //-----------------------------------

    /*
     * método auxiliar para função MySQLi inexistente
     */
    private function pdo_result($result, $linha, $coluna=0) 
    {
        $val = '';

        if ($result->rowCount() > 1) {
            $lin = 0;
            foreach ($result as $row) {
                if ($lin == $linha) {
                    $val = $row[$coluna];
                    break;
                }
                $lin++;
            }
        } elseif ($sth->rowCount() == 1) {
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $val = $result[$coluna];
        }

        return $val;
    }

}
?>