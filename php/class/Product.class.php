<?php
//Création de la classe des produits
class Product
{
	use EntityTrait;

	protected $id_produit;
	protected $nom;
	protected $prix;
	protected $image;
	protected $description;
	protected $id_type;

	//Getters
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
	*	@return String $nom
	*/
	public function getNom()
	{
		return $this->nom;
	}

	/**
	*	@param void
	*	@return float $prix
	*/
	public function getPrix()
	{
		return $this->prix;
	}

	/**
	*	@param void
	*	@return String $image
	*/
	public function getImage()
	{
		return $this->image;
	}

	/**
	*	@param void
	*	@return String $description
	*/
	public function getDescription()
	{
		return $this->description;
	}

	/**
	*	@param void
	*	@return int $id_type
	*/
	public function getId_type()
	{
		return $this->type;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_produit($new)
	{
		$this->id_produit = (int) $new;
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
	*	@param String|float $new
	*	@return void
	*/
	public function setPrix($new)
	{
		$this->prix = (float) $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setImage(String $new)
	{
		$this->image = $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setDescription(String $new)
	{
		$this->description = $new;
	}

	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_type($new)
	{
		$this->id_type = (int) $new;
	}
}
