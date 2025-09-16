<?php
		/**
 * Classe que representa a tabela "Stv_novidades_filial" 
 */
class Stv_novidades_filial
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
	private $id_filial;
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
	// -- id_filial
	public function setId_filial($id_filial) {
		$this->id_filial = $id_filial;
	}
	public function getId_filial() {
		return $this->id_filial;
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