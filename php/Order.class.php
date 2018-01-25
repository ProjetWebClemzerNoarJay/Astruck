<?php
//Création de la classe modèlisant nos commandes utilisant le trait OrderTrait (utilisé pour palier au problème de multiple heritage avec la classe FullOrder)
class Order
{
	use OrderTrait;
}