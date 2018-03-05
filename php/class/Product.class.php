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
	*	@return string $nom
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
	*	@return string $image
	*/
	public function getImage()
	{
		return $this->image;
	}

	/**
	*	@param void
	*	@return string $description
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
	*	@param string|int $new
	*	@return void
	*/
	public function setId_produit($new)
	{
		$this->id_produit = (int) $new;
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
	*	@param string|float $new
	*	@return void
	*/
	public function setPrix($new)
	{
		$this->prix = (float) $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setImage(string $new)
	{
		$this->image = $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setDescription(string $new)
	{
		$this->description = $new;
	}

	/**
	*	@param string|int $new
	*	@return void
	*/
	public function setId_type($new)
	{
		$this->id_type = (int) $new;
	}
}
