var title = $("#titlePos");
var map = $("#map");
var bandeau = $("#bandeau");

function hide_bandeau()
{
	var min = 10;
	title.css("visibility", "hidden");
	map.css("visibility", "hidden");
	bandeau.css("width", "10px");
	bandeau.css("background-color", "grey");
}

function aff_bandeau()
{
	title.css("visibility", "visible");
	map.css("visibility", "visible");
	bandeau.css("width", "200px");
}

hide_bandeau();

bandeau.mouseover(aff_bandeau);
bandeau.mouseout(hide_bandeau);