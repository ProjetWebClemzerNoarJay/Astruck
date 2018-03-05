<?php
//Création d'une classe Purchase
class Purchase
{
	use EntityTrait;
	
	protected $id_commande;
	protected $id_produit;
	protected $quantite;

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
	*	@return int $id_produit
	*/
	public function getId_produit()
	{
		return $this->id_produit;
	}

	/**
	*	@param void
	*	@return int $quantité
	*/
	public function getQuantite()
	{
		return $this->quantite;
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
	*	@param string|int $new
	*	@return void
	*/
	public function setId_produit($new)
	{
		$this->id_produit = (int) $new;
	}

	/**
	*	@param string|int $new
	*	@return void
	*/
	public function setQuantite($new)
	{
		$this->quantite = (int) $new;
	}
}
