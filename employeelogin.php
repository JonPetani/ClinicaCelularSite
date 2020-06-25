<html>
<head>
</head>
<body>
<?php
require "connect.php";
$sql = $con -> prepare("SELECT * FROM");
if($_POST['Code'])
?>
<form action="employeehome.php">
<input type="text" placeholder="Your Full Name (First + Last)" required autocomplete="false"/>
<input type="text" placeholder="Your Password" required autocomplete="false"/>
<input type="submit"/>
</form>
</body>
</html>