<?php
//Trait représentant les méthodes communes aux objets représentant nos entités en bdd qui sera utilisé par toutes celles ci
Trait EntityTrait
{
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