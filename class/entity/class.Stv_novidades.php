<?php
		/**
 * Classe que representa a tabela "Stv_novidades" 
 */
class Stv_novidades
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
	private $titulo;
	private $texto;
	private $link;
	private $data_registro;
	private $ip_registro;
	private $usuario_registro;
	private $grupos_usuarios;
	private $unidades;
	private $usuarios;
	private $usuarios_individual;
	private $empresa_filial;
	private $setor;
	private $area;
	private $cargo;
	
	
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
	// -- titulo
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	public function getTitulo() {
		return $this->titulo;
	}
	// -- texto
	public function setTexto($texto) {
		$this->texto = $texto;
	}
	public function getTexto() {
		return $this->texto;
	}
	// -- link
	public function setLink($link) {
		$this->link = $link;
	}
	public function getLink() {
		return $this->link;
	}
	// -- data_registro
	public function setData_registro($data_registro) {
		$this->data_registro = $data_registro;
	}
	public function getData_registro() {
		return $this->data_registro;
	}
	// -- ip_registro
	public function setIp_registro($ip_registro) {
		$this->ip_registro = $ip_registro;
	}
	public function getIp_registro() {
		return $this->ip_registro;
	}
	// -- usuario_registro
	public function setUsuario_registro($usuario_registro) {
		$this->usuario_registro = $usuario_registro;
	}
	public function getUsuario_registro() {
		return $this->usuario_registro;
	}
	// -- grupos_usuarios
	public function setGrupos_usuarios($grupos_usuarios) {
		$this->grupos_usuarios = $grupos_usuarios;
	}
	public function getGrupos_usuarios() {
		return $this->grupos_usuarios;
	}
	// -- unidades
	public function setUnidades($unidades) {
		$this->unidades = $unidades;
	}
	public function getUnidades() {
		return $this->unidades;
	}
	// -- usuarios
	public function setUsuarios($usuarios) {
		$this->usuarios = $usuarios;
	}
	public function getUsuarios() {
		return $this->usuarios;
	}
	// -- usuarios_individual
	public function setUsuarios_individual($usuarios_individual) {
		$this->usuarios_individual = $usuarios_individual;
	}
	public function getUsuarios_individual() {
		return $this->usuarios_individual;
	}
	// -- empresa_filial
	public function setEmpresa_filial($empresa_filial) {
		$this->empresa_filial = $empresa_filial;
	}
	public function getEmpresa_filial() {
		return $this->empresa_filial;
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
	// -- cargo
	public function setCargo($cargo) {
		$this->cargo = $cargo;
	}
	public function getCargo() {
		return $this->cargo;
	}
	
} 
	?>