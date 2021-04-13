<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<title>One More Step : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/emailtools.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sql = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :email OR MobilePhone = :phonemobile OR Phone = :phonelandline");
	$sql -> bindParam(":email", $_POST['Email']);
	$sql -> bindParam(":phonemobile", $_POST['MPhone']);
	$sql -> bindParam(":phonelandline", $_POST['LPhone']);
	$sql -> execute();
	if($sql -> rowCount() > 0) {
		header("Location: register.php?error=duplicate");
		die;
	}
	if(strcmp($_POST['Terms'], "si") != 0) {
		header("Location: register.php?error=terms");
		die;
	}
	if(strlen($_POST['First']) < 2) {
		header("Location: register.php?error=first");
		die;
	}
	if(strlen($_POST['Last']) < 2) {
		header("Location: register.php?error=last");
		die;
	}
	if(preg_match('^.*@.*$^', $_POST['Email']) == 0) {
		header("Location: register.php?error=email");
		die;
	}
	if(preg_match("^[0-9]{1,5},.{7,}$^", $_POST['Address']) == 0) {
		header("Location: register.php?error=address");
		die;
	}
	if(!empty($_POST['LPhone'])) {
		if(preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['LPhone']) == 0) {
			header("Location: register.php?error=lphone");
			die;
		}
	}
	if(preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['MPhone']) == 0) {
		header("Location: register.php?error=mphone");
		die;
	}
	if(preg_match('^[0-9]{5}$^', $_POST['zipCode']) == 0) {
		header("Location: register.php?error=zip");
		die;
	}
	$hasUpper = false;
	$hasLower = false;
	$hasNum = false;
	$passStr = str_split($_POST['Password']);
	foreach($passStr as $char) {
		if(preg_match('^[A-Z]^', $char) == 1)
			$hasUpper = true;
		if(preg_match('^[a-z]^', $char) == 1)
			$hasLower = true;
		if(preg_match('^[0-9]^', $char) == 1)
			$hasNum = true;
		if($hasUpper == true and $hasLower == true and $hasNum == true)
			break;
	}
	if($hasUpper == false or $hasLower == false or $hasNum == false or strlen($_POST['Password']) < 12) {
		header("Location: register.php?error=password");
		die;
	}
	if(strcmp($_POST['keepOn'], "si") !== 0)
		$keepLoggedIn = false;
	else
		$keepLoggedIn = true;
	if(strcmp($_POST['emailList'], "si") !== 0)
		$emailList = false;
	else
		$emailList = true;
	$sql = $con -> prepare("INSERT INTO customer (FirstName, LastName, Password, EmailAddress, Phone, MobilePhone, ZipCode, Address, KeepLoggedIn, EmailList, VerifiedAccount) VALUES (:First, :Last, :Password, :Email, :LPhone, :MPhone, :zipCode, :Address, :keepLoggedIn, :emailList, :verify)");
	$sql -> bindParam(":First", $_POST['First']);
	$sql -> bindParam(":Last", $_POST['Last']);
	$sql -> bindParam(":Password", $_POST['Password']);
	$sql -> bindParam(":Email", $_POST['Email']);
	$sql -> bindParam(":LPhone", $_POST['LPhone']);
	$sql -> bindParam(":MPhone", $_POST['MPhone']);
	$sql -> bindParam(":zipCode", $_POST['zipCode']);
	$sql -> bindParam(":Address", $_POST['Address']);
	$sql -> bindParam(":keepLoggedIn", $keepLoggedIn);
	$sql -> bindParam(":emailList", $emailList);
	$verified = false;
	$sql -> bindParam("verify", $verified);
	$sql -> execute();
	$vcode = randomCodeGenerator(20, 30);
	$codeset = $con -> prepare("UPDATE customer SET VerifyCode = :vc WHERE MobilePhone = :mp");
	$codeset -> bindParam(":vc", $vcode);
	$codeset -> bindParam(":mp", $_POST['MPhone']);
	$codeset -> execute();
	$html_body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html data-editor-version="2" class="sg-campaigns" xmlns="http://www.w3.org/1999/xhtml"><head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <!--<![endif]-->
      <!--[if (gte mso 9)|(IE)]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
      <!--[if (gte mso 9)|(IE)]>
  <style type="text/css">
    body {width: 600px;margin: 0 auto;}
    table {border-collapse: collapse;}
    table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
    img {-ms-interpolation-mode: bicubic;}
  </style>
<![endif]-->
      <style type="text/css">
    body, p, div {
      font-family: inherit;
      font-size: 14px;
    }
    body {
      color: #000000;
    }
    body a {
      color: #1188E6;
      text-decoration: none;
    }
    p { margin: 0; padding: 0; }
    table.wrapper {
      width:100% !important;
      table-layout: fixed;
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: 100%;
      -moz-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    img.max-width {
      max-width: 100% !important;
    }
    .column.of-2 {
      width: 50%;
    }
    .column.of-3 {
      width: 33.333%;
    }
    .column.of-4 {
      width: 25%;
    }
    @media screen and (max-width:480px) {
      .preheader .rightColumnContent,
      .footer .rightColumnContent {
        text-align: left !important;
      }
      .preheader .rightColumnContent div,
      .preheader .rightColumnContent span,
      .footer .rightColumnContent div,
      .footer .rightColumnContent span {
        text-align: left !important;
      }
      .preheader .rightColumnContent,
      .preheader .leftColumnContent {
        font-size: 80% !important;
        padding: 5px 0;
      }
      table.wrapper-mobile {
        width: 100% !important;
        table-layout: fixed;
      }
      img.max-width {
        height: auto !important;
        max-width: 100% !important;
      }
      a.bulletproof-button {
        display: block !important;
        width: auto !important;
        font-size: 80%;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .columns {
        width: 100% !important;
      }
      .column {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
    }
  </style>
      <!--user entered Head Start--><link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet"><style>
body {font-family: \'Muli\', sans-serif;}
</style><!--End Head user entered-->
    </head>
    <body>
      <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size:14px; font-family:inherit; color:#000000; background-color:#FFFFFF;">
        <div class="webkit">
          <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#FFFFFF">
            <tbody><tr>
              <td valign="top" bgcolor="#FFFFFF" width="100%">
                <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tbody><tr>
                    <td width="100%">
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                          <td>
                            <!--[if mso]>
    <center>
    <table><tr><td width="600">
  <![endif]-->
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;" align="center">
                                      <tbody><tr>
                                        <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#FFFFFF" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
    <tbody><tr>
      <td role="module-content">
        <p></p>
      </td>
    </tr>
  </tbody></table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:30px 20px 30px 20px;" bgcolor="#f6f6f6">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="540" style="width:540px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="72aac1ba-9036-4a77-b9d5-9a60d9b05cba">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <!--<img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px;" width="29" alt="" data-proportionally-constrained="true" data-responsive="false" src="Images/ClinicaIcon.png" height="27">-->
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="331cde94-eb45-45dc-8852-b7dbeb9101d7">
    <tbody>
      <tr>
        <td style="padding:0px 0px 20px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="d8508015-a2cb-488c-9877-d46adf313282">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px;" width="75%" alt="" data-proportionally-constrained="true" data-responsive="false" src="https://i.ibb.co/2ZkYsVF/Clinica-Icon.png" height="25%" alt="Clinica Celuluar">
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="27716fe9-ee64-4a64-94f9-a4f28bc172a0">
    <tbody>
      <tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="948e3f3f-5214-4721-a90e-625a47b1c957" data-mc-module-version="2019-10-22">
    <tbody>
      <tr>
        <td style="padding:50px 30px 18px 30px; line-height:36px; text-align:inherit; background-color:#ffffff;" height="100%" valign="top" bgcolor="#ffffff" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 43px">Thanks for your service with us, ' . $_POST['First'] . '!&nbsp;</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="a10dcb57-ad22-4f4d-b765-1d427dfddb4e" data-mc-module-version="2019-10-22">
    <tbody>
      <tr>
        <td style="padding:18px 30px 18px 30px; line-height:22px; text-align:inherit; background-color:#ffffff;" height="100%" valign="top" bgcolor="#ffffff" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 18px">Please verify your email address to</span><span style="color: #000000; font-size: 18px; font-family: arial,helvetica,sans-serif"> begin your purchases through our endless inventory</span><span style="font-size: 18px">.</span></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffbe00; font-size: 18px"><strong>Your Verification Code Is: ' . $vcode . '&nbsp;</strong></span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="7770fdab-634a-4f62-a277-1c66b2646d8d">
    <tbody>
      <tr>
        <td style="padding:0px 0px 20px 0px;" role="module-content" bgcolor="#ffffff">
        </td>
      </tr>
    </tbody>
  </table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="d050540f-4672-4f31-80d9-b395dc08abe1">
      <tbody>
        <tr>
          <td align="center" bgcolor="#ffffff" class="outer-td" style="padding:0px 0px 0px 0px;">
            <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
              <tbody>
                <tr>
                <td align="center" bgcolor="#ffbe00" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;">
                  <a href="http://localhost:8080/ClinicaCelularSite/VerifyAccount.php?account=' . urlencode($_POST['Email']) . '&type=verify" style="background-color:#ffbe00; border:1px solid #ffbe00; border-color:#ffbe00; border-radius:0px; border-width:1px; color:#000000; display:inline-block; font-size:14px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:12px 40px 12px 40px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;" target="_blank">Verify Email Now</a>
                </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="7770fdab-634a-4f62-a277-1c66b2646d8d.1">
    <tbody>
      <tr>
        <td style="padding:0px 0px 50px 0px;" role="module-content" bgcolor="#ffffff">
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="a265ebb9-ab9c-43e8-9009-54d6151b1600" data-mc-module-version="2019-10-22">
    <tbody>
      <tr>
        <td style="padding:50px 30px 50px 30px; line-height:22px; text-align:inherit; background-color:#6e6e6e;" height="100%" valign="top" bgcolor="#6e6e6e" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-size: 18px"><strong>What You Can Do Next:</strong></span></div>
<div style="font-family: inherit; text-align: center"><br></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-size: 18px">1. Setup your method of payment for your next purchase with us.</span></div>
<div style="font-family: inherit; text-align: center"><br></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-size: 18px">2. Once you find something of interest in our inventory, add that item to your cart for the final purchase.</span></div>
<div style="font-family: inherit; text-align: center"><br></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-size: 18px">3. After the purchase selection and transaction is done, check on your delivery in progress.</span></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffbe00; font-size: 18px"><strong>+ much more!</strong></span></div>
<div style="font-family: inherit; text-align: center"><br></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-size: 18px">Need support? Our support team is always</span></div>
<div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-size: 18px">ready to help!&nbsp;</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="d050540f-4672-4f31-80d9-b395dc08abe1.1">
      <tbody>
        <tr>
          <td align="center" bgcolor="#6e6e6e" class="outer-td" style="padding:0px 0px 0px 0px;">
            <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
              <tbody>
                <tr>
                <td align="center" bgcolor="#ffbe00" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;">
                  <a href="" style="background-color:#ffbe00; border:1px solid #ffbe00; border-color:#ffbe00; border-radius:0px; border-width:1px; color:#000000; display:inline-block; font-size:14px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:12px 40px 12px 40px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;" target="_blank">Contact Support</a>
                </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="c37cc5b7-79f4-4ac8-b825-9645974c984e">
    <tbody>
      <tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="6E6E6E">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table><div data-role="module-unsubscribe" class="module" role="module" data-type="unsubscribe" style="color:#444444; font-size:12px; line-height:20px; padding:16px 16px 16px 16px; text-align:Center;" data-muid="4e838cf3-9892-4a6d-94d6-170e474d21e5">
                                            <div class="Unsubscribe--addressLine"><p class="Unsubscribe--senderName" style="font-size:12px; line-height:20px;"></p><p style="font-size:12px; line-height:20px;"><span class="Unsubscribe--senderAddress">Eje Central Lázaro Cárdenas 11, Colonia Centro, Centro, Cuauhtémoc, 06000 Ciudad de México, CDMX
</span>, <span class="Unsubscribe--senderCity">Ciudad de México</span>, <span class="Unsubscribe--senderState">Ciudad de México</span> <span class="Unsubscribe--senderZip">06000</span></p></div>
                                            <p style="font-size:12px; line-height:20px;"><a class="Unsubscribe--unsubscribeLink" href="{{{unsubscribe}}}" target="_blank" style="">Unsubscribe</a> - <a href="{{{unsubscribe_preferences}}}" target="_blank" class="Unsubscribe--unsubscribePreferences" style="">Unsubscribe Preferences</a></p>
                                          </div><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="550f60a9-c478-496c-b705-077cf7b1ba9a">
      <tbody>
        <tr>
          <td align="center" bgcolor="" class="outer-td" style="padding:0px 0px 20px 0px;">
            <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
              <tbody>
                <tr>
                <td align="center" bgcolor="#f5f8fd" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;"><a href="https://sendgrid.com/" style="background-color:#f5f8fd; border:1px solid #f5f8fd; border-color:#f5f8fd; border-radius:25px; border-width:1px; color:#a8b9d5; display:inline-block; font-size:10px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:5px 18px 5px 18px; text-align:center; text-decoration:none; border-style:solid; font-family:helvetica,sans-serif;" target="_blank">♥ POWERED BY TWILIO SENDGRID</a></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table></td>
                                      </tr>
                                    </tbody></table>
                                    <!--[if mso]>
                                  </td>
                                </tr>
                              </table>
                            </center>
                            <![endif]-->
                          </td>
                        </tr>
                      </tbody></table>
                    </td>
                  </tr>
                </tbody></table>
              </td>
            </tr>
          </tbody></table>
        </div>
      </center>
    
  
</body></html>';
	$subject = "Verify Account For " . $_POST['First'] . " " . $_POST['Last'] . " At Clinica Celular";
	$sender = "dereisengott@gmail.com";
	sendEmail($sender, $html_body, $_POST['Email'], $subject, $con);
	//For Future When SMS Service Provider is Chosen
	/*$message = "Este mensaje es de Clinica Celular. El código de verificación es " . $vcode;
	$textStatus = sendText($message, $_POST['MPhone'], $con);
	echo "Error: " . $textStatus;*/
}
else {
	if(!isset($_GET['return'])) {
		header('Location: register.php?error=loading');
		die;
	}
	/*if(array_key_exists('Send Email', $_POST))
		sendEmail($sender, $html_body, $_POST['Email'], $subject, $con);*/
}

?>
<div class="container">
<?php
setAccountTabs($con);
?>
<main>
<h1>Registration Successful</h1>
<p>To verify your identity we will send you a email<!--text-->. Click the button below if you have not recieved a email in the inbox</p>
<!--<form method="post">
<input type="submit" name="Send Email"/>
</form>-->
<a href="registerverify.php" align=center id="sms">Send Verification Email Now<!--Send SMS Text Verification Now--></a>
<?php
changeButton("verify", "email", "Send Email Again");
?>
<a href="login.php" align=center>Once Complete, Log Into Your New Account Here</a>
</main>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>