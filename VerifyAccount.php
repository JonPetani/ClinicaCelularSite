<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Account Verification Step 2 : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
if(isset($_GET['account']) and !empty($_GET['account'])) {
	$sql = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :email");
	$address = urldecode($_GET['account']);
	$sql -> bindParam(':email', $address);
	$sql -> execute();
	if($sql -> rowCount() <= 0) {
		header("Location: loggedin.php");
		die;
	}
	$account = $sql -> fetch(PDO::FETCH_ASSOC);
	if($account['VerifiedAccount'] != 0) {
		header("Location: loggedin.php");
		die;
	}
}
else {
	header("Location: loggedin.php");
	die;
}
if(isset($_SESSION['logged'])) {
	if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
		header("Location: loggedin.php");
		die;
	}
}
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id="register">Register Account</a>
<a href="login.php" id="login">Log In</a>
</nav>
<main align=center>
<br clear=both>
<h1>One More Step Before You Can Use The Account</h1>
<form action="login.php?action=verify&account=<?php echo urldecode($_GET['account']);?>" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
?>
<input name="Code" type="password" placeholder="Enter The Code You Got In The Email or Text" required autocomplete="false"/>
<?php
printError("code", "Code Entered Doesn't Match The Email/Text's. Please Check The Message Again or Copy And Paste If Possible.")
?>
<input type="submit" align=center value="Submit To Verify"/>
</form>
</main>
<script>
$("input").after("<br><br>");
$("input").css("padding", "15px");
$("input[type=submit]").css("font-size", "150%");
$("input[type=text],input[type=email],input[type=tel],input[type=password]").click(function() {
	$(this).css({"height": "6.5%", "width": "67%"});
});
$("input[type=text],input[type=email],input[type=tel],input[type=password]").mouseleave(function() {
	$(this).css({"height": "5%", "width": "65%"});
});
$("input").siblings("p").css({"font-size": "85%", "color": "#fc3019", "font-family": "'Barlow Semi Condensed', sans-serif"});
</script>
</body>
</html>