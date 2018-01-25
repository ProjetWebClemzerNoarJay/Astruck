<?php
//Création du trait modèlisant nos commandes
trait OrderTrait
{
	protected $id_commande;
	protected $date_commande;
	protected $heure_commande;
	protected $id_user;
	protected $prix;

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
	public function getId_commande()
	{
		return $this->id_commande;
	}

	public function getDate_commande()
	{
		return $this->date_commande;
	}

	public function getHeure_commande()
	{
		return $this->heure_commande;
	}

	public function getId_user()
	{
		return $this->id_user;
	}

	public function getPrix()
	{
		return $this->prix;
	}

	//Setters
	public function setId_commande($new)
	{
		$this->id_commande = (int) $new;
	}

	public function setDate_commande($new)
	{
		$this->date_commande = $new;
	}

	public function setHeure_commande($new)
	{
		$this->heure_commande = $new;
	}

	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	public function setPrix($new)
	{
		$this->prix = (int) $new;
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
