<?php
//Classe gerant l'affichage
class AdminViewManager
{
	//Méthode génèrant l'affichage des tableaux de gestion des données de notre bdd (hors commandes), la methode travaille sur un array de liste des entrées de nos tables ainsi que la catégorie associée (utilisée via données get pour les eevenements de supression/modification)
	// /!\ chemins des images à remodifier en cas de modification de la hierarchie des fichiers
	/**
	*	@param array $data - tableau des listes d'entrees en bdd a afficher
	*	@param string $cat - nom de la categorie concernee par l'affichage
	*	@return int 1|0 - 1 si valeurs a afficher sinon 0
	*/
	public function showAdminPannel(array $data, string $cat)
	{
		if (is_array($data))
		{
			echo "<table><tr>";
			$keys = array_keys($data[0]);
			
			//Affichage de l'entête correspondant aux champs de nos tables, les noms sont reformatés pour un affichage plus convivial
			foreach ($keys as $key => $value) 
			{
				if ($value != "mdp")
				{
					echo "<th>" . preg_replace("#_#", " ", $value) . "</th>";
				}
			}
			echo "<th>modifier</th><th>supprimer</th></tr>";
			//Affichage de toutes les valeurs listées
			foreach ($data as $key => $value)
			{
				echo "<tr>";
				if (is_array($value))
				{
					foreach ($value as $key => $value2)
					{
						//Pour des raisons de sécurité nous n'affichons pas les mots de passe
						if ($key != "mdp")
						{
							if ($key == "prix")
							{
								$value2 .= " €";
							}
							echo "<td>" . $value2 . "</td>";
						}
					}
				}
				else
				{
					return 0;
				}
				//Affichage des liens de modification/supression transmissions de données get
				echo "<td><a href=\"admin.php?cat=" . $cat . "&setup=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"../img/icones/outil.png\" alt=\"icone d'outils\"/ width=\"20\" height=\"20\" title=\"modifier\"></a></td><td><a href=\"admin.php?cat=" . $cat . "&del=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"../img/icones/supprimer.png\" alt=\"icone de supression\"/ width=\"17\" height=\"17\" title=\"supprimer\"></a></td></tr>";
			}
			echo "</table>";
		}
		else
		{
			return 0;
		}
		return 1;
	}

	//Méthode d'affichage du panneau d'affichage des commandes, même principe de fonctionnement que la fonction d'affichage précédent mais sans argument catégorie
	/**
	*	@param array $data - tableau des listes d'entrees en bdd a afficher
	*	@return int 1|0 - 1 si valeurs a afficher sinon 0
	*/
	public function showAdminFullOrderPannel(array $data)
	{
		$cat = "commande";
		if (is_array($data))
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
							//Formattage de l'affichage des dirrérents produits, de leur quantité et de leur prix	
							foreach ($value2 as $key3 => $value3)
							{
								echo "<li>" . preg_replace("#/ (\d{1,}) / (\d{1,})#", "/ $1€ / x$2", implode(" / ", $value3)) . "</li>";
							}
							echo "</ul></td>";
						}
						else if ($key2 != "db")
						{
							if ($key2 == "prix")
							{
								$value2 .= " €";
							}
							echo "<td>" . $value2 . "</td>";
						}
					}
				}
				else
				{
					return 0;
				}
				echo "<td><a href=\"admin.php?cat=" . $cat . "&setup=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"../img/icones/outil.png\" alt=\"icone d'outils\"/ width=\"20\" height=\"20\" title=\"modifier\"></a></td><td><a href=\"admin.php?cat=" . $cat . "&del=" . $value["id_".$cat] . "\"><img src=\"../img/icones/supprimer.png\" alt=\"icone de supression\"/ width=\"17\" height=\"17\" title=\"supprimer\"></a></td><td><a href=\"admin.php?cat=" . $cat . "&validate=" . $value["id_".$cat] . "#" . $cat . "s\"><img src=\"../img/icones/validate.png\" alt=\"icone de validation\"/ width=\"17\" height=\"17\" title=\"valider\"></a></td></tr>";
			}
			echo "</table>";
		}
		else
		{
			return 0;
		}
		return 1;
	}

	//Méthode d'affichage des formulaire d'ajout d'un élément dans notre base de donnéee (non disponible pour les commandes)
	/**
	*	@param Manager $classMgr - classe manager associee a l'objet a ajouter (recuperation des attributs...)
	*	@param int $idC|null - id associe a la commande a definir en cas d'affichage de commandes
	*	@return void
	*/
	public function showAddItemPannel(Manager $classMgr, int $idC = null)
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
		//Si ajout d'un utilisateur, ajout d'une checkbox pour l'ajout d'admin ou non
		if (get_class($classMgr) == "UserManager")
		{
			echo "<label for=\"admin\">Admin</label><input type=\"checkbox\" name=\"admin\" id=\"admin\"/><br/>";
		}
		else if (get_class($classMgr) == "PurchaseManager")
		{
			echo "<input type=\"hidden\" name=\"id_commande\" value=\"" . $idC . "\"/>";
		}
		echo "<input type=\"submit\" value=\"Créer\">";
	}

	//Méthode d'afichage des formulaires de modification de nos éléments
	/**
	*	@param Manager $classMgr - classe manager associee a l'objet a modifier
	*	@param int $id|string - id associe a l'objet a modifier
	*	@return void
	*/
	public function showModifyItemPannel(Manager $classMgr, $id)
	{
		//Récupération de la fonction get"Class"Fiel en fonction de la classe passée en paramètre
		$func = "get" . preg_replace("#Manager$#", "", get_class($classMgr)) . "Field";
		//indicateur afin de ne pas ajouter de modification d'id dans le formulaire
		$i = 0;
		echo "<fieldset><legend>Modification d'un élément</legend><form method=\"POST\" action=\"adminTraitement.php?id=" . $id . "\"><input type=\"hidden\" name=\"obj\" value=\"" . get_class($classMgr) . "\"/><input type=\"hidden\" name=\"form\" value=\"setup\"/>";
		//Pour chaque champ définit dans la statique $CHAMPS de chaque classe manager, affichage du champ de modification déjà préremplit avec la valeur initiale sauf pour le mdp
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
					if ($value == "mdp")
					{
						echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><input type=\"password\" name=\"" . $value . "\" id=\"" . $value . "\"/><br/>";
					}
					else
					{
						echo "<label for=\"" . $value ."\">" . ucfirst($value) . " </label><input type=\"text\" name=\"" . $value . "\" id=\"" . $value . "\"/required value=\"" . $classMgr->$func((int) $id, $value) . "\"/><br/>";
					}
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

	//Méthode de modification d'une commande (classe FullOrder, permettant notamment de modifier les produits de la commande, la quantité...)
	/**
	*	@param OrderManager $ordMgr - manager associee a la commande a modifier
	*	@param PurchaseManager $purchaseManager - manager associe aux l'achats de la commande
	*	@param int|string $id - id de la commande a modifier
	*	@return void
	*/
	public function showModifyFullOrderPannel(OrderManager $ordMgr, PurchaseManager $purchaseMgr, $id)
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
						echo "<label for=\"" . $qttName ."\">Quantité </label><input type=\"text\" name=\"" . $qttName . "\" id=\"" . $qttName . "\"/required value=\"" . $purchaseMgr->$funcName((int) $id, $prdMgr->getProductIdFromName($value["nom"]), $value2) . "\"/><br/>";
					}
					else
					{
						echo "<label for=\"" . $value2 ."\">" . ucfirst($value2) . " </label><input type=\"text\" name=\"" . $value2 . "\" id=\"" . $value2 . "\"/required value=\"" . $purchaseMgr->$funcName((int) $id, $value2) . "\"/><br/>";
					}
				}
			}
		}
		echo "<input type=\"submit\" value=\"Modifier\">";
		$this->showAddButton("commande");
	}

	//Methode d'affichage du bouton d'ajout d'un élément
	/**
	*	@param string $cat - categorie associee au bouton
	*	@return void
	*/
	public function showAddButton(string $cat)
	{
		
		echo "<a href=\"admin.php?cat=" . $cat . "&add=1#" . $cat . "s\"><input type=\"button\" value=\"Ajouter\" id=\"add" . ucfirst($cat) . "\"/></a>";
	}

	//Méthode filtrant les messages de validation à afficher en fonction des valeurs transmises par $_GET et définies dans la fonction
	/**
	*	@param array $get - superglobale tableau $_GET
	*	@return void
	*/
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

	//Méthode filtrant les messages d'erreur à afficher en fonction des mêmes paramètres que la fonction précédente
	/**
	*	@param array $get - superglobale tableau $_GET
	*	@param bool $front|false - si vrai, pas d'affichage du message
	*	@return int 0|void - 0 si l'indice d'erreur choisi n'est pas present dans le tableau
	*/
	public function showErrorMessage(array $get, $front = false)
	{
		if (!$front)
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
		if (isset($get["uEMsg"]))
		{
			$tabMsg = explode(".", $get["uEMsg"]);
			foreach ($tabMsg as $key => $value) 
			{
				if ($value)
				{
					echo "<p><strong>." . $value . ".</strong></p>";
				}
			}
		}
	}

	//Méthode de sécurisation des chaines entrées via formulaire, retourne le tableau nettoyé des risques d'injections de code
	/**
	*	@param array $tab - superglobale tableau $_POST a securiser
	*	@return array $tab - tableau "echappe"
	*/
	public function &wash(array $tab)
	{
		$db = PDOFactory::getDb();
		foreach ($tab as $value)
		{
			$value = $db->quote($value);
		}
		return $tab;
	}

	//Méthode d'affichage générique des produits présent en base de donnée
	/**
	*	@param array $prds - tableau listant les produits d'une catégorie à afficher
	*	@param string $cat - catégorie des produits à afficher
	*	@return void
	*/
	public function showProducts(array $prds, string $cat)
	{
		echo '<div id="' . $cat . 'sP">';
		foreach ($prds as $value) 
		{
			//Conversion du nom de produit en id (retrait des majuscules, espaces et conversion des accents)
			$idName = strtolower($value['nom']);
			$idName = str_replace(' ', '', $idName);
			$idName = iconv('UTF-8', 'ASCII//TRANSLIT', $idName);
			//Affichage des blocs de produits présents en base de donnée ainsi que l'ajout d'une selection et d'un bouton pour commander
			echo '<div id="' . $idName . '" class="' . $cat . 'P"><h2>' . $value['nom'] . '</h2><p>' . $value['description'] . '</p><p>Prix: ' . $value['prix'] . '€</p><img src="../img/' . $cat .  's/' . $value['image'] . '" alt="' . $value['nom'] . '" title="' . $value['nom'] . '"/><label for="' . $idName . 'Q' . '">Quantité: </label><input type="number" class="prdIn" min="1" max="20" name="quantite" id="' . $idName . 'Q' . '"/></div>';
		}
		echo '</div>';
	}

	//Méthode d'affichage générique du contenu du panier
	/**
	*	@param array $basket - tableau listant les produits et quantités du panier
	*	@return void
	*/
	public function showBasket(array $basket)
	{
		$prdMgr = new ProductManager(PDOFactory::getDb());
		echo '<form method="POST" action=""><fieldset><legend>Commande</legend><ul>';
		foreach ($basket as $key => $val)
		{
			$idName = strtolower($key);
			$idName = str_replace(' ', '', $idName);
			$idP = $prdMgr->getProductIdFromName(ucfirst($key));
			$unitPrice = $prdMgr->getProductField($idP, "prix");
			echo '<li><a href="../webPages/panier.php?del=' . $key . '"><img src="../img/icones/supprimer.png" class="suprIcon" alt="icone de supression" title="supprimer"></a> ' . ucfirst($key) . ' <input type=number class="prdIn" name="' . $key . '" value="' . $val . '" min="1" max="20" id="' . $idName . '"/> <span id="' . $idName . 'S" class="tPrix">' . $unitPrice*$val . '</span>€</li><input type="hidden" id="' . $idName . 'H" value="' . $unitPrice . '"/>'; 
		}
		echo '</ul><p>Prix total : <span id="totalCde"></span> €</p><input type="submit" value="Valider"/></fieldset></form>';
	}

	//Méthode affichant un block (image/lien/description) par catégorie de produits différentes
	/**
	*	@param array $types - tableau listant les différents types
	*	@return void
	*/
	public function showTypesBoard(array $types)
	{
		$prdMgr = new ProductManager(PDOFactory::getDb());
		echo '<div id="carteM">';
		foreach ($types as $key => $value) 
		{
			$name = lcfirst($value['nom']);
			echo '<div id="cartemenu' . $name .'s" class="carteMenuP"><h2><a href="produits.php?cat=' . $name . '">Nos ' . $value['nom'] . 's</a></h2><img src="../img/' . $name . 's/' . $prdMgr->pickRdmImage($value['nom']) . '" alt="image de ' . $name . '" title="Pages des ' . $name . 's"/></div>';
		}
		echo '</div>';
	}
}