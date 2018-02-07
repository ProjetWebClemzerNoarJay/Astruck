<?php
//Classe manager gèrant les archivages / gestions avec les bases de données "log"/"traces" de modification, d'ajout ou suppression permettant de garder des données pour d'éventuelles études statistiques sur les ventes ect...

class Archiver extends Manager
{
	//Tableau des tables gérées par notre classe Archiver
	public static $TABLES = ["gestion_produit", "archive_commande", "gestion_planning", "gestion_type", "gestion_user"];

	//Méthode d'archivage d'une commande (objet full order contenant les détails de la commande) pouvant être utile pour retracer des soucis de commandes, ou établir des stats de vente à l'avenir (prds les plus vendus / en fonction des périodes...)
	/**
	*	@param FullOrder $ord - objet a serialiser et a archiver
	*	@return int 0|1 - 1 si success sinon 0
	*/
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
	/**
	*	@param mixed $obj - objet concernant la table d'archivage ou enregistrer la modification de l'objet associe en bdd
	*	@param int $idAdm - id de l'admin effectuant la modification
	*	@return int 0|1 - 1 si success sinon 0
	*/
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
	/**
	*	@param mixed $obj - objet concernant la table d'archivage ou mettre a jour la modification de l'objet associe en bdd
	*	@param int $idAdm - id de l'admin effectuant la modification
	*	@return int 0|1 - 1 si success sinon 0
	*/
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
			return 0;
		}
		return 1;
	}

	//Super fonction combinant les fonctions logs testant si l'insertion ne peut s'effectuer car déjà présente, la modifie sinon
	/**
	*	@param mixed $obj - objet concernant la table d'archivage ou mettre a jour la modification de l'objet associe en bdd
	*	@param int $idAdm - id de l'admin effectuant la modification
	*	@return void
	*/
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

	//Methode permettant de supprimer un log (par exemple en cas de retrait d'admin, les logs de cet admin seront d'abord supprimés pour que la contrainte de clef étrangère ne dérange pas la suppression)
	/**
	*	@param String $logType - suffixe de la table de gestion concernee
	*	@param int $idAdm - id de l'admin dont on veut supprimer les logs
	*	@return int 0|1 - 1 si success sinon 0
	*/
	public function delLog(String $logType, $idAdm)
	{
		$name = "gestion_" . $logType;
		try
		{
			$req = $this->db->prepare("DELETE FROM " . $name . " WHERE id_admin = :i");
			$req->bindValue(":i", $idAdm);
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de supression des logs affectés a un utilisateur
	/**
	*	@param int $idU - id de l'user dont on veut supprimer les logs
	*	@return int 0|1 - 1 si success sinon 0
	*/
	public function delUserLogs(int $idU)
	{
		try
		{
			$req = $this->db->prepare("DELETE FROM gestion_user WHERE id_user = :i");
			$req->bindValue(":i", $idU);
			$req->execute();
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de supression des logs en fonction du parametre String passé, supprime en fonction de l'id de l'item de la table en question
	/**
	*	@param String $log - nom de l'objet que l'on souhaite supprimer (associé à la table)
	*	@param int $id - id de l'objet dont on veut supprimer le log
	*	@return int 0|1 - 1 si success sinon 0
	*/
	public function delLogsCat(String $log, int $id)
	{
		$name = "gestion_" . $log;
		$crit = "id_" . $log;
		try
		{
			$req = $this->db->prepare("DELETE FROM " . $name . " WHERE :c = :i");
			$req->bindValue(":c", $crit);
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

	//Methode de suppression de tous les logs associées a un admin (pour la suppression) attention, les commandes validées par cet admin devront être revalidées par un autre admin.
	/**
	*	@param int $idAdm - id de l'admin dont on veut supprimer les logs de toutes les tables de gestion
	*	@return int 0|1 - 1 si success sinon 0
	*/
	public function delLogs($idAdm)
	{
		foreach (self::$TABLES as $key => $value) 
		{
			try
			{
				$req = $this->db->prepare("DELETE FROM " . $value . " WHERE id_admin = :i");
				$req->bindValue(":i", $idAdm);
				$req->execute();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		return 1;
	}
}