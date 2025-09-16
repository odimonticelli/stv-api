<?php
		/**
 * Classe que representa a tabela "Stv_usuarios_online" 
 */
class Stv_usuarios_online
{
	/**
	 * metodo construtor
	 */ 
	public function __construct(){}

	/**
	 * metodo clone do tipo privado previne a clonagem dessa instancia da classe
	 */
	public function __clone(){}

	/**
	 * destrutor do objeto da classe
	 */
	public function __destruct(){}


	/**
	 * atributos (variaveis) relacionadas as colunas da tabela
	 */

	private $id;
	private $codpes;
	private $matricula;
	private $cpf;
	private $nome;
	private $telefone;
	private $celular;
	private $email;
	private $datanasc;
	private $sexo;
	private $estcivil;
	private $cep;
	private $endereco;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $uf;
	private $funcao;
	private $empresa;
	private $filial;
	private $unidade;
	private $setor;
	private $area;
	private $codagrupamatr;
	private $candidato;
	private $ultsituacao;
	private $senha;
	private $status;
	private $data_admissao;
	private $data_atualiza;
	private $data_registro;
	private $usuario_registro;
	private $ip_registro;
	private $token_expo;
	private $device_plat;
	private $device_brand;
	private $device_model;
	private $device_os;
	
	
	/**
	 * metodos para obter e ajustar dados das variaveis (get e set)
	 */
	
	// -- id
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	// -- codpes
	public function setCodpes($codpes) {
		$this->codpes = $codpes;
	}
	public function getCodpes() {
		return $this->codpes;
	}
	// -- matricula
	public function setMatricula($matricula) {
		$this->matricula = $matricula;
	}
	public function getMatricula() {
		return $this->matricula;
	}
	// -- cpf
	public function setCpf($cpf) {
		$this->cpf = $cpf;
	}
	public function getCpf() {
		return $this->cpf;
	}
	// -- nome
	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function getNome() {
		return $this->nome;
	}
	// -- telefone
	public function setTelefone($telefone) {
		$this->telefone = $telefone;
	}
	public function getTelefone() {
		return $this->telefone;
	}
	// -- celular
	public function setCelular($celular) {
		$this->celular = $celular;
	}
	public function getCelular() {
		return $this->celular;
	}
	// -- email
	public function setEmail($email) {
		$this->email = $email;
	}
	public function getEmail() {
		return $this->email;
	}
	// -- datanasc
	public function setDatanasc($datanasc) {
		$this->datanasc = $datanasc;
	}
	public function getDatanasc() {
		return $this->datanasc;
	}
	// -- sexo
	public function setSexo($sexo) {
		$this->sexo = $sexo;
	}
	public function getSexo() {
		return $this->sexo;
	}
	// -- estcivil
	public function setEstcivil($estcivil) {
		$this->estcivil = $estcivil;
	}
	public function getEstcivil() {
		return $this->estcivil;
	}
	// -- cep
	public function setCep($cep) {
		$this->cep = $cep;
	}
	public function getCep() {
		return $this->cep;
	}
	// -- endereco
	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}
	public function getEndereco() {
		return $this->endereco;
	}
	// -- numero
	public function setNumero($numero) {
		$this->numero = $numero;
	}
	public function getNumero() {
		return $this->numero;
	}
	// -- complemento
	public function setComplemento($complemento) {
		$this->complemento = $complemento;
	}
	public function getComplemento() {
		return $this->complemento;
	}
	// -- bairro
	public function setBairro($bairro) {
		$this->bairro = $bairro;
	}
	public function getBairro() {
		return $this->bairro;
	}
	// -- cidade
	public function setCidade($cidade) {
		$this->cidade = $cidade;
	}
	public function getCidade() {
		return $this->cidade;
	}
	// -- uf
	public function setUf($uf) {
		$this->uf = $uf;
	}
	public function getUf() {
		return $this->uf;
	}
	// -- funcao
	public function setFuncao($funcao) {
		$this->funcao = $funcao;
	}
	public function getFuncao() {
		return $this->funcao;
	}
	// -- empresa
	public function setEmpresa($empresa) {
		$this->empresa = $empresa;
	}
	public function getEmpresa() {
		return $this->empresa;
	}
	// -- filial
	public function setFilial($filial) {
		$this->filial = $filial;
	}
	public function getFilial() {
		return $this->filial;
	}
	// -- unidade
	public function setUnidade($unidade) {
		$this->unidade = $unidade;
	}
	public function getUnidade() {
		return $this->unidade;
	}
	// -- setor
	public function setSetor($setor) {
		$this->setor = $setor;
	}
	public function getSetor() {
		return $this->setor;
	}
	// -- area
	public function setArea($area) {
		$this->area = $area;
	}
	public function getArea() {
		return $this->area;
	}
	// -- codagrupamatr
	public function setCodagrupamatr($codagrupamatr) {
		$this->codagrupamatr = $codagrupamatr;
	}
	public function getCodagrupamatr() {
		return $this->codagrupamatr;
	}
	// -- candidato
	public function setCandidato($candidato) {
		$this->candidato = $candidato;
	}
	public function getCandidato() {
		return $this->candidato;
	}
	// -- ultsituacao
	public function setUltsituacao($ultsituacao) {
		$this->ultsituacao = $ultsituacao;
	}
	public function getUltsituacao() {
		return $this->ultsituacao;
	}
	// -- senha
	public function setSenha($senha) {
		$this->senha = $senha;
	}
	public function getSenha() {
		return $this->senha;
	}
	// -- status
	public function setStatus($status) {
		$this->status = $status;
	}
	public function getStatus() {
		return $this->status;
	}
	// -- data_admissao
	public function setData_admissao($data_admissao) {
		$this->data_admissao = $data_admissao;
	}
	public function getData_admissao() {
		return $this->data_admissao;
	}
	// -- data_atualiza
	public function setData_atualiza($data_atualiza) {
		$this->data_atualiza = $data_atualiza;
	}
	public function getData_atualiza() {
		return $this->data_atualiza;
	}
	// -- data_registro
	public function setData_registro($data_registro) {
		$this->data_registro = $data_registro;
	}
	public function getData_registro() {
		return $this->data_registro;
	}
	// -- usuario_registro
	public function setUsuario_registro($usuario_registro) {
		$this->usuario_registro = $usuario_registro;
	}
	public function getUsuario_registro() {
		return $this->usuario_registro;
	}
	// -- ip_registro
	public function setIp_registro($ip_registro) {
		$this->ip_registro = $ip_registro;
	}
	public function getIp_registro() {
		return $this->ip_registro;
	}
	// -- token_expo
	public function setToken_expo($token_expo) {
		$this->token_expo = $token_expo;
	}
	public function getToken_expo() {
		return $this->token_expo;
	}
	// -- device_plat
	public function setDevice_plat($device_plat) {
		$this->device_plat = $device_plat;
	}
	public function getDevice_plat() {
		return $this->device_plat;
	}
	// -- device_brand
	public function setDevice_brand($device_brand) {
		$this->device_brand = $device_brand;
	}
	public function getDevice_brand() {
		return $this->device_brand;
	}
	// -- device_model
	public function setDevice_model($device_model) {
		$this->device_model = $device_model;
	}
	public function getDevice_model() {
		return $this->device_model;
	}
	// -- device_os
	public function setDevice_os($device_os) {
		$this->device_os = $device_os;
	}
	public function getDevice_os() {
		return $this->device_os;
	}
	
} 
	?>