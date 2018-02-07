<?php

class TypeManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_type", "nom"];

	//Fonctions d'ajout, de suppression et de modification de type dans notre table produit
	public function addType(Type $type)
	{
		try
		{
			$req = $this->db->query("SELECT MAX(id_type) FROM type");
			$data = $req->fetch();
			$req->closeCursor();
			$type->setId_type($data[0] + 1);
		}
		catch (PDOException $e)
		{
			return 0;
		}
		try
		{
			$req = $this->db->prepare("INSERT INTO type VALUES(?, ?)");
			$req->execute($type->toArray());
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de supression d'un type en bdd (via id ou nom (unique))
	public function delType(int $id = null, String $nom = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("DELETE FROM type WHERE id_type = :i");
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
				$req = $this->db->prepare("DELETE FROM type WHERE type.nom = :n");
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

	//Méthode de modification d'un champ d'une entrée de notre table type
	public function setTypeField($id, String $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE type SET " . $champ . " = :n WHERE id_type = :i");
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

	//Fonctions d'acces aux champs (individuel) de nos types en base de donnée
	public function getTypeField($id, String $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM type WHERE id_type = :i");
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

	//Méthode de chargement d'un type en bdd
	public function loadType(int $id = null, String $nom = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM type WHERE id_type = :i");
				$req->bindValue(":i", $id);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return new Type($data);
		}
		else if (isset($nom))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM type WHERE type.nom = :n");
				$req->bindValue(":n", $nom);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return new Type($data);
		}
		return 0;
	}

	//Méthode retournant une  liste de nos types en bdd
	public function listTypes(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM type LIMIT 0, " . $nb);
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
				$req = $this->db->query("SELECT * FROM type");
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