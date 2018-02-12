<?php
//Manager d'achats
class PurchaseManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_commande", "id_produit", "quantite"];

	//Méthode d'ajout d'une commande en bdd
	/**
	*	@param Purchase $purchase
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function addPurchase(Purchase $purchase)
	{
		try
		{
			$req = $this->db->prepare("INSERT INTO achat VALUES(?, ?, ?)");
			$req->execute($purchase->toArray());
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de supression d'une commande en bdd
	/**
	*	@param int $id - id de l'achat à supprimer en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function delPurchase(int $id)
	{
		try
		{
			$req = $this->db->prepare("DELETE FROM achat WHERE id_commande = :i");
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

	//Méthode de modification d'un champ de commande en bdd, utilisation de la concaténation des 2 clefs étrangères pour la séléction
	/**
	*	@param int $oId - id_commande de l'achat à modifier en bdd (1ere partie clé primaire)
	*	@param int $pId - id_produit de l'achat à modifier en bdd (2eme partie clé primaire)
	*	@param String $champ - nom du champ à modifier en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function setPurchaseField($oId, $pId, String $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE achat SET " . $champ . " = :n WHERE id_commande = :c AND id_produit = :p");
				$req->bindValue(":n", $new);
				$req->bindValue(":c", (int) $oId);
				$req->bindValue(":p", (int) $pId);
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
	*	@param int $id - id de l'achat à accéder en bdd (1ere partie clé primaire)
	*	@param int $pId - id_produit de l'achat à accéder en bdd (2eme partie clé primaire)
	*	@param String $champ - nom du champ à accéder en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function getPurchaseField($id, $pId, String $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM achat WHERE id_commande = :i AND id_produit = :p");
				$req->bindValue(":i", (int) $id);
				$req->bindValue(":p", (int) $pId);
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

	//Méthode de chargement des achats associés à l'id de commande passé en paramètre
	/**
	*	@param int $id - id_commande de l'achat à charger en bdd (1ere partie clé primaire)
	*	@return int|Achat 0| - objet achat initialisé avec le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function loadPurchase(int $id)
	{
		try
		{
			$req = $this->db->prepare("SELECT * FROM achat WHERE id_commande = ?");
			$req->bindValue("?", $id);
			$req->execute();
			$data = $req->fetch();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return new Purchase($data);
	}

	//Méthode listant toutes nos commande en bdd
	/**
	*	@param int $nb|null - nombre d'entrée de la table achat à récupérer
	*	@return int|array 0|$data - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function listPurchase(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM achat LIMIT 0, " . $nb);
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
				$req = $this->db->query("SELECT * FROM achat");
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
