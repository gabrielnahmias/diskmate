<?php

function getBrowser() {
	
	$br = new Browser;
	
	// Convert browser name to lower case and then find if it exists.
	// MUCH shorter code.  Something is definitely wrong with this.
	// Only needed conditional is maybe the IE one up top.
	
	if ( $br->Platform == 'Windows' && $br->Name == 'MSIE' ) {
	
		if ($br->Version >= 9)
			$css_class = 'ie9';
		if ($br->Version >= 8 && $br->Version < 9)
			$css_class = 'ie8';
		if ($br->Version >= 7 && $br->Version < 8)
			$css_class = 'ie7';
		if ($br->Version >= 6 && $br->Version < 7)
			$css_class = 'ie6';
		if ($br->Version < 6)
			$css_class = 'ie5';
	
	} elseif ($br->Platform =='iPhone')
		$css_class = 'iphone';
	elseif ($br->Name =='Firefox')
		$css_class = 'firefox';
	elseif ($br->Name =='Opera')
		$css_class = 'opera';
	elseif ($br->Name =='Safari')
		$css_class = 'safari';
	elseif ($br->Name =='OmniWeb')
		$css_class = 'omniweb';
	elseif ($br->Name =='WebKit')
		$css_class = 'webkit';
	
	// I suppose this bit is for text-based browsers although there could be a better way.
	
	else
		$css_class = "basic";
	
	return $css_class;
	
}

class Browser {

	var $Name = "Unknown";
	var $Version = "Unknown";
	var $Platform = "Unknown";
	var $UserAgent = "Not reported";
	var $AOL = false;

	function Browser(){
		$agent = $_SERVER['HTTP_USER_AGENT'];

		// initialize properties
		$bd['platform'] = "Unknown";
		$bd['browser'] = "Unknown";
		$bd['version'] = "Unknown";
		$this->UserAgent = $agent;

		// find operating system
		if (preg_match("/win/i", $agent))
			$bd['platform'] = "Windows";
		// added by minimal design on Sunday, July 8, 2007 for iPhone support
		elseif (preg_match("/iPhone/i", $agent))
			$bd['platform'] = "iPhone";
		elseif (preg_match("/mac/i", $agent))
			$bd['platform'] = "MacIntosh";
		elseif (preg_match("/linux/i", $agent))
			$bd['platform'] = "Linux";
		elseif (preg_match("/BeOS/i", $agent))
			$bd['platform'] = "BeOS";

		// test for Opera		
		if (preg_match("/opera/i",$agent)){
			$val = stristr($agent, "opera");
			if (preg_match("/", $val)){
				$val = explode("/",$val);
				$bd['browser'] = $val[0];
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			}else{
				$val = explode(" ",stristr($val,"opera"));
				$bd['browser'] = $val[0];
				$bd['version'] = $val[1];
			}

		// test for WebTV
		}elseif(preg_match("/webtv/i",$agent)){
			$val = explode("/",stristr($agent,"webtv"));
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];
		
		// test for MS Internet Explorer version 1
		}elseif(preg_match("/microsoft internet explorer/i", $agent)){
			$bd['browser'] = "MSIE";
			$bd['version'] = "1.0";
			$var = stristr($agent, "/");
			if (preg_match("/308|425|426|474|0b1/", $var)){
				$bd['version'] = "1.5";
			}

		// test for NetPositive
		}elseif(preg_match("/NetPositive/i", $agent)){
			$val = explode("/",stristr($agent,"NetPositive"));
			$bd['platform'] = "BeOS";
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];

		// test for MS Internet Explorer
		}elseif(preg_match("/msie/i",$agent) && !preg_match("/opera/",$agent)){
			$val = explode(" ",stristr($agent,"msie"));
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];
		
		// test for Galeon
		}elseif(preg_match("/galeon/i",$agent)){
			$val = explode(" ",stristr($agent,"galeon"));
			$val = explode("/",$val[0]);
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];
			
		// test for Konqueror
		}elseif(preg_match("/Konqueror/i",$agent)){
			$val = explode(" ",stristr($agent,"Konqueror"));
			$val = explode("/",$val[0]);
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];
			
		// test for iCab
		}elseif(preg_match("/icab/i",$agent)){
			$val = explode(" ",stristr($agent,"icab"));
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];

		// test for OmniWeb
		}elseif(preg_match("/omniweb/i",$agent)){
			$val = explode("/",stristr($agent,"omniweb"));
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];

		// test for Phoenix
		}elseif(preg_match("/Phoenix/i", $agent)){
			$bd['browser'] = "Phoenix";
			$val = explode("/", stristr($agent,"Phoenix/"));
			$bd['version'] = $val[1];
		
		// test for Firefox
		}elseif(preg_match("/Firefox/i", $agent)){
			$bd['browser']="Firefox";
			$val = stristr($agent, "Firefox");
			$val = explode("/",$val);
			$bd['version'] = $val[1];
			
	  // test for Mozilla Alpha/Beta Versions
		}elseif(preg_match("/mozilla/i",$agent) && 
			preg_match("/rv:[0-9].[0-9][a-b]/i",$agent) && !preg_match("/netscape/i",$agent)){
			$bd['browser'] = "Mozilla";
			$val = explode(" ",stristr($agent,"rv:"));
			preg_match("/rv:[0-9].[0-9][a-b]/i",$agent,$val);
			$bd['version'] = str_replace("rv:","",$val[0]);
			
		// test for Mozilla Stable Versions
		}elseif(preg_match("/mozilla/i",$agent) &&
			preg_match("/rv:[0-9]\.[0-9]/i",$agent) && !preg_match("/netscape/i",$agent)){
			$bd['browser'] = "Mozilla";
			$val = explode(" ",stristr($agent,"rv:"));
			preg_match("/rv:[0-9]\.[0-9]\.[0-9]/i",$agent,$val);
			$bd['version'] = str_replace("rv:","",$val[0]);
		
		// test for Lynx & Amaya
		}elseif(preg_match("/libwww/i", $agent)){
			if (preg_match("/amaya/i", $agent)){
				$val = explode("/",stristr($agent,"amaya"));
				$bd['browser'] = "Amaya";
				$val = explode(" ", $val[1]);
				$bd['version'] = $val[0];
			} else {
				$val = explode("/",$agent);
				$bd['browser'] = "Lynx";
				$bd['version'] = $val[1];
			}
		
		// test for Obigo (some strangeass browser a piece of crap phone I found uses)
		}elseif(preg_match("/huawei-u2800/i", $agent)){
			
			// Browser/Obigo and Browser/Q05A was in the user agent.
			
			$bd['browser'] = "Obigo";
			$bd['version'] = "";
			
		// test for WebKit
		}elseif(preg_match("/webkit/i", $agent)){
			
			// Technically, this is kind of odd but it comes in handy to have a blanket
			// for all browsers using this rendering engine.
			
			$bd['browser'] = "WebKit";
			$bd['version'] = "";
			
		// test for Safari
		}elseif(preg_match("/safari/i", $agent)){
			$bd['browser'] = "Safari";
			$bd['version'] = "";

		// remaining two tests are for Netscape
		}elseif(preg_match("/netscape/i",$agent)){
			$val = explode(" ",stristr($agent,"netscape"));
			$val = explode("/",$val[0]);
			$bd['browser'] = $val[0];
			$bd['version'] = $val[1];
		}elseif(preg_match("/mozilla/i",$agent) && !preg_match("/rv:[0-9]\.[0-9]\.[0-9]/i",$agent)){
			$val = explode(" ",stristr($agent,"mozilla"));
			$val = explode("/",$val[0]);
			$bd['browser'] = "Netscape";
			$bd['version'] = $val[1];
		}
		
		// clean up extraneous garbage that may be in the name
		$bd['browser'] = preg_replace("/[^a-z,A-Z]/", "", $bd['browser']);
		// clean up extraneous garbage that may be in the version		
		$bd['version'] = preg_replace("/[^0-9,.,a-z,A-Z]/", "", $bd['version']);
		
		// check for AOL
		if (preg_match("/AOL/i", $agent)){
			$var = stristr($agent, "AOL");
			$var = explode(" ", $var);
			$bd['aol'] = preg_replace("/[^0-9,.,a-z,A-Z]/i", "", $var[1]);
		} else {
			$bd['aol'] = null;
		}
		
		// finally assign our properties
		$this->Name = $bd['browser'];
		$this->Version = $bd['version'];
		$this->Platform = $bd['platform'];
		$this->AOL = $bd['aol'];
	}
}
?>