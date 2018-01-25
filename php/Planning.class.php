<?php

//Création de la classe definissant les plannings (position de l'entreprise en fonction du jour)
class Planning
{
	protected $id_planning;
	protected $jour;
	protected $latitude;
	protected $longitude;

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
	public function getId_planning()
	{
		return $this->id_planning;
	}

	public function getJour()
	{
		return $this->jour;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

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
		$this->latitude = (int) $new;
	}

	public function setLongitude($new)
	{
		$this->longitude = (int) $new;
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
