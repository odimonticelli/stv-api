<?php
		/**
 * Classe que representa os comandos de acesso aos dados da tabela "Stv_noticias" 
 */
class Stv_noticiasDAO extends PDO
{
	/**
	 * atributo que representa a conexao com PDF (instancia unica)
	 */
	private $dba;
	
	/**
	 * metodo construtor que ja faz a conexao com o BD
	 */
	public function __construct() {
		$dba = DbAdmin::getInstance();
		$dba->connectDefault();
		$this->dba = $dba->getConn();
	}

	/**
	 * metodo clone do tipo privado previne a clonagem dessa instancia da classe
	 */
	public function __clone(){}

	/**
	 * destrutor do objeto da classe
	 */
	public function __destruct(){}

	/* --------------------------------------------------------- */

	
	/**
	 * metodo que faz a insercao de um registro na tabela Stv_noticias
	 */
	public function insert($obj) {
		//pegar os dados do objeto
		$data = $this->dba->quote($obj->getData());
		$titulo = $this->dba->quote($obj->getTitulo());
		$texto = $this->dba->quote($obj->getTexto());
		$anexo = $this->dba->quote($obj->getAnexo());
		$status = $this->dba->quote($obj->getStatus());
		$id_categoria = $this->dba->quote($obj->getId_categoria());
		$link = $this->dba->quote($obj->getLink());
		$categoria = $this->dba->quote($obj->getCategoria());
		
		//montar o comando SQL
		$sql = "insert into stv_noticias 
				(
				data,
				titulo,
				texto,
				anexo,
				status,
				id_categoria,
				link,
				categoria
				) 
				values 
				(
				$data,
				$titulo,
				$texto,
				$anexo,
				$status,
				$id_categoria,
				$link,
				$categoria
				)";
				
		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que faz a atualizacao de um registro na tabela Stv_noticias
	 * para remover o valor de uma coluna, atribua a string '!NULL!'
	 */
	public function update($obj) {
		//pegar os dados do objeto
		$id = $obj->getId();
		$data = $obj->getData();
		$titulo = $obj->getTitulo();
		$texto = $obj->getTexto();
		$anexo = $obj->getAnexo();
		$status = $obj->getStatus();
		$id_categoria = $obj->getId_categoria();
		$link = $obj->getLink();
		$categoria = $obj->getCategoria();
		
        $campos = '';
        if (!empty($data) || is_numeric($data)) {
        	$campos .= "data=".$this->dba->quote($data).", ";
        }
        if (!empty($titulo) || is_numeric($titulo)) {
        	$campos .= "titulo=".$this->dba->quote($titulo).", ";
        }
        if (!empty($texto) || is_numeric($texto)) {
        	$campos .= "texto=".$this->dba->quote($texto).", ";
        }
        if (!empty($anexo) || is_numeric($anexo)) {
        	$campos .= "anexo=".$this->dba->quote($anexo).", ";
        }
        if (!empty($status) || is_numeric($status)) {
        	$campos .= "status=".$this->dba->quote($status).", ";
        }
        if (!empty($id_categoria) || is_numeric($id_categoria)) {
        	$campos .= "id_categoria=".$this->dba->quote($id_categoria).", ";
        }
        if (!empty($link) || is_numeric($link)) {
        	$campos .= "link=".$this->dba->quote($link).", ";
        }
        if (!empty($categoria) || is_numeric($categoria)) {
        	$campos .= "categoria=".$this->dba->quote($categoria).", ";
        }
        $campos = substr($campos,0,strrpos($campos,','));
        
		//montar o comando SQL
        $sql = "update stv_noticias set
				$campos
				where id = $id";

		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que faz a exclusao de um registro na tabela Stv_noticias
	 */
	public function delete($obj) {
		//pegar os dados do objeto
		$id = $obj->getid();
		
		//montar o comando SQL
		$sql = "delete from stv_noticias 
				where id = $id";
				
		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que retorna os regsitros da tabela Stv_noticias conforme o filtro informado
	 * - filtro e ordem opcionais
	 */
	public function select($where='', $order='') {
		if (!empty($where)) {
			$where = 'where '.$where;
		}
		if (!empty($order)) {
			$order = 'order by '.$order;
		}
		$sql = "select * from stv_noticias $where $order";
		$res = $this->dba->prepare($sql);
		$res->execute();
		$vet = $res->fetchAll();
		return $vet;
	}
    
    
    /**
	 * metodo que retorna o ultimo id cadastrado na tabela Stv_noticias
	 */
	public function lastId() {
		return $this->dba->lastInsertId();
	}
    
    
    /**
	 * metodo que permite a execucao de SQL livre
	 */
    public function execSql($sql='') {
    	$vet = array(); //inicializa

    	if (!empty($sql) && $sql!='') {
			$sql = trim($sql);
			$sel = substr($sql,0,6);
            $res = $this->dba->query($sql);
            if (strtolower($sel)=='select') {
				//retorna um vetor associativo
				$vet = $res->fetchAll(PDO::FETCH_ASSOC);
	        } else {
	        	if ($res > 0)
	        		$vet[0]['success'] = $sql;
	        	else 
	        		$vet[0]['failure'] = $sql;
	        }
        } 
		return $vet;
    }
    

	/**
	 * metodo que lista os valores possiveis de uma coluna do tipo enum (ou outra com enumeracao de valores)
	 * @param $coluna string - Nome da coluna do tipo enum
	 * @param $primeiro string - Qual e o primeiro valor do array, por exemplo: Selecione
	 * @param $excluir array - Quais valores nao devem estar no array
	 * return array
	 */
    public function metaValues($coluna, $primeiro = NULL, $excluir = NULL) {
		
		$res = $this->dba->query("SHOW COLUMNS FROM stv_noticias WHERE Field = '".$coluna."'");
		$row = $this->dba->fetch($res);
		
		$enum = str_replace("enum(", "", $row['Type']);
		$enum = str_replace("'", "", $enum);
		$enum = substr($enum, 0, strlen($enum) - 1);
		$enum = explode(",", $enum);
		
		if ($excluir) {
			foreach ($enum as $chave=>$campo) {
				foreach ($excluir as $tirar) {
					if ($campo == $tirar) {
						unset($enum[$chave]);
					}
				}
			}
		}
		
		$valores = array();
		$i = 0;
		if ($primeiro) {
			$valores[$i] = $primeiro;
			$i++;
		}
		foreach ($enum as $chave => $campo) {
			$campo = trim($campo);
			$valores[$i] = $campo;
			$i++;
		}
		
		return $valores;
	}
    
    



}
 
	?>