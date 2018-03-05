<?php
//Création du trait orderTrait à implémenter aux objets modèlisant nos commandes (utilisation d'un trait pour palier au multiple héritage => classe fullOrder)
Trait OrderTrait
{
	protected $id_commande;
	protected $date_commande;
	protected $heure_commande;
	protected $id_user;
	protected $prix;

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
	*	@return string $date_commande
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
	*	@param string|int $new
	*	@return void
	*/
	public function setId_commande($new)
	{
		$this->id_commande = (int) $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setDate_commande(string $new)
	{
		$this->date_commande = $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setHeure_commande(string $new)
	{
		$this->heure_commande = $new;
	}

	/**
	*	@param string|int $new
	*	@return void
	*/
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}

	/**
	*	@param string|int $new
	*	@return void
	*/
	public function setPrix($new)
	{
		$this->prix = (int) $new;
	}
}