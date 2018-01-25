<?php
//Création de notre classe Admin (petit clin d'oeil aux systèmes UNIX au passage) utilisant notre trait UserTrait ainsi que les methodes et attributs de la classe UserManager => pseudo heritage multiple
//Pas de redéfinition de methode __construct ou hydrate car methodes du trait prioritaires sur celles de la classe mère
class SuperUser extends UserManager
{	
	use UserTrait;
}
