<?php
//Classe gèrant nos intéractions avec la bdd des admin
class AdminManager extends Manager
{
	public static $CHAMPS = ["id_admin", "id_user"];


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
			$req = $this->db->prepare("INSERT INTO admin VALUES(?, ?)");
			$req->execute($adm->toArray());
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

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

	public function setAdminField($id, String $champ, $new)
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
	public function getAdminField($id, String $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM admin WHERE id_admin = ?");
				$req->bindValue("?", (int) $id);
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

	public function listAdmin(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM admin LIMIT 0, " . $nb);
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
				$req = $this->db->query("SELECT * FROM admin");
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
			}
			catch (PDOException $e)
			{
				return 0;
			}
			
		}
		return $data;
	}

	public function getHydrateTabFromArg(int $id)
	{
		$tab = array();
		$tab["id_admin"] = 0;
		$tab["id_user"] = $id;
		return $tab;
	}
}
