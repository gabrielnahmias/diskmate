<?php

session_start();

//error_reporting(0);

require_once "config.php";

if ( isset( $_COOKIE[TEXT_REMEMBER] ) && $_COOKIE[TEXT_REMEMBER] == md5(TEXT_PW) )
	$_SESSION[TEXT_IN] = true;

//require_once DIR_INC . "/functions.php";
require_once DIR_INC . "/browser.class.php";
require_once DIR_INC . "/diskusage.class.php";