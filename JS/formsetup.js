function formSetup() {
	$("input").after("<br><br>");
	$("form").find("a").after("<br>");
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
function fileUploadAction() {
	if($("form").childElementCount === 1)
		$("input[type=file]").submit();
}