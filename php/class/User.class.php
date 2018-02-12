<?php
//Création de la classe User implémentant le trait UserTrait pour la représentation d'un utilisateur
class User
{
	use EntityTrait;

	protected $id_user;
	protected $nom;
	protected $prenom;
	protected $email;
	protected $mdp;
	protected $tel;

	//Getters
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
	*	@return String $nom
	*/
	public function getNom()
	{
		return $this->nom;
	}

	/**
	*	@param void
	*	@return String $prenom
	*/
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	*	@param void
	*	@return String $email
	*/
	public function getEmail()
	{
		return $this->email;
	}

	/**
	*	@param void
	*	@return String $mdp
	*/
	public function getMdp()
	{
		return $this->mdp;
	}

	/**
	*	@param void
	*	@return String $tel
	*/
	public function getTel()
	{
		return $this->tel;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setNom(String $new)
	{
		$this->nom = $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setPrenom(String $new)
	{
		$this->prenom = $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setEmail(String $new)
	{
		$this->email = $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setMdp(String $new)
	{
		$this->mdp = $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setTel(String $new)
	{
		$this->tel = $new;
	}
}