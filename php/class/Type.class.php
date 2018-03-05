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
	*	@return string $nom
	*/
	public function getNom()
	{
		return $this->nom;
	}

	//Setters
	/**
	*	@param string|int $new
	*	@return void
	*/
	public function setId_type($new)
	{
		$this->id_type = (int) $new;
	}

	/**
	*	@param string $new
	*	@return void
	*/
	public function setNom(string $new)
	{
		$this->nom = $new;
	}
}