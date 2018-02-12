<?php
class Type
{
	use EntityTrait;

	protected $id_type;
	protected $nom;

	//Getters
	/**
	*	@param void
	*	@return int $id_produit
	*/
	public function getId_type()
	{
		return $this->id_type;
	}

	/**
	*	@param void
	*	@return String $nom
	*/
	public function getNom()
	{
		return $this->nom;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_type($new)
	{
		$this->id_type = (int) $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setNom(String $new)
	{
		$this->nom = $new;
	}
}