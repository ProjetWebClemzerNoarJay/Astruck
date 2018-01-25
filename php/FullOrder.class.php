<?php

//Création d'une classe intermédiaire à Order et Purchase afin d'avoir des objets plus maléables pour l'affichage admin (prix total definit en tant qu'attribut, liste de la commande...) c'est cette classe que nous garderons en archive dans la table archive_commande sous forme d'objets sérializés
class FullOrder extends OrderManager
{
	use OrderTrait;

	static $champs = [];
	
	protected $liste_produit;

	//Methodes d'initialisation (constructeur et hydratation)
	public function __construct(int $id, PDO $obj)
	{
		$this->id_commande = $id;
		$this->db = $obj;
		foreach (self::$CHAMPS as $value)
		{
			$this->$value = $this->getOrderField($id, $value);
		}
		$this->formatDateTime();
		$this->liste_produit = $this->queryListe_produit();
		$this->prix = $this->calculatePrix();
	}

	//Getters
	public function getListe_produit()
	{
		return $this->liste_produit;
	}

	//Setters
	public function setListe_produit(Array $list)
	{
		$this->liste_produit = $list;
	}

	//Fonction récupérant la liste de produits afféctés a une commande
	public function queryListe_produit()
	{
		try
		{
			$req = $this->db->query("SELECT produit.nom, produit.prix, achat.quantite FROM produit INNER JOIN achat ON produit.id_produit = achat.id_produit INNER JOIN commande ON achat.id_commande = commande.id_commande WHERE achat.id_commande = " . $this->id_commande);
			$data = $req->fetchAll(PDO::FETCH_ASSOC);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			return 0;
		}
		return $data;
	}

	public function calculatePrix()
	{
		$price = 0;
		if (isset($this->liste_produit[0]))
		{
			foreach ($this->liste_produit as $key => $value) 
			{
				$price += (int) ($value["prix"]*$value["quantite"]);
			}
		}
		return $price;
	}

	//Fonction permettant de retourner un tableau des valeurs des attributs de notre objet, modification de l'ordre d'affichage avec array_shift pour avoir le champ id en premier
	public function toArray(bool $assoc = false)
	{
		$objArray = array();
		if ($assoc)
		{
			foreach ($this as $attr => $value)
			{
				$objArray[$attr] = $value;
			}
		}
		else
		{
			foreach ($this as $attr => $value)
			{
				$objArray[] = $value;
			}
		}
		$objArray["liste_produit"] = array_shift($objArray);
		return $objArray;
	}

	//Fonction modifiant les attributs date et heure pour les passer en format "français"/plus agréable à la lecture
	public function formatDateTime()
	{
		$this->date_commande = preg_replace("#(\d{4})-(\d{2})-(\d{2})#", "$3/$2/$1", $this->date_commande);
		$this->heure_commande = preg_replace("#(\d{2}):(\d{2}):(\d{2})#", "$1h$2", $this->heure_commande);
	}

	//Modification des valeurs récupérées lors de la sérialisation (objet pdo)
	public function __sleep()
	{
		foreach ($this as $attr => $value)
		{
			if ($attr != "db")
			{
				$save[] = $attr;
			}
		}
		return $save;
	}

	//Récupération de l'objet PDO /!\ Penser à le modifier également ou penser a une variable globale
	public function __wakeup()
	{
		$this->db = new PDO("mysql:host=localhost;dbname=Astruck;charset=utf8", "ahsyaj", "ttittaten7tretypolog");
	}
}
