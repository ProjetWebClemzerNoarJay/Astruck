
//Definition d'un planning de positions en fonction du jour de la semaine, à renseigner par le client pour le mettre a jour. La position du bandeau se mettra à jour automatiquement selon le jour
var pos = new Array();
//A partir de l'indice 1, chaque case du tableau représente un jour de la semaine (L - V) auquel il suffit d'entrer les coordonnées latitute et longitude de l'endroit où placer le marqueur sur la carte
pos[1] = new Array(48.108020, -1.690978);
pos[2] = new Array(48.129878, -1.631405);
pos[3] = new Array(48.047597, -1.602005);
pos[4] = new Array(48.093407, -1.634320);
pos[5] = new Array(48.131091, -1.674463);

//Definition des variables
var title = $("#titlePos");
var map = $("#map");
var bandeau = $("#bandeau");
var carte = $("#carte");
var menu = $("#menus");
var hamburgers = $("#hamburgers");
var boissons = $("#boissons");
var desserts = $("#desserts");
var aElt = $('#endroit li a');
var info = $("#infoMap");
var scrElt = document.createElement("script");
scrElt.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCUjev5WWflA08R29EtDteK4UACGZ5x9Xk&callback=initInfoMap";
scrElt.async = "on";
scrElt.defer = "on";

var adresse;
var elt;
var elt2;
var h2Elt = document.createElement("h2");
var latInfo;
var lngInfo;

//Récupération du jour courrant
var date = new Date();
var day = date.getDay();

//On verifie pour les coordonnées d'affichage de la carte qu'il s'agit bien d'un jour ouvré et on les récupère dans les variables associées
//Affichage de la carte par defaut, supression des éléments si samedi ou dimanche
elt = document.createElement("p");
elt.id = "pInfoCarte";

if (day != 0 && day != 6)
{
	var open = true;
	var lat = pos[day][0];
	var lng = pos[day][1];
	//Récupération de l'adresse en fonction de la lat et lng via api google maps et ajout à notre elt
	ajaxGet("https://maps.googleapis.com/maps/api/geocode/json?&latlng=" + lat + "," + lng + "&key=AIzaSyCauZ_bhI-nz6vJdf2fS7skFOMCwGkkw_o", createAddress1);
}
else
{
	elt.append("Désolé, nous ne sommes pas ouvert aujourd'hui. Merci de vous référer à nos horaires rubrique \"Nous Trouver\"");
	map.remove();
}
bandeau.append(elt);

//Ajout des evenements hover/nohover
carte.mouseover(scroll_menu);
carte.mouseout(hide_menu);
bandeau.mouseover(hide_arrow);
bandeau.mouseout(show_arrow);

//Ajout de l'évenement d'apparition de la map avec la pos du marqueur en fonction du jour + elt p contenant l'adresse complète
elt2 = document.createElement("p");
aElt.mouseover(show_infoMap);
aElt.mouseout(hide_infoMap);


//Definition des fonctions
//Fonction d'initialisation de la carte
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

//Fonction cachant et affichant la fleche d'indication du bandeau
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

function show_infoMap(e)
{
	info.css("animation", "fadein 1s 0s linear 1");
	latInfo = pos[e.target.id][0];
	lngInfo = pos[e.target.id][1];
	initInfoMap();
	ajaxGet("https://maps.googleapis.com/maps/api/geocode/json?&latlng=" + latInfo + "," + lngInfo + "&key=AIzaSyCauZ_bhI-nz6vJdf2fS7skFOMCwGkkw_o", createAddress2);
	info.append(elt2);
	h2Elt.textContent = "Position"
	info.prepend(h2Elt);
}

function hide_infoMap()
{
	info.css("animation", "none");
}

