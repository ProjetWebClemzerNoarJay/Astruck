<?php
//Manager de commandes
class PlanningManager extends Manager
{
	//Attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_planning", "jour", "latitude", "longitude"];
	//Définition d'un tableau représentant les jours de la semaine
	public static $WEEK = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

	//Méthode d'ajour d'un objet planning en bdd
	public function addPlanning(Planning $plg)
	{
		try
		{
			$req = $this->db->query("SELECT MAX(id_planning) FROM planning");
			$data = $req->fetch();
			$plg->setId_planning($data[0] + 1);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		try
		{
			$req = $this->db->prepare("INSERT INTO planning VALUES(?, ?, ?, ?)");
			$req->execute($plg->toArray());
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de supression d'un planning en bdd via son id
	public function delPlanning(int $id)
	{
		try
		{
			$req = $this->db->prepare("DELETE FROM planning WHERE id_planning = :i");
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

	//Méthode de modification d'un champ d'une entrée de notre table planning en fonction de son id
	public function setPlanningField($id = null, String $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE planning SET " . $champ . " = :n WHERE id_planning = :i");
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
	public function getPlanningField($id, String $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM planning WHERE id_planning = :i");
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

	//Méthode de chargement d'un array associatif d'hydratation pour instancier un objet Planning corréspondant à une entrée de notre bdd
	public function loadPlanning(int $id)
	{
		try
		{
			$req = $this->db->prepare("SELECT * FROM planning WHERE id_planning = :i");
			$req->bindValue(":i", $id);
			$req->execute();
			$data = $req->fetch();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return new Planning($data);

	}

	//Méthode permettant de retourner l'ensemble de nos entrées de notre table planning (modulable via le param optionnel) dans un tableau de tableaux
	public function listPlannings(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM planning LIMIT 0, " . $nb);
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
				$req = $this->db->query("SELECT * FROM planning");
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		return $data;
	}

	//Méthode retournant la lat et la lon pour un jour donné en paramètre
	public function returnLatLon(String $jour)
	{
		try
		{
			$req = $this->db->prepare("SELECT latitude, longitude FROM planning WHERE jour = :d");
			$req->bindValue(":d", $jour);
			$req->execute();
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $data;
	}

	//Méthode retournant la lat et la lon pour le jour courrant
	public function returnCurrLatLon()
	{
		$day = date('w');
		try
		{
			$req = $this->db->prepare("SELECT latitude, longitude FROM planning WHERE jour = :w");
			$req->bindValue(":w", self::$WEEK[$day]);
			$req->execute();
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $data;
	}

	//Méthode retournant la lat et la lon pour la semaine
	public function returnWeekLatLon()
	{
		try
		{
			$req = $this->db->prepare("SELECT latitude, longitude FROM planning WHERE jour IN ( ?, ?, ?, ?, ?, ?, ? )");
			$req->execute(self::$WEEK);
			$data = $req->fetchAll(PDO::FETCH_ASSOC);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $data;
	}
}
