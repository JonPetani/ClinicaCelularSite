/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Javascript Functions For Form Tags On The Site
*/

//Form Rollover Placeholder Text Array
var formText = [];

//Setup Form Styling
function formSetup() {
	$("input, select").after("<br><br>");
	$("form, label").find("a").after("<br>");
	$("input").css("padding", "15px");
	$("input[type=submit]").css("font-size", "150%");
	$("input[type=text],input[type=email],input[type=tel],input[type=password]").click(function() {
		$(this).css({"height": "6.5%", "width": "67%"});
	});
	$("input[type=text],input[type=email],input[type=tel],input[type=password]").mouseleave(function() {
		$(this).css({"height": "5%", "width": "65%"});
	});
	$("input").siblings("p").css({"font-size": "85%", "color": "#fc3019", "font-family": "'Barlow Semi Condensed', sans-serif"});
}

//Submit Form Directly Upon File Selection
function fileUploadAction() {
	if($("form").childElementCount === 1)
		$("input[type=file]").submit();
}

//Submit Form Directly Upon Pressing Enter
function searchBarAction() {
	if($("form").childElementCount === 1)
		$("input[type=text]").submit();
}

//Change Input Tag Placeholder Text Upon Rollover
function searchBarHelpText(searchBar) {
	var placeholderStr = $(searchBar).attr('placeholder');
	var strId = $(searchBar).attr('id');
	var width = $(searchBar).width();
	var height = $(searchBar).height();
	height += 10;
	width += 40;
	formText.push([strId, placeholderStr]);
	$(searchBar).attr('placeholder', 'Enter The Name or Item Code of the Product');
	$(searchBar).width(width).height(height);
}

//Swap Input Tag Placeholder Text To The Original Line
function searchBarDefaultText(searchBar) {
	var placeholderStr = "";
	var width = $(searchBar).width();
	var height = $(searchBar).height();
	height -= 10;
	width -= 40;
	for(var i = 0; i < formText.length; i++) {
		if(formText[i][0] === $(searchBar).attr('id')) {
			placeholderStr = formText[i][1];
			break;
		}
	}
	$(searchBar).attr('placeholder', placeholderStr);
	$(searchBar).width(width).height(height);
}