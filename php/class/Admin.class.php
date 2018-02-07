<?php
//Classe definissant nos entités admin en bdd
class Admin
{
	protected $id_admin;
	protected $id_user;

	//Methodes d'initialisation (constructeur et hydratation => fournir toutes les données des attributs de l'objet)
	/**
	*	@param Array $params - tableau associatif contenant le couple clé/valeur d'initialisation de l'objet
	*	@return void
	*/
	public function __construct(Array $params)
	{
		$this->hydrate($params);
	}

	/**
	*	@param Array $data - tableau associatif contenant le couple clé/valeur d'initialisation de l'objet
	*	@return void
	*/
	public function hydrate(Array $data)
	{
		foreach ($data as $key => $value)
		{
			$method = "set" . ucfirst($key);
			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}

	//Getters
	/**
	*	@param void
	*	@return int $id_admin
	*/
	public function getId_admin()
	{
		return $this->id_admin;
	}

	/**
	*	@param void
	*	@return int $id_user
	*/
	public function getId_user()
	{
		return $this->id_user;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_admin($new)
	{
		$this->id_admin = (int) $new;
	}

	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	//Fonction permettant de retourner un tableau des valeurs des attributs de notre objet
	/**
	*	@param bool $assoc|false - permetant de recuperer un tableau associatif si vrai
	*	@return array $objArray - contenant toutes les valeurs des attributs de l'objet
	*/
	public function toArray(bool $assoc = false)
	{
		$objArray = array();
		if ($assoc)
		{
			foreach ($this as $attr => $value)
			{
				$objArray[$attr] = $value;
			}
		}
		else
		{
			foreach ($this as $attr => $value)
			{
				$objArray[] = $value;
			}
		}
		return $objArray;
	}
}