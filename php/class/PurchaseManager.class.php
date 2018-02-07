<?php
//Manager d'achats
class PurchaseManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_commande", "id_produit", "quantite"];

	//Méthode d'ajout d'une commande en bdd
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
