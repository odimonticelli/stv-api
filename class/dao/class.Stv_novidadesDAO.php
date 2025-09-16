<?php
		/**
 * Classe que representa os comandos de acesso aos dados da tabela "Stv_novidades" 
 */
class Stv_novidadesDAO extends PDO
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
	 * metodo que faz a insercao de um registro na tabela Stv_novidades
	 */
	public function insert($obj) {
		//pegar os dados do objeto
		$titulo = $this->dba->quote($obj->getTitulo());
		$texto = $this->dba->quote($obj->getTexto());
		$link = $this->dba->quote($obj->getLink());
		$data_registro = $this->dba->quote($obj->getData_registro());
		$ip_registro = $this->dba->quote($obj->getIp_registro());
		$usuario_registro = $this->dba->quote($obj->getUsuario_registro());
		$grupos_usuarios = $this->dba->quote($obj->getGrupos_usuarios());
		$unidades = $this->dba->quote($obj->getUnidades());
		$usuarios = $this->dba->quote($obj->getUsuarios());
		$usuarios_individual = $this->dba->quote($obj->getUsuarios_individual());
		$empresa_filial = $this->dba->quote($obj->getEmpresa_filial());
		$setor = $this->dba->quote($obj->getSetor());
		$area = $this->dba->quote($obj->getArea());
		$cargo = $this->dba->quote($obj->getCargo());
		
		//montar o comando SQL
		$sql = "insert into stv_novidades 
				(
				titulo,
				texto,
				link,
				data_registro,
				ip_registro,
				usuario_registro,
				grupos_usuarios,
				unidades,
				usuarios,
				usuarios_individual,
				empresa_filial,
				setor,
				area,
				cargo
				) 
				values 
				(
				$titulo,
				$texto,
				$link,
				$data_registro,
				$ip_registro,
				$usuario_registro,
				$grupos_usuarios,
				$unidades,
				$usuarios,
				$usuarios_individual,
				$empresa_filial,
				$setor,
				$area,
				$cargo
				)";
				
		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que faz a atualizacao de um registro na tabela Stv_novidades
	 * para remover o valor de uma coluna, atribua a string '!NULL!'
	 */
	public function update($obj) {
		//pegar os dados do objeto
		$id = $obj->getId();
		$titulo = $obj->getTitulo();
		$texto = $obj->getTexto();
		$link = $obj->getLink();
		$data_registro = $obj->getData_registro();
		$ip_registro = $obj->getIp_registro();
		$usuario_registro = $obj->getUsuario_registro();
		$grupos_usuarios = $obj->getGrupos_usuarios();
		$unidades = $obj->getUnidades();
		$usuarios = $obj->getUsuarios();
		$usuarios_individual = $obj->getUsuarios_individual();
		$empresa_filial = $obj->getEmpresa_filial();
		$setor = $obj->getSetor();
		$area = $obj->getArea();
		$cargo = $obj->getCargo();
		
        $campos = '';
        if (!empty($titulo) || is_numeric($titulo)) {
        	$campos .= "titulo=".$this->dba->quote($titulo).", ";
        }
        if (!empty($texto) || is_numeric($texto)) {
        	$campos .= "texto=".$this->dba->quote($texto).", ";
        }
        if (!empty($link) || is_numeric($link)) {
        	$campos .= "link=".$this->dba->quote($link).", ";
        }
        if (!empty($data_registro) || is_numeric($data_registro)) {
        	$campos .= "data_registro=".$this->dba->quote($data_registro).", ";
        }
        if (!empty($ip_registro) || is_numeric($ip_registro)) {
        	$campos .= "ip_registro=".$this->dba->quote($ip_registro).", ";
        }
        if (!empty($usuario_registro) || is_numeric($usuario_registro)) {
        	$campos .= "usuario_registro=".$this->dba->quote($usuario_registro).", ";
        }
        if (!empty($grupos_usuarios) || is_numeric($grupos_usuarios)) {
        	$campos .= "grupos_usuarios=".$this->dba->quote($grupos_usuarios).", ";
        }
        if (!empty($unidades) || is_numeric($unidades)) {
        	$campos .= "unidades=".$this->dba->quote($unidades).", ";
        }
        if (!empty($usuarios) || is_numeric($usuarios)) {
        	$campos .= "usuarios=".$this->dba->quote($usuarios).", ";
        }
        if (!empty($usuarios_individual) || is_numeric($usuarios_individual)) {
        	$campos .= "usuarios_individual=".$this->dba->quote($usuarios_individual).", ";
        }
        if (!empty($empresa_filial) || is_numeric($empresa_filial)) {
        	$campos .= "empresa_filial=".$this->dba->quote($empresa_filial).", ";
        }
        if (!empty($setor) || is_numeric($setor)) {
        	$campos .= "setor=".$this->dba->quote($setor).", ";
        }
        if (!empty($area) || is_numeric($area)) {
        	$campos .= "area=".$this->dba->quote($area).", ";
        }
        if (!empty($cargo) || is_numeric($cargo)) {
        	$campos .= "cargo=".$this->dba->quote($cargo).", ";
        }
        $campos = substr($campos,0,strrpos($campos,','));
        
		//montar o comando SQL
        $sql = "update stv_novidades set
				$campos
				where id = $id";

		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que faz a exclusao de um registro na tabela Stv_novidades
	 */
	public function delete($obj) {
		//pegar os dados do objeto
		$id = $obj->getid();
		
		//montar o comando SQL
		$sql = "delete from stv_novidades 
				where id = $id";
				
		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que retorna os regsitros da tabela Stv_novidades conforme o filtro informado
	 * - filtro e ordem opcionais
	 */
	public function select($where='', $order='') {
		if (!empty($where)) {
			$where = 'where '.$where;
		}
		if (!empty($order)) {
			$order = 'order by '.$order;
		}
		$sql = "select * from stv_novidades $where $order";
		$res = $this->dba->prepare($sql);
		$res->execute();
		$vet = $res->fetchAll();
		return $vet;
	}
    
    
    /**
	 * metodo que retorna o ultimo id cadastrado na tabela Stv_novidades
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
		
		$res = $this->dba->query("SHOW COLUMNS FROM stv_novidades WHERE Field = '".$coluna."'");
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