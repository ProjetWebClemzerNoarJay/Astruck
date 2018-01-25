<?php
//Classe definissant nos entités admi en bdd
class Admin
{
	protected $id_admin;
	protected $id_user;

		//Methodes d'initialisation (constructeur et hydratation)
	public function __construct(Array $params)
	{
		$this->hydrate($params);
	}

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
	public function getId_admin()
	{
		return $this->id_admin;
	}

	public function getId_user()
	{
		return $this->id_user;
	}

	//Setters
	public function setId_admin($new)
	{
		$this->id_admin = (int) $new;
	}

	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	//Fonction permettant de retourner un tableau des valeurs des attributs de notre objet
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