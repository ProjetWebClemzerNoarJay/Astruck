<?php
//Manager de commandes
class OrderManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_commande", "date_commande", "heure_commande", "id_user"];

	//Méthode d'ajour d'un objet Order en bdd
	/**
	*	@param int|string $idUser - id de l'user associé à la commande
	*	@return int 0|$idO - id de la commande si la requete s'est correctement executee sinon 0
	*/
	public function addOrder($idUser)
	{
		try
		{
			$req = $this->db->query("SELECT MAX(id_commande) FROM commande");
			$data = $req->fetch();
			$idO = $data[0] + 1;
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		try
		{
			$req = $this->db->prepare("INSERT INTO commande VALUES(:io, CURRENT_DATE, CURRENT_TIME, :iu)");
			$req->bindValue(":io", $idO);
			$req->bindValue("iu", (int)$idUser);
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $idO;
	}

	/**
	*	@param int $id - l'id de la commande a supprimer
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function delOrder(int $id)
	{
		try
		{
			$req = $this->db->prepare("DELETE FROM commande WHERE id_commande = :i");
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

	//Méthode de modifcation d'un champ d'une entrée (via id) de notre table commande
	/**
	*	@param int|string $id - l'id de la commande a modifier en bdd
	*	@param string $champ - champ a modifier en bdd
	*	@param mixed $new - valeur a affecter
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function setOrderField($id, string $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE commande SET " . $champ . " = :n WHERE id_commande = :i");
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
	*	@param int $id - l'id de la commande a acceder en bdd
	*	@param string $champ - champ a recuperer en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function getOrderField($id, string $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM commande WHERE id_commande = :i");
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

	//Méthode de chargement d'une commande via son id en array d'hydratation pour instanciation d'un objet Order
	/**
	*	@param int $id - l'id de la commande a charger en bdd
	*	@return Order|int 0 - objet order initialise avec l'array de la requete ou 0 si la requete a echoue ou n'a rien retourne
	*/
	public function loadOrder(int $id)
	{
		try
		{
			$req = $this->db->prepare("SELECT * FROM commande WHERE id_commande = :i");
			$req->bindValue(":i", $id);
			$req->execute();
			$data = $req->fetch();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return new Order($data);
	}

	/**
	*	@param int $nb|null - nombre d'entrees a selectionner depuis la premiere
	*	@return Array|int $data|0 - tableau associatif des entrees en bdd ou 0 si la requete echoue 
	*/
	public function listOrders(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM commande LIMIT 0, " . $nb);
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
				$req = $this->db->query("SELECT * FROM commande");
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

	//Méthode d'affichage des commandes non validées (non archivées)
	/**
	*	@param int $nb|null - nombre d'entrees a selectionner depuis la premiere
	*	@return Array|int $data|0 - tableau associatif des entrees en bdd ou 0 si la requete echoue 
	*/
	public function listCurrOrders(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM commande WHERE commande.id_commande NOT IN (SELECT archive_commande.id_commande FROM archive_commande) LIMIT 0, " . $nb);
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
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
				$req = $this->db->query("SELECT * FROM commande WHERE commande.id_commande NOT IN (SELECT archive_commande.id_commande FROM archive_commande)");
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		return $data;
	}
}
