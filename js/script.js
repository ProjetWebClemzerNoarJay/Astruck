//Definition des variables de position pour la carte + adresse, facilement éditable.

//Definition d'un planning de positions en fonction du jour de la semaine, à renseigner par le client pour le mettre a jour. La position du bandeau se mettra à jour automatiquement selon le jour
var pos = new Array();
pos[0] = new Array(48.049518, -1.743215);
pos[1] = new Array(48.108020, -1.690978);
pos[2] = new Array(48.129878, -1.631405);
pos[3] = new Array(48.047597, -1.602005);
pos[4] = new Array(48.093407, -1.634320);
pos[5] = new Array(48.131091, -1.674463);
pos[6] = new Array(48.151844, -1.685857);

var date = new Date();
var day = date.getDay();

var lat = pos[day][0];
var lng = pos[day][1];

//Definition des variables
var title = $("#titlePos");
var map = $("#map");
var bandeau = $("#bandeau");
var carte = $("#carte");
var menu = $("#menus");
var hamburgers = $("#hamburgers");
var boissons = $("#boissons");
var desserts = $("#desserts");
var adresse;
var pElt;


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
function createAddress(reponse)
{
	pElt.textContent = JSON.parse(reponse).results[0]["formatted_address"];
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

//Récupération de l'adresse en fonction de la lat et lng via api google maps
ajaxGet("https://maps.googleapis.com/maps/api/geocode/json?&latlng=" + lat + "," + lng + "&key=AIzaSyCauZ_bhI-nz6vJdf2fS7skFOMCwGkkw_o", createAddress)

//Création de l'élément p et ajout au bandeau
pElt = document.createElement("p");
pElt.id = "pInfoCarte";
bandeau.append(pElt);

//Ajout des evenements hover/nohover
carte.mouseover(scroll_menu);
carte.mouseout(hide_menu);
bandeau.mouseover(hide_arrow);
bandeau.mouseout(show_arrow);