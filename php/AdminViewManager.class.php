<?php
//Classe gerant l'affichage
class adminViewManager
{
	public function showAdminPannel($data, String $cat)
	{
		if (count($data))
		{
			echo "<table><tr>";
			$keys = array_keys($data[0]);
			
			foreach ($keys as $key => $value) 
			{
				if ($value != "mdp")
				{
					echo "<th>" . preg_replace("#_#", " ", $value) . "</th>";
				}
			}
			echo "<th>modifier</th><th>supprimer</th></tr>";
			foreach ($data as $key => $value)
			{
				echo "<tr>";
				if (is_array($value))
				{
					foreach ($value as $key => $value2)
					{
						if ($key != "mdp")
						{
							echo "<td>" . $value2 . "</td>";
						}
					}
				}
				else
				{
					return 0;
				}
				echo "<td><a href=\"admin.php?cat=" . $cat . "&setup=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"img/icones/outil.png\" alt=\"icone d'outils\"/ width=\"20\" height=\"20\" title=\"modifier\"></a></td><td><a href=\"admin.php?cat=" . $cat . "&del=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"img/icones/supprimer.png\" alt=\"icone de supression\"/ width=\"17\" height=\"17\" title=\"supprimer\"></a></td></tr>";
			}
			echo "</table>";
		}
		else
		{
			return 0;
		}
		return 1;
	}

	public function showAdminFullOrderPannel($data, String $cat)
	{
		if (count($data))
		{
			echo "<table><tr>";
			$keys = array_keys($data[0]);
			
			foreach ($keys as $key => $value) 
			{
				if ($value != "db")
				{
					echo "<th>" . preg_replace("#_#", " ", $value) . "</th>";
				}
			}
			echo "<th>modifier</th><th>supprimer</th><th>valider</th></tr>";
			foreach ($data as $key => $value)
			{
				echo "<tr>";
				if (is_array($value))
				{
					foreach ($value as $key2 => $value2)
					{
						if (is_array($value2))
						{
							echo "<td><ul>";
							foreach ($value2 as $key3 => $value3)
							{
								echo "<li>" . preg_replace("#/ (\d{1,}) / (\d{1,})#", "/ $1€ / x$2", implode(" / ", $value3)) . "</li>";
							}
							echo "</ul></td>";
						}
						else if ($key2 != "db")
						{
							echo "<td>" . $value2 . "</td>";
						}
					}
				}
				else
				{
					return 0;
				}
				echo "<td><a href=\"admin.php?cat=" . $cat . "&setup=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"img/icones/outil.png\" alt=\"icone d'outils\"/ width=\"20\" height=\"20\" title=\"modifier\"></a></td><td><a href=\"admin.php?cat=" . $cat . "&del=" . $value["id_".$cat] . "\"><img src=\"img/icones/supprimer.png\" alt=\"icone de supression\"/ width=\"17\" height=\"17\" title=\"supprimer\"></a></td><td><a href=\"admin.php?cat=" . $cat . "&validate=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"img/icones/validate.png\" alt=\"icone de validation\"/ width=\"17\" height=\"17\" title=\"valider\"></a></td></tr>";
			}
			echo "</table>";
		}
		else
		{
			return 0;
		}
		return 1;
	}

	public function showAddItemPannel($classMgr)
	{
		$i = 0;
		echo "<fieldset><legend>Ajout d'un élément</legend><form method=\"POST\" action=\"adminTraitement.php\"><input type=\"hidden\" name=\"obj\" value=\"" . get_class($classMgr) . "\"/><input type=\"hidden\" name=\"form\" value=\"add\"/>";
		foreach ($classMgr::$CHAMPS as $key => $value) 
		{
			if ($i)
			{
				if ($value == "description")
				{
					echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><textarea name=\"" . $value . "\" id=\"" . $value . "\"/required></textarea><br/>";
				}
				else
				{
					$type = "text";
					if ($value == "mdp")
					{
						$type = "password";
					}
					echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><input type=\"" . $type . "\" name=\"" . $value . "\" id=\"" . $value . "\"/required><br/>";
				}
			}
			$i++;
		}
		if (get_class($classMgr) == "UserManager")
		{
			echo "<label for=\"admin\">Admin</label><input type=\"checkbox\" name=\"admin\" id=\"admin\"/><br/>";
		}
		echo "<input type=\"submit\" value=\"Créer\">";
	}

	public function showModifyItemPannel($classMgr, $id)
	{
		$func = "get" . preg_replace("#Manager$#", "", get_class($classMgr)) . "Field";
		$i = 0;
		echo "<fieldset><legend>Modification d'un élément</legend><form method=\"POST\" action=\"adminTraitement.php?id=" . $id . "\"><input type=\"hidden\" name=\"obj\" value=\"" . get_class($classMgr) . "\"/><input type=\"hidden\" name=\"form\" value=\"setup\"/>";
		foreach ($classMgr::$CHAMPS as $key => $value) 
		{
			if ($i)
			{
				if ($value == "description")
				{
					echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><textarea name=\"" . $value . "\" id=\"" . $value . "\"/required>" . $classMgr->$func((int) $id, $value) . "</textarea><br/>";
				}
				else
				{
					$type = "text";
					if ($value == "mdp")
					{
						$type = "password";
					}
					echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><input type=\"" . $type . "\" name=\"" . $value . "\" id=\"" . $value . "\"/required value=\"" . $classMgr->$func((int) $id, $value) . "\"/><br/>";
				}
			}
			$i++;
		}
		if (get_class($classMgr) == "UserManager")
		{
			$val = "";
			if ($classMgr->isAdmin($id))
			{
				$val = "checked";
			}
			echo "<label for=\"admin\">Admin</label><input type=\"checkbox\" name=\"admin\" id=\"admin\" value=\"1\" " . $val . "/><br/>";
		}
		echo "<input type=\"submit\" value=\"Modifier\">";
	}

	public function showModifyFullOrderPannel($ordMgr, $purchaseMgr, $id)
	{
		try
		{
			$fOrder = new FullOrder($id, $ordMgr->getDb());
			$prdMgr = new ProductManager($ordMgr->getDb());
		}
		catch (Exception $e)
		{
			return 0;
		}
		$arrayFO = $fOrder->toArray(1);
		//Utilisation d'une closure/fonction anonyme pour la simplicité et non redondance de code
		$func = function($mgr)
		{
			return "get" . preg_replace("#Manager$#", "", get_class($mgr)) . "Field";
		};
		$i = 0;
		echo "<fieldset><legend>Modification d'un élément</legend><form method=\"POST\" action=\"adminTraitement.php?id=" . $id . "\"><input type=\"hidden\" name=\"obj\" value=\"FullOrder\"/><input type=\"hidden\" name=\"form\" value=\"setup\"/>";
		$funcName = $func($ordMgr);
		foreach ($ordMgr::$CHAMPS as $key => $value) 
		{
			if ($i)
			{
				echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><input type=\"text\" name=\"" . $value . "\" id=\"" . $value . "\"/required value=\"" . $ordMgr->$funcName((int) $id, $value) . "\"/><br/>";
			}
			$i++;
		}
		$funcName = $func($purchaseMgr);
		foreach ($arrayFO["liste_produit"] as $key => $value)
		{
			$qttName = "quantite " . ($key+1);
			$prdName = "produit " . ($key+1);
			echo "<strong>" . $prdName . "</strong><br/>";
			foreach ($purchaseMgr::$CHAMPS as $key2 => $value2)
			{
				if ($value2 != "id_commande")
				{
					if ($value2 == "id_produit")
					{
						echo "<label for=\"" . $prdName ."\">Nom </label><input type=\"text\" name=\"" . $prdName . "\" id=\"" . $prdName . "\"/required value=\"" . $value["nom"] . "\"/><input type=\"hidden\" name=\"pastId_" . ($key+1) . "\" value=\"" . $prdMgr->getProductIdFromName($value["nom"]) . "\"><br/>";
					}
					else if ($value2 == "quantite")
					{
						echo "<label for=\"" . $qttName ."\">Quantité </label><input type=\"text\" name=\"" . $qttName . "\" id=\"" . $qttName . "\"/required value=\"" . $purchaseMgr->$funcName((int) $id, $value2) . "\"/><br/>";
					}
					else
					{
						echo "<label for=\"" . $value2 ."\">" . ucfirst($value2) . " </label><input type=\"text\" name=\"" . $value2 . "\" id=\"" . $value2 . "\"/required value=\"" . $purchaseMgr->$funcName((int) $id, $value2) . "\"/><br/>";
					}
				}
			}
		}
		echo "<input type=\"submit\" value=\"Modifier\">";
	}

	public function showAddButton(String $cat)
	{
		
		echo "<a href=\"admin.php?cat=" . $cat . "&add=1#" . $cat . "s\"><input type=\"button\" value=\"Ajouter\" id=\"add" . ucfirst($cat) . "\"/></a>";
	}

	public function showValidateMessage(array $get)
	{
		if (isset($get["added"]))
		{
			echo "<p><strong>L'item a bien été ajouté.</strong></p>";
		}
		else if (isset($get["setted"]))
		{
			echo "<p><strong>L'item a bien été modifié.</strong></p>";
		}
		else if (isset($get["deleted"]))
		{
			echo "<p><strong>L'item a bien été supprimé.</strong></p>";
		}
		else if (isset($get["validated"]))
		{
			echo "<p><strong>La commande a bien été validée, elle est archivée.</strong></p>";
		}
	}

	public function showErrorMessage(array $get)
	{
		if (isset($get["errorAdd"]))
		{
			$bMsg = "l'ajout";
		}
		else if (isset($get["errorSetup"]))
		{
			$bMsg = "la modification";
		}
		else if (isset($get["errorDel"]))
		{
			$bMsg = "la suppression";
		}
		else if (isset($get["errorValidate"]))
		{
			$bMsg = "la validation de la commande";
		}
		else
		{
			return 0;
		}
		echo "<p><strong>Il y a eu une erreur avec " . $bMsg . ", verifiez les valeurs entrées / dépendances des tables.</strong></p>";
	}
}