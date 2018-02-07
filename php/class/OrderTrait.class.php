<?php
//Création du trait orderTrait à implémenter aux objets modèlisant nos commandes (utilisation d'un trait pour palier au multiple héritage => classe fullOrder)
Trait OrderTrait
{
	protected $id_commande;
	protected $date_commande;
	protected $heure_commande;
	protected $id_user;
	protected $prix;

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
	*	@return int $id_commande
	*/
	public function getId_commande()
	{
		return $this->id_commande;
	}

	/**
	*	@param void
	*	@return String $date_commande
	*/
	public function getDate_commande()
	{
		return $this->date_commande;
	}

	/**
	*	@param void
	*	@return string $heure_commande
	*/
	public function getHeure_commande()
	{
		return $this->heure_commande;
	}

	/**
	*	@param void
	*	@return int $id_user
	*/
	public function getId_user()
	{
		return $this->id_user;
	}

	/**
	*	@param void
	*	@return int $prix
	*/
	public function getPrix()
	{
		return $this->prix;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_commande($new)
	{
		$this->id_commande = (int) $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setDate_commande($new)
	{
		$this->date_commande = $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setHeure_commande($new)
	{
		$this->heure_commande = $new;
	}

	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setPrix($new)
	{
		$this->prix = (int) $new;
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