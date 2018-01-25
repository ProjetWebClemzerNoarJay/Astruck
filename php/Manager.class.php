<?php
//Classe de base non instanciable dont héritera chacunes de nos classes manager
abstract class Manager
{
	protected $db;

	public function __construct(PDO $obj)
	{
		$this->db = $obj;
	}

	//Getter
	public function getDb()
	{
		return $this->db;
	}

	//Setter
	public function setDb(PDO $new)
	{
		$this->db = $new;
	}
}
