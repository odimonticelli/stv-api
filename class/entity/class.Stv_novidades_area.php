<?php
		/**
 * Classe que representa a tabela "Stv_novidades_area" 
 */
class Stv_novidades_area
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
	private $id_area;
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
	// -- id_area
	public function setId_area($id_area) {
		$this->id_area = $id_area;
	}
	public function getId_area() {
		return $this->id_area;
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