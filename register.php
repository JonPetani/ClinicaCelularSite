<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<body>
<main align=center>
<h1>Create Account</h1>
<form action="signedup.php">
<input name="First" type="text" placeholder="First Name" required autocomplete="false"/>
<input name="Last" type="text" placeholder="Last Name" required autocomplete="false"/>
<input name="Address" type="text" placeholder="Address" required autocomplete="true"/>
<input name="zipCode" type="text" placeholder="Zip Code" required autocomplete="true" pattern="^[0-9]{5}$"/>
<input name="MPhone" type="tel" placeholder="Mobile Phone Number (Required)" required autocomplete="false" pattern="^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$"/>
<input name="LPhone" type="tel" placeholder="Non Mobile Phone Number (Optional)" required autocomplete="false" pattern="^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$"/>
<input name="Email" type="email" placeholder="Email Address" required autocomplete="false"/>
<input name="Password" type="password" placeholder="Password" required autocomplete="false"/>
<label for="keepOn">Keep Me Signed In</label>
<input name="keepOn" type="checkbox" autocomplete="false" value="si"/>
<label for="emailList">Add to Email List for Special Offers and Coupons</label>
<input name="emailList" type="checkbox" autocomplete="false" value="si"/>
<label for="Terms">Must Agree With Terms Of Service</label>
<input name="Terms" type="checkbox" autocomplete="false" required value="si"/>
<input type="submit" align=center value="Create Now"/>
</form>
</main>
<script>
$("input").after("<br><br>");
$("input").css("padding", "15px");
$("input[type=submit]").css("font-size", "150%");
</script>
</body>
</html>