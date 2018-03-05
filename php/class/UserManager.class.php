<?php
//Manager d'utilisateurs
class UserManager extends Manager
{
	//attribut statique constant correspondant aux champs de l'entité gérée en bdd
	public static $CHAMPS = ["id_user", "nom", "prenom", "email", "mdp", "tel"];

	//Fonctions d'ajout, de suppression et de modification d'utilisateurs dans notre table user
	/**
	*	@param User $user
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function addUser(User $user)
	{
		try
		{
			$req = $this->db->query("SELECT MAX(id_user) FROM user");
			$data = $req->fetch();
			$user->setId_user($data[0] + 1);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		try
		{
			$req = $this->db->prepare("INSERT INTO user VALUES(?, ?, ?, ?, ?, ?)");
			$user->setMdp($this->saltAndCrypt($user->getMdp()));
			$req->execute($user->toArray());
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return 1;
	}

	//Méthode de suppression d'un utilisateur dans notre bdd
	/**
	*	@param int $id|null - id de l'user à supprimer en bdd
	*	@param string $nom|null - nom de l'user à supprimer en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function delUser(int $id = null, string $email = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("DELETE FROM user WHERE id_user = :i");
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
		else if (isset($email))
		{
			try
			{
				$req = $this->db->prepare("DELETE FROM user WHERE user.email = :e");
				$req->bindValue(":e", $email);
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

	//Méthode de modification d'un champ d'utilisateur en bdd
	/**
	*	@param int $id - id de l'utilisateur à modifier en bdd (1ere partie clé primaire)
	*	@param string $champ - nom du champ à modifier en bdd
	*	@return int 1|0 - 1 si la requete s'est correctement executee sinon 0
	*/
	public function setUserField($id, string $champ, $new)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("UPDATE user SET " . $champ . " = :n WHERE user.id_user = :i");
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

	//Fonctions d'acces aux champs (individuel) d'utilisateur en base de donnée
	/**
	*	@param int $id - id de l'utilisateur à accéder en bdd
	*	@param string $champ - nom de l'utilisateur à accéder en bdd
	*	@return int|array 0|$answ[0] - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function getUserField($id, string $champ)
	{
		if (in_array($champ, self::$CHAMPS))
		{
			try
			{
				$req = $this->db->prepare("SELECT " . $champ . " FROM user WHERE user.id_user = :i");
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

	//Méthode de chargement d'un utilisateur via id ou email (unique)
	/**
	*	@param int $id|null - id de l'utilisateur à accéder en bdd
	*	@param string $email|null - email de l'utilisateur à accéder en bdd
	*	@return int|Type 0| - objet User initialisé avec le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function loadUser(int $id = null, string $email = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM user WHERE id_user = :i");
				$req->bindValue(":i", $id);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return new User($data);
		}
		else if (isset($email))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM user WHERE email = :e");
				$req->bindValue(":e", $email);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return new User($data);
		}
		return 0;
	}

	//Méthode retournant la liste de tous nos utilisateurs
	/**
	*	@param int $nb|null - nombre d'entrées à retrouner depuis la première en bdd
	*	@return int|array 0|$data - tableau contenant le resultat de la requette si la requete s'est correctement executee sinon 0
	*/
	public function listUsers(int $nb = null)
	{
		if (isset($nb))
		{
			try
			{
				$req = $this->db->query("SELECT * FROM user LIMIT 0, " . $nb);
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return $data;
		}
		else
		{
			try
			{
				$req = $this->db->query("SELECT * FROM user");
				$data = $req->fetchAll(PDO::FETCH_ASSOC);
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
			return $data;
		}
		return 0;
	}

	//Méthode de vérification si un user est admin ou non
	/**
	*	@param int $id|null - id de l'utilisateur concerné
	*	@param string $email|null - email de l'utilisateur concerné
	*	@return int 0|1 - si l'utilisateur est admin 1 sinon 0
	*/
	public function isAdmin($id = null, string  $email = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM admin INNER JOIN user ON admin.id_user = user.id_user WHERE user.id_user = :i");
				$req->bindValue(":i", (int) $id);
				$req->execute();
				$data = $req->fetch();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		else if (isset($email))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM admin INNER JOIN user ON admin.id_user = user.id_user WHERE user.email = :e");
				$req->bindValue(":e", $email);
				$data = $req->fetch();
				$req->execute();
				$req->closeCursor();
			}
			catch (PDOException $e)
			{
				return 0;
			}
		}
		if (isset($data[0]))
		{
			return 1;
		}
		return 0;
	}

	//Méthode de salage et de hashage des mots de passe utilisateurs (jamais stockées en clair pour la sécurité)
	/**
	*	@param string $mdp|null - mot de passe à crypter
	*	@param User $user|null - utilisateur dont on veut crypter le mot de passe
	*	@return string|int - mot de passe crypté ou 0 si aucun paramètre n'est passé
	*/
	public function saltAndCrypt(string $mdp = null, User $user = null)
	{
		if (!isset($mdp) && !isset($user))
		{
			return 0;
		}
		else if (isset($user))
		{
			$mdp = $user->getMdp();
		}
		$salted = preg_replace("#([aeiou])([fvtcd])#", "-$1_#'666$2&", $mdp);
		$salted = preg_replace("#([str])#i", ".$1&", $mdp);
		return hash("sha256", $salted);
	}

	//Méthode d'authentification d'un utilisateur via un tableau d'id (email/mdp)
	/**
	*	@param array $ids - couple d'identifiant et mot de passe
	*	@return int 0|$data["id_user"] - id de l'utilisateur si success sinon 0
	*/
	public function logIn(array $ids)
	{
		try
		{
			$req = $this->db->prepare("SELECT id_user FROM user WHERE email = :e AND mdp = :m");
			$req->bindValue(":e", $ids["email"]);
			$req->bindValue(":m", $this->saltAndCrypt($ids["mdp"]));
			$req->execute();
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		if (isset($data))
		{
			return $data["id_user"];
		}
		return 0;
	}

	//Méthode de vérification des champs d'un utilisateur retournant un message d'erreur associé aux erreurs éventuelles
	/**
	*	@param User $usr - utilisateur à checker
	*	@return int|array 0|$eMsg - tableau contenant la concaténation des messages d'erreur s'il y en a sinon 0
	*/
	public function validateUserFields(User $usr)
	{
		$eMsg = "";
		if (!preg_match("#^[a-zA-ZàáâäçèéêëìíîïñòóôöùúûüÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜ][a-zàáâäçèéêëìíîïñòóôöùúûü]+ ?[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü]? ?[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü]? ?[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü]?$#", $usr->getNom()))
		{
			$eMsg .= "Le champ nom est invalide. ";
		}
		if (!preg_match("#^[a-zA-ZàáâäçèéêëìíîïñòóôöùúûüÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜ][a-zàáâäçèéêëìíîïñòóôöùúûü]*-?[a-zàáâäçèéêëìíîïñòóôöùúûü]{2,}?$#", $usr->getPrenom()))
		{
			$eMsg .= "Le champ prenom est invalide. ";
		}
		if (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$#", $usr->getMdp()))
		{
			$eMsg.= "Le champ mot de passe est invalide (Au moins 1 majuscule / 1 chiffre / caractère spécial : \"-_+@%$@!\" / 8 caractères mini). ";
		}
		if (!preg_match("#^[^\W][.a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$#", $usr->getEmail()))
		{
			$eMsg .= "Le champ email est invalide. ";
		}
		if (!preg_match("#^0[1-9]\d{8}$#", $usr->getTel()))
		{
			$eMsg .= "Le champ téléphone est invalide. ";
		}
		if (strlen($eMsg) == 0)
		{
			return 0;
		}
		else
		{
			return $eMsg;
		}
	}

	//Idem au dessus mais pour 1 seul champ
	/**
	*	@param User $usr - utilisateur à checker
	*	@param string $field - le champ à checker
	*	@return int|array 0|$eMsg - tableau contenant la concaténation des messages d'erreur s'il y en a sinon 0
	*/
	public function validateUserField(User $usr, string $field)
	{
		$eMsg = "";
		switch ($field)
		{
			case "nom":
				if (!preg_match("#^[a-zA-ZàáâäçèéêëìíîïñòóôöùúûüÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜ][a-zàáâäçèéêëìíîïñòóôöùúûü]+ ?[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü]? ?[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü]? ?[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü]?$#", $usr->getNom()))
				{
					$eMsg .= "Le champ nom est invalide. ";
				}
				break;
			case "prenom":
				if (!preg_match("#^[a-zA-ZàáâäçèéêëìíîïñòóôöùúûüÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜ][a-zàáâäçèéêëìíîïñòóôöùúûü]*-?[a-zàáâäçèéêëìíîïñòóôöùúûü]{2,}?$#", $usr->getPrenom()))
				{
					$eMsg .= "Le champ prenom est invalide. ";
				}
				break;
			case "email":
				if (!preg_match("#^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$#", $usr->getEmail()))
				{
					$eMsg .= "Le champ email est invaide. ";
				}
				break;
			case "mdp":
				if (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$#", $usr->getMdp()))
				{
					$eMsg.= "Le champ mot de passe est invalide (Au moins 1 majuscule / 1 chiffre / 1 caractère spécial : \"-_+@\" / 8 caractères mini). ";
				}
				break;
			case "tel":
				if (!preg_match("#^0[1-9]\d{8}$#", $usr->getTel()))
				{
					$eMsg .= "Le champ téléphone est invalide. ";
				}
				break;
		}		
		if (strlen($eMsg) == 0)
		{
			return 0;
		}
		else
		{
			return $eMsg;
		}
	}
}
