<?php

//Création de la classe definissant les plannings (position de l'entreprise en fonction du jour)
class Planning
{
	protected $id_planning;
	protected $jour;
	protected $latitude;
	protected $longitude;

	/**
	*	@param array $params tableau associatif contenant le couple clé/valeur d'initialisation de l'objet
	*	@return void
	*/
	//Methodes d'initialisation (constructeur et hydratation)
	public function __construct(Array $params)
	{
		$this->hydrate($params);
	}

	/**
	*	@param array $data tableau associatif contenant le couple clé/valeur d'initialisation de l'objet
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
	*	@return int $id_planning
	*/
	public function getId_planning()
	{
		return $this->id_planning;
	}

	/**
	*	@param void
	*	@return String $jour
	*/
	public function getJour()
	{
		return $this->jour;
	}

	/**
	*	@param void
	*	@return float $latitude
	*/
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	*	@param void
	*	@return float $longitude
	*/
	public function getLongitude()
	{
		return $this->longitude;
	}

	//Setters
	public function setId_planning($new)
	{
		$this->id_planning = (int) $new;
	}

	public function setJour(String $new)
	{
		$this->jour = $new;
	}

	public function setLatitude($new)
	{
		$this->latitude = (float) $new;
	}

	public function setLongitude($new)
	{
		$this->longitude = (float) $new;
	}

	//Fonction permettant de retourner un tableau des valeurs des attributs de notre objet
	/**
	*	@param bool $assoc|false permetant de recuperer un tableau associatif si vrai
	*	@return array $objArray contenant toutes les valeurs des attributs de l'objet
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
