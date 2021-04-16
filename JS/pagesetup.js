/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: JQuery functions for regular page use
*/
/*
/*function dataTableSetup() {
	$('td').find('p').after('<br><br><br>');
}*/

//Used by ProductView Page
//Changes Image To The One You Rolled Over In The Left Div
function setImagePointer(setImage) {
	$('img.viewPointer').parent().css('border-style', 'none');
	$(setImage).parent().css('border-style', 'solid green 2px');
	var imgSRC = $(setImage).attr('src');
	$('img#currentImage').attr('src', imgSRC);
}

//When You Roll Over A Div With This Function, It Collapses The Text Using Bootstrap
function collapseImageText(setLink) {
	$(setLink).find('div.collapse').collapse('show');
	$(setLink).parent().css('background-color', 'PowderBlue');
}

//When You Roll Out From A Div With This Function, It UnCollapses The Text Using Bootstrap
function unCollapseImageText(setLink) {
	$(setLink).find('div.collapse').collapse('hide');
	$(setLink).parent().css('background-color', '#007bff');
}