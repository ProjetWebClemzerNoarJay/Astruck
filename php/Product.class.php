<?php
//Création de la classe des produits
class Product
{
	protected $id_produit;
	protected $nom;
	protected $prix;
	protected $image;
	protected $description;
	protected $id_type;

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
	public function getId_produit()
	{
		return $this->id_produit;
	}

	public function getNom()
	{
		return $this->nom;
	}

	public function getPrix()
	{
		return $this->prix;
	}

	public function getImage()
	{
		return $this->image;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getId_type()
	{
		return $this->type;
	}

	//Setters
	public function setId_produit($new)
	{
		$this->id_produit = (int) $new;
	}

	public function setNom(String $new)
	{
		$this->nom = $new;
	}

	public function setPrix($new)
	{
		$this->prix = (int) $new;
	}

	public function setImage(String $new)
	{
		$this->image = $new;
	}

	public function setDescription($new)
	{
		$this->description = $new;
	}

	public function setId_type($new)
	{
		$this->id_type = (int) $new;
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
