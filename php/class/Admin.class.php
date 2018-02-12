<?php
//Classe definissant nos entités admin en bdd
class Admin
{
	use EntityTrait;

	protected $id_admin;
	protected $id_user;

	//Getters
	/**
	*	@param void
	*	@return int $id_admin
	*/
	public function getId_admin()
	{
		return $this->id_admin;
	}

	/**
	*	@param void
	*	@return int $id_user
	*/
	public function getId_user()
	{
		return $this->id_user;
	}

	//Setters
	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_admin($new)
	{
		$this->id_admin = (int) $new;
	}

	/**
	*	@param String|int $new
	*	@return void
	*/
	public function setId_user($new)
	{
		$this->id_user = (int) $new;
	}
}