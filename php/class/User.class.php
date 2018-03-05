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
	*	@return string $nom
	*/
	public function getNom()
	{
		return $this->nom;
	}

	/**
	*	@param void
	*	@return string $prenom
	*/
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	*	@param void
	*	@return string $email
	*/
	public function getEmail()
	{
		return $this->email;
	}

	/**
	*	@param void
	*	@return string $mdp
	*/
	public function getMdp()
	{
		return $this->mdp;
	}

	/**
	*	@param void
	*	@return string $tel
	*/
	public function getTel()
	{
		return $this->tel;
	}

	//Setters
	/**
	*	@param string|int $new
	*	@return void
	*/
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setNom(string $new)
	{
		$this->nom = $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setPrenom(string $new)
	{
		$this->prenom = $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setEmail(string $new)
	{
		$this->email = $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setMdp(string $new)
	{
		$this->mdp = $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setTel(string $new)
	{
		$this->tel = $new;
	}
}