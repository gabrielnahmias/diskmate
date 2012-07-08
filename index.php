<?php

/*!
 * DiskMate v1.0.1
 * http://github.com/terrasoftlabs/diskmate
 *
 * Copyright © 2012 Gabriel Nahmias.
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * TODO: Add output formats like Canommonon.
 *		 
 */

require_once "common.php";

if ( !$_SESSION[TEXT_IN] )
	header("Location: pw.php");

$details = false;
$exists = false;

import_request_variables("g");

if( !isset($d) )
	$d = getcwd();
//else if ( empty($d) )
//	$d = ROOT;
//else
//	$d = ROOT . $d;

if ( file_exists($d) )
	$exists = true;

if ( isset($listcontents) && $listcontents == "1" )
	$details = true;

if ( !isset($nhf) ):

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=sprintf("%s%s", NAME, TEXT_SEPARATOR)?>Analysis of "<?=$d?>"</title>

<link href="img/favicon.ico" rel="shortcut icon" />

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<script src="js/functions.js" type="text/javascript"></script>

<script>

$( function() {
	
	$(".overlay").fadeTo(500, 0);
	
} );

// When closing the window, logout if there's no cookie set to be remembered.

// TODO:	Add json.php/js to the system.

if ( !getCookie("remember_tvii") ) {
	
	console.debug("No cookie.");
	
	window.onbeforeonload = function() {
		
		console.debug("Logging out.");
		
		location.href = "logout.php";
		
	}
	
}

</script>

</head>

<body id="main" class="<?=getBrowser()?>">

<div class="overlay"></div>

<div id="container">
	
	<h1><?=sprintf("%s %s", COMPANY, NAME)?> <span class="version">v<?=VER?></span></h1>
	
	<div id="content">
		
		<!--<label for="root">Root:</label> <a href="?d="><input id="root" readonly="readonly" title="Examine the root directory of this web server." type="text" value="<?=ROOT?>" /></a>-->
		
		<form id="analysis" name="analysis" method="GET" action="<?=$_SERVER["PHP_SELF"]?>">
			
			<label for="d">Directory:</label> <input id="d" name="d" value="<?=$d//str_replace(ROOT, "", $d)?>" type="text" /> 
			
			<input type="submit" value="Calculate" /> 
			
			<div class="cbox-wrap">
				
				<input id="listcontents"<?php if ($details): ?> checked="checked"<?php endif; ?> name="listcontents" type="checkbox" value="1" /><label for="listcontents">List Contents</label>
			
			</div>
			
		</form>
		
		<div id="results">
		
<? endif; ?>
			<div class="list">
				
				<span<?php if ($exists) { ?> class="top-dir"<?php } ?>><?php if ($exists) print $d; else print "No such directory."; ?></span>
				
				<br /><?php
				
				$obj = new CDiskUsage();
				
				if ($details)
					$obj->SetDebug(true);
				
				$size = $obj->CalculateUsage($d);
				
				?>
				
			</div>
			
			<table class="info" cellspacing="10">
			
			<tr>
				
				<td>Number of files</td>
				
				<td><?=$obj->GetFiles()?></td>
				
			</tr>
			
			<tr>
				
				<td>Number of directories</td>
				
				<td><?=$obj->GetDirectories()?></td>
				
			</tr>
			
			<tr>
				
				<td>Disk usage</td>
				
				<td><?=filesize_exact($size)?></td>
				
			</tr>
			
			</table>
<?php if ( !isset($nhf) ):?>
			
		</div>
		
	</div>
	
</div>
	
</body>

</html>
<?php endif;

include DIR_INC . "/footer.php";

?>