<?php
//Création de la classe User implémentant le trait UserTrait pour la représentation d'un utilisateur
class User
{
	protected $id_user;
	protected $nom;
	protected $prenom;
	protected $email;
	protected $mdp;
	protected $tel;

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