<?php
//Manager de produits
class ProductManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_produit", "nom", "prix", "image", "description", "id_type"];

	//Fonctions d'ajout, de suppression et de modification de produits dans notre table produit
	public function addProduct(Product $prd)
	{
		try
		{
			$req = $this->db->query("SELECT MAX(id_produit) FROM produit");
			$data = $req->fetch();
			$req->closeCursor();
			$prd->setId_produit($data[0] + 1);
		}
		catch (PDOException $e)
		{
			return 0;
		}
		try
		{
			$req = $this->db->prepare("INSERT INTO produit VALUES(?, ?, ?, ?, ?, ?)");
			$req->execute($prd->toArray());
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de supression d'un produit (via id ou nom pour plus d'ergonomie, nom étant définit comme unique)
	public function delProduct(int $id = null, String $nom = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("DELETE FROM produit WHERE id_produit = :i");
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
		else if (isset($nom))
		{
			try
			{
				$req = $this->db->prepare("DELETE FROM produit WHERE produit.nom = :n");
				$req->bindValue(":n", $nom);
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

	//Méthode de modification d'un champ d'une entrée de notre table produit
	public function setProductField($id, String $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE produit SET " . $champ . " = :n WHERE id_produit = :i");
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

	//Fonctions d'acces aux champs (individuel) de nos produits en base de donnée
	public function getProductField($id, String $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM produit WHERE id_produit = :i");
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

	//Méthode de récuperation d'une entrée de notre table produit via id ou nom (ergonomie / unique)
	public function loadProduct(int $id = null, String $nom = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM produit WHERE id_produit = :i");
				$req->bindValue(":i", $id);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return new Product($data);
		}
		else if (isset($nom))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM produit WHERE produit.nom = :i");
				$req->bindValue(":i", $nom);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return new Product($data);
		}
		return 0;
	}

	//Méthode listant toutes nos entrées de la bdd
	public function listProducts(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM produit LIMIT 0, " . $nb);
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
				$req = $this->db->query("SELECT * FROM produit");
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		return $data;
	}

	//Méthode de "conversion" d'un id produit en nom de produit
	public function getProductIdFromName($name)
	{
		try
		{
			$req = $this->db->prepare("SELECT produit.id_produit FROM produit WHERE produit.nom = :n");
			$req->bindValue(":n", $name);
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
