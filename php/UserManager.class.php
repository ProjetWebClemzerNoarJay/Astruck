<?php
//Manager d'utilisateurs
class UserManager extends Manager
{

	public static $CHAMPS = ["id_user", "nom", "prenom", "email", "mdp", "tel"];

	//Fonctions d'ajout, de suppression et de modification d'utilisateurs dans notre table user
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

	public function delUser(int $id = null, String $email = null)
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

	public function setUserField($id, String $champ, $new)
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
	public function getUserField($id, String $champ)
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

	public function loadUser(int $id = null, String $email = null)
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

	public function isAdmin(int $id = null, String  $email = null)
	{
		if (isset($id))
		{
			try
			{
				$req = $this->db->prepare("SELECT * FROM admin INNER JOIN user ON admin.id_user = user.id_user WHERE user.id_user = :i");
				$req->bindValue(":i", $id);
				$data = $req->fetch();
				$req->closeCursor();
				$req->execute();
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
				$req->closeCursor();
				$req->execute();
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

	public function saltAndCrypt(String $mdp = null, User $user = null)
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

	public function logIn(Array $ids)
	{
		try
		{
			$req = $this->db->prepare("SELECT * FROM user WHERE email = :e AND mdp = :m");
			$req->bindValue(":e", $ids["email"]);
			$req->bindValue(":m", $this->saltAndCrypt($ids["mdp"]));
			$data = $req->fetch();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		if (isset($data))
		{
			return 1;
		}
		return 0;
	}
}
