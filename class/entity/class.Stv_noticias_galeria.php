<?php
		/**
 * Classe que representa a tabela "Stv_noticias_galeria" 
 */
class Stv_noticias_galeria
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
	private $anexo;
	private $id_noticia;
	
	
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
	// -- anexo
	public function setAnexo($anexo) {
		$this->anexo = $anexo;
	}
	public function getAnexo() {
		return $this->anexo;
	}
	// -- id_noticia
	public function setId_noticia($id_noticia) {
		$this->id_noticia = $id_noticia;
	}
	public function getId_noticia() {
		return $this->id_noticia;
	}
	
} 
	?>