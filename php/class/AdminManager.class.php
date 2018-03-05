<?php
//Classe gèrant nos intéractions avec la bdd des admin
class AdminManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_admin", "id_user"];

	//Methode d'ajout d'un administrateur dans la base de donnée, attribution de l'id en fonction de l'id max en bdd
	/**
	*	@param Admin $adm - representant l'admin a creer en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function addAdmin(Admin $adm)
	{
		try
		{
			$req = $this->db->query("SELECT MAX(id_admin) FROM admin");
			$data = $req->fetch();
			$adm->setId_admin($data[0] + 1);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		try
		{
			$req = $this->db->prepare("INSERT INTO admin VALUES(:iu, :ia)");
			$req->bindValue(":iu", $adm->getId_admin());
			$req->bindValue(":ia", $adm->getId_user());
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Methode de supression d'un administrateur dans la base de donnée
	/**
	*	@param int $id - l'id de l'admin a supprimer
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function delAdmin(int $id)
	{
		try
		{
			$req = $this->db->prepare("DELETE FROM admin WHERE id_admin = :i");
			$req->bindValue(":i", $id);
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Methode de modification d'un champ d'un administrateur dans la base de donnée
	/**
	*	@param int|string $id - l'id de l'admin a modifier en bdd
	*	@param string $champ - champ a modifier en bdd
	*	@param mixed $new - valeur a affecter
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function setAdminField($id, string $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE admin SET " . $champ . " = :n WHERE id_admin = :i");
				$req->bindValue(":n", $new);
				$req->bindValue(":i", (int) $id);
				$req->execute();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return 1;
		}
		return 0;
	}

	//Fonctions d'acces aux champs (individuel) de nos commandes en base de donnée
	/**
	*	@param int $id - l'id de l'admin auquel acceder en bdd
	*	@param string $champ - champ a recuperer en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function getAdminField($id, string $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM admin WHERE id_admin = :i");
				$req->bindValue(":i", (int) $id);
				$req->execute();
				$answ = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			if (isset($answ[0]))
			{
				return $answ[0];
			}
		}
		return 0;
	}

	//Methode permettant de charger un admin en bdd en objet Admin
	/**
	*	@param int $id - l'id de l'admin a charger en bdd
	*	@return Admin|int 0 - objet admin initialise avec l'array de la requete ou 0 si la requete a echoue ou n'a rien retourne
	*/
	public function loadAdmin(int $id)
	{
		try
		{
			$req = $this->db->prepare("SELECT * FROM admin WHERE id_admin = :i");
			$req->bindValue("?", $id);
			$req->execute();
			$data = $req->fetch();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return new Admin($data);

	}

	//Méthode de listing de tous nos admins en bdd, paramètre int optionnel permetant de définir la limite d'affichage (en partant des 1eres entrées)
	/**
	*	@param int $nb|null - nombre d'entrees a selectionner depuis la premiere
	*	@return Array|int $data|0 - tableau associatif des entrees en bdd ou 0 si la requete echoue 
	*/
	public function listAdmin(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM admin LIMIT 0, " . $nb);
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		else
		{
			try
			{
				$req = $this->db->query("SELECT * FROM admin");
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			
		}
		return $data;
	}

	//Méthode retournant un tableau d'hydratation pour l'initialisation d'un objet Admin à partir d'un id User (utile pour la création d'admins)
	/**
	*	@param int $id - id de l'user a affecter a l'indice id_user
	*	@return Array $tab - tableau d'hydratation pour l'initialisation d'un nouvel admin
	*/
	public function getHydrateTabFromArg(int $id)
	{
		$tab = array();
		$tab["id_admin"] = 0;
		$tab["id_user"] = $id;
		return $tab;
	}

	//Méthode de convertion id_user à id_admin associé
	/**
	*	@param int $id - id de l'user a rechercher dans la table admin
	*	@return int $data|0 - id admin associe a l'id user entre en parametre ou 0 si la requete echoue 
	*/
	public function idUsrToIdAdm(int $id)
	{
		try
		{
			$req = $this->db->prepare("SELECT id_admin FROM admin WHERE id_user = :i");
			$req->bindValue(":i", $id);
			$req->execute();
			$data = $req->fetch();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return (int) $data[0];
	}
}
