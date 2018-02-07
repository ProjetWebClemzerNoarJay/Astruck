<?php
//Classe de base non instanciable dont héritera chacunes de nos classes manager
abstract class Manager
{
	protected $db;

	/**
	*	@param PDO $obj - objet de connexion a la bdd
	*	@return void
	*/
	public function __construct(PDO $obj)
	{
		$this->db = $obj;
	}

	//Getter
	/**
	*	@param void
	*	@return PDO $db
	*/
	public function getDb()
	{
		return $this->db;
	}

	//Setter
	/**
	*	@param PDO $new
	*	@return void
	*/
	public function setDb(PDO $new)
	{
		$this->db = $new;
	}
}
