<?php
class Type
{
	protected $id_type;
	protected $nom;

	/**
	*	@param array $params tableau associatif contenant le couple clé/valeur d'initialisation de l'objet
	*/
	//Methodes d'initialisation (constructeur et hydratation)
	public function __construct(Array $params)
	{
		$this->hydrate($params);
	}

	/**
	*	@param array $data tableau associatif contenant le couple clé/valeur d'initialisation de l'objet
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
	public function getId_type()
	{
		return $this->id_type;
	}

	public function getNom()
	{
		return $this->nom;
	}

	//Setters
	public function setId_type($new)
	{
		$this->id_type = (int) $new;
	}

	public function setNom($new)
	{
		$this->nom = $new;
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