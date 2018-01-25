<?php

//Création d'un trait pour palier au multiple héritage pour nos classes User et SuperUser...
trait UserTrait
{
	protected $id_user;
	protected $nom;
	protected $prenom;
	protected $email;
	protected $mdp;
	protected $tel;

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
	public function getId_user()
	{
		return $this->id_user;
	}

	public function getNom()
	{
		return $this->nom;
	}

	public function getPrenom()
	{
		return $this->prenom;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getMdp()
	{
		return $this->mdp;
	}

	public function getTel()
	{
		return $this->tel;
	}

	//Setters
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	public function setNom(String $new)
	{
		$this->nom = $new;
	}

	public function setPrenom(String $new)
	{
		$this->prenom = $new;
	}

	public function setEmail(String $new)
	{
		$this->email = $new;
	}

	public function setMdp(String $new)
	{
		$this->mdp = $new;
	}

	public function setTel($new)
	{
		$this->tel = $new;
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
