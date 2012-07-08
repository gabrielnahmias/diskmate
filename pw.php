<?php

require_once "common.php";

$pw = "";

import_request_variables("g");

if ($pw == TEXT_PW) {
	
	$_SESSION[TEXT_IN] = true;
	
	if ($rememberme == "1")
		setcookie( TEXT_REMEMBER , md5($pw) , ( time() + 60 * 60 * 24 * 30 ) );
	
	header("Location: index.php");
	
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enter Password to Access Sensitive Information</title>

<link href="css/styles.css" rel="stylesheet" type="text/css" />

</head>

<body id="login" class="<?=getBrowser()?>">

<div id="container">
	
	<?php include(DIR_INC . "/header.php"); ?>
	
	<div id="content">
		
		<form id="analysis" name="analysis" method="GET" action="<?=$_SERVER["PHP_SELF"]?>">
			
			<input id="pw" name="pw" type="password" placeholder="Enter Password" /> <input type="submit" value="Log In" /> 
			
			<div class="cbox-wrap">
				
				<input id="rememberme"<?php if ( isset( $_COOKIE[TEXT_REMEMBER] ) ): ?> checked="checked"<?php endif; ?> name="rememberme" type="checkbox" value="1" /><label for="rememberme">Remember Me</label>
			
			</div>
			
		</form>
		
	</div>
	
</div>
	
</body>

</html>