/*function dataTableSetup() {
	$('td').find('p').after('<br><br><br>');
}*/
function setImagePointer(setImage) {
	$('img.viewPointer').parent().css('border-style', 'none');
	$(setImage).parent().css('border-style', 'solid green 2px');
	var imgSRC = $(setImage).attr('src');
	$('img#currentImage').attr('src', imgSRC);
}
function collapseImageText(setLink) {
	$(setLink).find('div.collapse').collapse('show');
	$(setLink).parent().css('background-color', 'PowderBlue');
}
function unCollapseImageText(setLink) {
	$(setLink).find('div.collapse').collapse('hide');
	$(setLink).parent().css('background-color', '#007bff');
}