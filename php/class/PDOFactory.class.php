<?php
//Création d'une classe PDOFactory permettant de distribuer des objets PDO avec les mêmes acces renseignés a un seul endroit => pattern factory
class PDOFactory
{
	//Methode statique permettant de récuperer un objet pdo initialisé
	/**
	*	@param void
	*	@return PDO $db - objet de connexion a notre base de donnee
	*/
	public static function getDb()
	{
		try
		{
			$db = new PDO("mysql:host=localhost;dbname=Astruck;charset=utf8", "ahsyaj", "ttittaten7tretypolog");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
			die("Erreur PDO : " . $e->getMessage());
		}
		return $db;
	}
}