<?php
//Manager de produits
class ProductManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_produit", "nom", "prix", "image", "description", "id_type"];

	//Fonctions d'ajout, de suppression et de modification de produits dans notre table produit
	/**
	*	@param Product $prd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
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
	/**
	*	@param int $id|null - id du produit à supprimer en bdd
	*	@param string $nom|null - nom du produit à supprimer en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function delProduct(int $id = null, string $nom = null)
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
	/**
	*	@param int $id - id du produit à modifier en bdd
	*	@param string $champ - nom du champ à modifier en bdd
	*	@param mixed $new - valeur a affecter
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function setProductField($id, string $champ, $new)
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
	/**
	*	@param int $id - id du produit à accéder en bdd
	*	@param string $champ - nom du champ à accéder en bdd
	*	@return int|array 0|$answ[0] - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function getProductField($id, string $champ)
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
	/**
	*	@param int $id|null - id du produit à accéder en bdd
	*	@param string $nom|null - nom du produit à accéder en bdd
	*	@return int|Product 0| - objet produit initialisé avec le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function loadProduct(int $id = null, string $nom = null)
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
	/**
	*	@param int $nb|null - nombre d'entrées à retrouner depuis la première en bdd
	*	@return int|array 0|$data - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
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
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		return $data;
	}

	//Méthode listant nos entrées de la bdd en fonction de la catégorie souhaitée
	/**
	*	@param string $cat - nom de la catégorie de produits à récuperer
	*	@return int|array 0|$data - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function listProductsCat(string $cat)
	{
		try
		{
			$req = $this->db->prepare("SELECT produit.id_produit, produit.nom, produit.prix, produit.image, produit.description FROM produit INNER JOIN type ON produit.id_type = type.id_type WHERE type.nom = :c");
			$req->bindValue(":c", $cat);
			$req->execute();
			$data = $req->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $data;
	}

	//Méthode de "conversion" d'un nom de produit en id associé
	/**
	*	@param string $name - nom du produit concerné
	*	@return int|array 0|$data - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
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

	//Méthode retournant un nom d'image choisi "aléatoirement"
	/**
	*	@param string $type - nom du type concerné
	*	@return int|string 0| - nom de l'image retournée si la requette s'est bien executee sinon 0
	*/
	public function pickRdmImage(string $type)
	{
		try
		{
			$req = $this->db->prepare("SELECT image FROM (SELECT produit.image, type.nom FROM produit INNER JOIN type ON produit.id_type = type.id_type WHERE type.nom = :t) AS RQ");
			$req->bindValue(':t', $type);
			$req->execute();
			$data = $req->fetchAll();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $data[rand(0, (count($data) - 1))]['image'];
	}
}
