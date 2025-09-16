<?php
		/**
 * Classe que representa os comandos de acesso aos dados da tabela "Stv_usuarios_online" 
 */
class Stv_usuarios_onlineDAO extends PDO
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
	 * metodo que faz a insercao de um registro na tabela Stv_usuarios_online
	 */
	public function insert($obj) {
		//pegar os dados do objeto
		$codpes = $this->dba->quote($obj->getCodpes());
		$matricula = $this->dba->quote($obj->getMatricula());
		$cpf = $this->dba->quote($obj->getCpf());
		$nome = $this->dba->quote($obj->getNome());
		$telefone = $this->dba->quote($obj->getTelefone());
		$celular = $this->dba->quote($obj->getCelular());
		$email = $this->dba->quote($obj->getEmail());
		$datanasc = $this->dba->quote($obj->getDatanasc());
		$sexo = $this->dba->quote($obj->getSexo());
		$estcivil = $this->dba->quote($obj->getEstcivil());
		$cep = $this->dba->quote($obj->getCep());
		$endereco = $this->dba->quote($obj->getEndereco());
		$numero = $this->dba->quote($obj->getNumero());
		$complemento = $this->dba->quote($obj->getComplemento());
		$bairro = $this->dba->quote($obj->getBairro());
		$cidade = $this->dba->quote($obj->getCidade());
		$uf = $this->dba->quote($obj->getUf());
		$funcao = $this->dba->quote($obj->getFuncao());
		$empresa = $this->dba->quote($obj->getEmpresa());
		$filial = $this->dba->quote($obj->getFilial());
		$unidade = $this->dba->quote($obj->getUnidade());
		$setor = $this->dba->quote($obj->getSetor());
		$area = $this->dba->quote($obj->getArea());
		$codagrupamatr = $this->dba->quote($obj->getCodagrupamatr());
		$candidato = $this->dba->quote($obj->getCandidato());
		$ultsituacao = $this->dba->quote($obj->getUltsituacao());
		$senha = $this->dba->quote($obj->getSenha());
		$status = $this->dba->quote($obj->getStatus());
		$data_admissao = $this->dba->quote($obj->getData_admissao());
		$data_atualiza = $this->dba->quote($obj->getData_atualiza());
		$data_registro = $this->dba->quote($obj->getData_registro());
		$usuario_registro = $this->dba->quote($obj->getUsuario_registro());
		$ip_registro = $this->dba->quote($obj->getIp_registro());
		$token_expo = $this->dba->quote($obj->getToken_expo());
		$device_plat = $this->dba->quote($obj->getDevice_plat());
		$device_brand = $this->dba->quote($obj->getDevice_brand());
		$device_model = $this->dba->quote($obj->getDevice_model());
		$device_os = $this->dba->quote($obj->getDevice_os());
		
		//montar o comando SQL
		$sql = "insert into stv_usuarios_online 
				(
				codpes,
				matricula,
				cpf,
				nome,
				telefone,
				celular,
				email,
				datanasc,
				sexo,
				estcivil,
				cep,
				endereco,
				numero,
				complemento,
				bairro,
				cidade,
				uf,
				funcao,
				empresa,
				filial,
				unidade,
				setor,
				area,
				codagrupamatr,
				candidato,
				ultsituacao,
				senha,
				status,
				data_admissao,
				data_atualiza,
				data_registro,
				usuario_registro,
				ip_registro,
				token_expo,
				device_plat,
				device_brand,
				device_model,
				device_os
				) 
				values 
				(
				$codpes,
				$matricula,
				$cpf,
				$nome,
				$telefone,
				$celular,
				$email,
				$datanasc,
				$sexo,
				$estcivil,
				$cep,
				$endereco,
				$numero,
				$complemento,
				$bairro,
				$cidade,
				$uf,
				$funcao,
				$empresa,
				$filial,
				$unidade,
				$setor,
				$area,
				$codagrupamatr,
				$candidato,
				$ultsituacao,
				$senha,
				$status,
				$data_admissao,
				$data_atualiza,
				$data_registro,
				$usuario_registro,
				$ip_registro,
				$token_expo,
				$device_plat,
				$device_brand,
				$device_model,
				$device_os
				)";
				
		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que faz a atualizacao de um registro na tabela Stv_usuarios_online
	 * para remover o valor de uma coluna, atribua a string '!NULL!'
	 */
	public function update($obj) {
		//pegar os dados do objeto
		$id = $obj->getId();
		$codpes = $obj->getCodpes();
		$matricula = $obj->getMatricula();
		$cpf = $obj->getCpf();
		$nome = $obj->getNome();
		$telefone = $obj->getTelefone();
		$celular = $obj->getCelular();
		$email = $obj->getEmail();
		$datanasc = $obj->getDatanasc();
		$sexo = $obj->getSexo();
		$estcivil = $obj->getEstcivil();
		$cep = $obj->getCep();
		$endereco = $obj->getEndereco();
		$numero = $obj->getNumero();
		$complemento = $obj->getComplemento();
		$bairro = $obj->getBairro();
		$cidade = $obj->getCidade();
		$uf = $obj->getUf();
		$funcao = $obj->getFuncao();
		$empresa = $obj->getEmpresa();
		$filial = $obj->getFilial();
		$unidade = $obj->getUnidade();
		$setor = $obj->getSetor();
		$area = $obj->getArea();
		$codagrupamatr = $obj->getCodagrupamatr();
		$candidato = $obj->getCandidato();
		$ultsituacao = $obj->getUltsituacao();
		$senha = $obj->getSenha();
		$status = $obj->getStatus();
		$data_admissao = $obj->getData_admissao();
		$data_atualiza = $obj->getData_atualiza();
		$data_registro = $obj->getData_registro();
		$usuario_registro = $obj->getUsuario_registro();
		$ip_registro = $obj->getIp_registro();
		$token_expo = $obj->getToken_expo();
		$device_plat = $obj->getDevice_plat();
		$device_brand = $obj->getDevice_brand();
		$device_model = $obj->getDevice_model();
		$device_os = $obj->getDevice_os();
		
        $campos = '';
        if (!empty($codpes) || is_numeric($codpes)) {
        	$campos .= "codpes=".$this->dba->quote($codpes).", ";
        }
        if (!empty($matricula) || is_numeric($matricula)) {
        	$campos .= "matricula=".$this->dba->quote($matricula).", ";
        }
        if (!empty($cpf) || is_numeric($cpf)) {
        	$campos .= "cpf=".$this->dba->quote($cpf).", ";
        }
        if (!empty($nome) || is_numeric($nome)) {
        	$campos .= "nome=".$this->dba->quote($nome).", ";
        }
        if (!empty($telefone) || is_numeric($telefone)) {
        	$campos .= "telefone=".$this->dba->quote($telefone).", ";
        }
        if (!empty($celular) || is_numeric($celular)) {
        	$campos .= "celular=".$this->dba->quote($celular).", ";
        }
        if (!empty($email) || is_numeric($email)) {
        	$campos .= "email=".$this->dba->quote($email).", ";
        }
        if (!empty($datanasc) || is_numeric($datanasc)) {
        	$campos .= "datanasc=".$this->dba->quote($datanasc).", ";
        }
        if (!empty($sexo) || is_numeric($sexo)) {
        	$campos .= "sexo=".$this->dba->quote($sexo).", ";
        }
        if (!empty($estcivil) || is_numeric($estcivil)) {
        	$campos .= "estcivil=".$this->dba->quote($estcivil).", ";
        }
        if (!empty($cep) || is_numeric($cep)) {
        	$campos .= "cep=".$this->dba->quote($cep).", ";
        }
        if (!empty($endereco) || is_numeric($endereco)) {
        	$campos .= "endereco=".$this->dba->quote($endereco).", ";
        }
        if (!empty($numero) || is_numeric($numero)) {
        	$campos .= "numero=".$this->dba->quote($numero).", ";
        }
        if (!empty($complemento) || is_numeric($complemento)) {
        	$campos .= "complemento=".$this->dba->quote($complemento).", ";
        }
        if (!empty($bairro) || is_numeric($bairro)) {
        	$campos .= "bairro=".$this->dba->quote($bairro).", ";
        }
        if (!empty($cidade) || is_numeric($cidade)) {
        	$campos .= "cidade=".$this->dba->quote($cidade).", ";
        }
        if (!empty($uf) || is_numeric($uf)) {
        	$campos .= "uf=".$this->dba->quote($uf).", ";
        }
        if (!empty($funcao) || is_numeric($funcao)) {
        	$campos .= "funcao=".$this->dba->quote($funcao).", ";
        }
        if (!empty($empresa) || is_numeric($empresa)) {
        	$campos .= "empresa=".$this->dba->quote($empresa).", ";
        }
        if (!empty($filial) || is_numeric($filial)) {
        	$campos .= "filial=".$this->dba->quote($filial).", ";
        }
        if (!empty($unidade) || is_numeric($unidade)) {
        	$campos .= "unidade=".$this->dba->quote($unidade).", ";
        }
        if (!empty($setor) || is_numeric($setor)) {
        	$campos .= "setor=".$this->dba->quote($setor).", ";
        }
        if (!empty($area) || is_numeric($area)) {
        	$campos .= "area=".$this->dba->quote($area).", ";
        }
        if (!empty($codagrupamatr) || is_numeric($codagrupamatr)) {
        	$campos .= "codagrupamatr=".$this->dba->quote($codagrupamatr).", ";
        }
        if (!empty($candidato) || is_numeric($candidato)) {
        	$campos .= "candidato=".$this->dba->quote($candidato).", ";
        }
        if (!empty($ultsituacao) || is_numeric($ultsituacao)) {
        	$campos .= "ultsituacao=".$this->dba->quote($ultsituacao).", ";
        }
        if (!empty($senha) || is_numeric($senha)) {
        	$campos .= "senha=".$this->dba->quote($senha).", ";
        }
        if (!empty($status) || is_numeric($status)) {
        	$campos .= "status=".$this->dba->quote($status).", ";
        }
        if (!empty($data_admissao) || is_numeric($data_admissao)) {
        	$campos .= "data_admissao=".$this->dba->quote($data_admissao).", ";
        }
        if (!empty($data_atualiza) || is_numeric($data_atualiza)) {
        	$campos .= "data_atualiza=".$this->dba->quote($data_atualiza).", ";
        }
        if (!empty($data_registro) || is_numeric($data_registro)) {
        	$campos .= "data_registro=".$this->dba->quote($data_registro).", ";
        }
        if (!empty($usuario_registro) || is_numeric($usuario_registro)) {
        	$campos .= "usuario_registro=".$this->dba->quote($usuario_registro).", ";
        }
        if (!empty($ip_registro) || is_numeric($ip_registro)) {
        	$campos .= "ip_registro=".$this->dba->quote($ip_registro).", ";
        }
        if (!empty($token_expo) || is_numeric($token_expo)) {
        	$campos .= "token_expo=".$this->dba->quote($token_expo).", ";
        }
        if (!empty($device_plat) || is_numeric($device_plat)) {
        	$campos .= "device_plat=".$this->dba->quote($device_plat).", ";
        }
        if (!empty($device_brand) || is_numeric($device_brand)) {
        	$campos .= "device_brand=".$this->dba->quote($device_brand).", ";
        }
        if (!empty($device_model) || is_numeric($device_model)) {
        	$campos .= "device_model=".$this->dba->quote($device_model).", ";
        }
        if (!empty($device_os) || is_numeric($device_os)) {
        	$campos .= "device_os=".$this->dba->quote($device_os).", ";
        }
        $campos = substr($campos,0,strrpos($campos,','));
        
		//montar o comando SQL
        $sql = "update stv_usuarios_online set
				$campos
				where id = $id";

		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que faz a exclusao de um registro na tabela Stv_usuarios_online
	 */
	public function delete($obj) {
		//pegar os dados do objeto
		$id = $obj->getid();
		
		//montar o comando SQL
		$sql = "delete from stv_usuarios_online 
				where id = $id";
				
		//executar o comando SQL 
		$stt = $this->dba->prepare($sql);
		return $stt->execute();
	}
	
	
	/**
	 * metodo que retorna os regsitros da tabela Stv_usuarios_online conforme o filtro informado
	 * - filtro e ordem opcionais
	 */
	public function select($where='', $order='') {
		if (!empty($where)) {
			$where = 'where '.$where;
		}
		if (!empty($order)) {
			$order = 'order by '.$order;
		}
		$sql = "select * from stv_usuarios_online $where $order";
		$res = $this->dba->prepare($sql);
		$res->execute();
		$vet = $res->fetchAll();
		return $vet;
	}
    
    
    /**
	 * metodo que retorna o ultimo id cadastrado na tabela Stv_usuarios_online
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
		
		$res = $this->dba->query("SHOW COLUMNS FROM stv_usuarios_online WHERE Field = '".$coluna."'");
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