<?php
		/**
 * Classe que representa a tabela "Stv_novidades_usuarios_individual" 
 */
class Stv_novidades_usuarios_individual
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
	private $id_usuarios;
	private $id_novidade;
	
	
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
	// -- id_usuarios
	public function setId_usuarios($id_usuarios) {
		$this->id_usuarios = $id_usuarios;
	}
	public function getId_usuarios() {
		return $this->id_usuarios;
	}
	// -- id_novidade
	public function setId_novidade($id_novidade) {
		$this->id_novidade = $id_novidade;
	}
	public function getId_novidade() {
		return $this->id_novidade;
	}
	
} 
	?>