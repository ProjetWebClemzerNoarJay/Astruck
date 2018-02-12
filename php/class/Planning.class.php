<?php

//Création de la classe definissant les plannings (position de l'entreprise en fonction du jour)
class Planning
{
	use EntityTrait;
	
	protected $id_planning;
	protected $jour;
	protected $latitude;
	protected $longitude;

	//Getters
	/**
	*	@param void
	*	@return int $id_planning
	*/
	public function getId_planning()
	{
		return $this->id_planning;
	}

	/**
	*	@param void
	*	@return String $jour
	*/
	public function getJour()
	{
		return $this->jour;
	}

	/**
	*	@param void
	*	@return float $latitude
	*/
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	*	@param void
	*	@return float $longitude
	*/
	public function getLongitude()
	{
		return $this->longitude;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_planning($new)
	{
		$this->id_planning = (int) $new;
	}

	/**
	*	@param String $new
	*	@return void
	*/
	public function setJour(String $new)
	{
		$this->jour = $new;
	}

	/**
	*	@param String|float $new
	*	@return void
	*/
	public function setLatitude($new)
	{
		$this->latitude = (float) $new;
	}

	/**
	*	@param String|float $new
	*	@return void
	*/
	public function setLongitude($new)
	{
		$this->longitude = (float) $new;
	}
}
