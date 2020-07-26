<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
</head>
<body>
<main align=center>
<h2>This Page and Points Beyond Are Restricted to Employees</h2>
<p>Is protected by a secret code. If you forgot it, press the button below to have it sent to your company email. Also check your inbox for possible changes in the code.</p>
<a href="codesend.php" id="sms">Send Code</a>
<form action="employeelogin.php">
<input type="text" name="Code" placeholder="Enter The Employee Code" required autocomplete="false">
<input type="submit" value="Submit Code"/>
</form>
</main>
</body>
</head>