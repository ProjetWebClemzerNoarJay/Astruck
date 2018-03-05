
//Variables pour les animation de la page evenements
//Variables contenant l'adresse lors des jours spéciaux (evenements) à modifier directement par le client
var stVal = "Avenue de Bréquigny, 35200 Rennes.";
var avril = "Mail de Bourgchevreuil, 35510 Cesson Sévigné.";
var paques = "Rue de Fougères, 35700 Rennes.";
var ftMusique = "Rue du Thabor, 35000 Rennes.";
var halloween = "Boulevard de la Liberté, 35000 Rennes.";
var noel = "Mail François Mitterand, 35000 Rennes.";
//Definition d'un tableau associatif contenant le message des burgers spéciaux et du planning (clé = id fete / valeur = texte de description du burger)
var baseMsg = "Retrouvez nous ";
var msgFete = new Array();
msgFete[0] = new Array();
msgFete[0]["stVal"] = "Délicieux burger accompagné de pommes de terre sautées le tout en forme de coeur à partager avec sa moitié.";
msgFete[0]["avril"] = "Burger au saumon snacké sauce aneth et ses crudités, et ce n'est pas une blague ! ";
msgFete[0]["paques"] = "Le fameux ice-cream-burger, un bun surcré et doré fourré de crème glacé vanille avec coulis chocolat.";
msgFete[0]["ftMusique"] = "Le pack fête de la musique, un délicieux maxi burger au bacon accompagné de ses frites et de sa bière.";
msgFete[0]["halloween"] = "Le zombie-burger, allez vous oser ?!";
msgFete[0]["noel"] = "Pour les fins gourmets, un burger au foie gras entier avec sa sauce morilles et ses pommes de terre sautées.";
msgFete[1] = new Array();
msgFete[1]["stVal"] = baseMsg + stVal;
msgFete[1]["avril"] = baseMsg + avril;
msgFete[1]["paques"] = baseMsg + paques;
msgFete[1]["ftMusique"] = baseMsg + ftMusique;
msgFete[1]["halloween"] = baseMsg + halloween;
msgFete[1]["noel"] = baseMsg + noel;

//Definition des variables/element du DOM
var title = $("#titlePos");
var map = $("#map");
var bandeau = $("#bandeau");
var carte = $("#carte");
var menu = $("#menus");
var hamburgers = $("#hamburgers");
var boissons = $("#boissons");
var desserts = $("#desserts");
var aElt = $('#endroit a');
var aElt2 = $('#nomFete li a');
var info = $("#infoMap");
var infoFete= $("#infoFete");
var titlePlanning = $("#planning h2");
var planning = $('#planning');
var scrElt = document.createElement("script");
scrElt.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCUjev5WWflA08R29EtDteK4UACGZ5x9Xk&callback=initInfoMap";
scrElt.async = "on";
scrElt.defer = "on";
var adresse;

/*Variables d'éléments crées et ajoutés dynamiquement en fontion des evenements*/
var elt = document.createElement("p");
var elt2 = document.createElement("p");
var elt3 = document.createElement("p");
var elt4 = document.createElement("p");
var h2Elt = document.createElement("h2");
var h2Elt2 = document.createElement("h2");
var img = document.createElement("img");
/*Variables de position de la map 2*/
var latInfo;
var lngInfo;

//Récupération du jour courrant
var date = new Date();
var day = date.getDay();

//On verifie pour les coordonnées d'affichage de la carte qu'il s'agit bien d'un jour ouvré et récupère la position courrante
//Affichage de la carte par defaut, supression des éléments si samedi ou dimanche
elt.id = "pInfoCarte";
if (day != 0 && day != 6 && typeof(pos) !== 'undefined')
{
	var open = true;
	var lat = Number(pos["latitude"]);
	var lng = Number(pos["longitude"]);
	//Récupération de l'adresse en fonction de la lat et lng via api google maps et ajout à notre elt
	ajaxGet("https://maps.googleapis.com/maps/api/geocode/json?&latlng=" + lat + "," + lng + "&key=AIzaSyCauZ_bhI-nz6vJdf2fS7skFOMCwGkkw_o", createAddress1);
}
else if (typeof(pos) === 'undefined') 
{
	elt.append("Désolé, nous rencontrons un problème technique. Merci de vous référer à nos horaires rubrique \"Nous Trouver\"");
	map.remove();
}
else
{
	elt.append("Désolé, nous ne sommes pas ouvert aujourd'hui. Merci de vous référer à nos horaires rubrique \"Nous Trouver\"");
	map.remove();
}
bandeau.append(elt);

//Ajout des différents évènements avec quelques modification pour les terminaux mobiles (apparition au click, au lieu du hover peu pratique)
//Test confitionnel permettant de definir si le device est un mobile ou autre, pas de menu dérouant sur mobile, navigation via les liens de la page carte
if (navigator.userAgent.match(/(android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook)/gi))
{
	//Suite des evenements hover/nohover
	bandeau.click(hide_arrow);

	//Ajout de l'évenement d'apparition de la map avec la pos du marqueur en fonction du jour + elt p contenant l'adresse complète
	aElt.click(show_infoMap);
	
	aElt2.click(show_infoFete);
}
else
{
	//Ajout des evenements hover/nohover (menu déroulants/badeau/pages nous trouver et evenements)
	carte.mouseover(scroll_menu);
	carte.mouseout(hide_menu);

	bandeau.mouseover(hide_arrow);
	bandeau.mouseout(show_arrow);

	//Ajout de l'évenement d'apparition de la map avec la pos du marqueur en fonction du jour + elt p contenant l'adresse complète
	aElt.mouseover(show_infoMap);
	aElt.mouseout(hide_infoMap);

	aElt2.mouseover(show_infoFete);
	aElt2.mouseout(hide_infoFete);
}

//Definition des fonctions
//Fonction d'initialisation des cartes
function initMap() 
{
    var uluru = {lat: lat, lng: lng};
	var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 10,
	center: uluru
	});
	var marker = new google.maps.Marker({
    position: uluru,
    map: map
	});
}

function initInfoMap() 
{
    var uluru = {lat: latInfo, lng: lngInfo};
	var map = new google.maps.Map(document.getElementById('map2'), {
	zoom: 10,
	center: uluru
	});
	var marker = new google.maps.Marker({
    position: uluru,
    map: map
	});
}

//Fonction de requête ajax apellant une fonction de callback (ici pour récup les infos map de l'api google maps)
function ajaxGet(url, callback)
{
	var req = new XMLHttpRequest;
	req.open("GET", url);
	req.addEventListener("load", function()
	{
		if (req.status >= 200 && req.status < 400)
		{
			callback(req.responseText);
		}
		else
		{
			console.error(req.status + " : " + req.statusText + url);
		}
	});
	req.addEventListener("error", function()
	{
		console.error("Erreur reseau avec l'URL : " + url);
	});
	req.send(null);
}

//Récuperation de l'adresse format JSON au format String et ajout à l'élément p
function createAddress1(reponse)
{
	elt.textContent = JSON.parse(reponse).results[0]["formatted_address"];
}

function createAddress2(reponse)
{
	elt2.textContent = JSON.parse(reponse).results[0]["formatted_address"];
}

//Fonction affichant le sous menu du menu principal au survol
function scroll_menu()
{
	var elts = document.querySelectorAll("#carte a");
	for (var i = 1; i < elts.length; i++)
	{
	elts[i].style.display = "block";
		elts[i].style.animation = "fadein 0.6s 0s linear 1";

	}
}

//Fonction cachant les sous menus du menu principal lors du survol d'une autre zone
function hide_menu()
{
	var elts = document.querySelectorAll("#carte a");
	for (var i = 1; i < elts.length; i++)
	{
		elts[i].style.display = "none";
	}
}

//Fonction d'affichage et de masquage de la fleche d'indication du bandeau
function hide_arrow()
{
	var arrow = $("#fleche");
	arrow.css("visibility", "hidden");
}

function show_arrow()
{
	var arrow = $("#fleche");
	arrow.css("visibility", "visible");
}

//Fonction d'affichage et de masquage de l'infoMap de la page nous trouver
function show_infoMap(e)
{
	info.css("animation", "fadein 1s 0s linear 1");
	latInfo = Number(week[e.target.id]["latitude"]);
	lngInfo = Number(week[e.target.id]["longitude"]);
	initInfoMap();
	ajaxGet("https://maps.googleapis.com/maps/api/geocode/json?&latlng=" + latInfo + "," + lngInfo + "&key=AIzaSyCauZ_bhI-nz6vJdf2fS7skFOMCwGkkw_o", createAddress2);
	info.append(elt2);
	h2Elt.textContent = "Position";
	info.prepend(h2Elt);
}

function hide_infoMap()
{
	info.css("animation", "none");
}

//Fonction d'affichage et de masquage des informations liés aux evenements spéciaux (fetes)
function show_infoFete(e)
{
	infoFete.css("animation", "fadein 1s 0s linear 1");
	elt3.textContent = msgFete[0][e.target.id];
	elt4.textContent = msgFete[1][e.target.id];
	elt4.style.marginBottom = "20px";
	elt4.style.animation = "fadein 1s 0s linear 1";
	h2Elt2.textContent = "Burger spécial";
	titlePlanning.after(elt4);
	infoFete.prepend(h2Elt2);
	img.src = "../img/fete/burger" + e.target.id + ".jpg";
	img.alt = "image du burger de " + e.target.id;
	infoFete.append(img);
	infoFete.append(elt3);
}

function hide_infoFete()
{
	infoFete.css("animation", "none");
}
