<?php
//Classe manager gèrant les archivages / gestions avec les bases de données "log"/"traces" de modification, d'ajout ou suppression permettant de garder des données pour d'éventuelles études statistiques sur les ventes ect...

class Archiver extends Manager
{
	public function archiveOrder(FullOrder $ord, int $idAdm)
	{
		try
		{
			$req = $this->db->prepare("INSERT INTO archive_commande VALUES(NOW(), :o, :ia, :ic)");
			$req->bindValue(":o", serialize($ord));
			$req->bindValue(":ia", $idAdm);
			$req->bindValue(":ic", $ord->getId_commande());
			$req->execute();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Fonction enregistrant dans nos tables de gestion lors d'ajout ou de modification d'élément
	public function logUpdate($obj, int $idAdm)
	{
		switch (get_class($obj))
		{
			case "Planning":
				$name = "planning";
			break;
			case "Type":
				$name = "type";
			break;
			case "Product":
				$name = "produit";
			break;
			case "User":
				$name = "user";
			break;
		}
		$tblName = "gestion_" . $name;
		$method = "getId_" . $name;
		try
		{
			$req = $this->db->prepare("INSERT INTO " . $tblName . " VALUES(NOW(), :ia, :io)");
			$req->bindValue(":ia", $idAdm);
			$req->bindValue(":io", $obj->$method());
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Fonction de mise a jour de nos tables de gestion (date de modif et id_admin)
	public function updateLogUpdate($obj, int $idAdm)
	{
		switch (get_class($obj))
		{
			case "Planning":
				$name = "planning";
			break;
			case "Type":
				$name = "type";
			break;
			case "Product":
				$name = "produit";
			break;
			case "User":
				$name = "user";
			break;
		}
		$tblName = "gestion_" . $name;
		$dateName = "date_gestion_" . $name;
		$method = "getId_" . $name;
		$idName = "id_" . $name;
		try
		{
			$req = $this->db->prepare("UPDATE " . $tblName . " SET " . $dateName . " = NOW() WHERE id_admin = :ia AND " . $idName . " = :io");
			$req->bindValue(":ia", $idAdm);
			$req->bindValue(":io", $obj->$method());
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			die("Erreur :" . $e->getMessage());
			//return 0;
		}
		return 1;
	}

	//Super fonction combinant les fonctions logs testant si l'insertion ne peut s'effectuer car déjà présente, la modifie
	public function log($obj, int $idAdm)
	{
		try
		{
			$this->logUpdate($obj, $idAdm);
		}
		catch (PDOException $e)
		{
			$this->updateLogUpdate($obj, $idAdm);
		}
	}
}