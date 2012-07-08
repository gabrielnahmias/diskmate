<?php

	function filesize_exact($iSize, $iPrecision = 2, $bSpace = true) {
		
		// By Gabriel Nahmias (gabriel@terrasoftlabs.com)
		
		// Measure certain byte ranges in descending order.
		
		$sUnit = "bytes";
		
		if ($iSize > 1024 * 1024 * 1024 * 1024 * 1024) {
			$sUnit = "PB";
			$iSize /= 1024 * 1024 * 1024 * 1024 * 1024;
		} else if ($iSize > 1024 * 1024 * 1024 * 1024) {
			$sUnit = "TB";
			$iSize /= 1024 * 1024 * 1024 * 1024;
		} else if ($iSize > 1024 * 1024 * 1024) {
			$sUnit = "GB";
			$iSize /= 1024 * 1024 * 1024;
		} else if ($iSize > 1024 * 1024) {
			$sUnit = "MB";
			$iSize /= 1024 * 1024;
		} else if ($iSize > 1024) {
			$sUnit = "KB";
			$iSize /= 1024;
		}
		
		if ($iPrecision > 0 && $iPrecision != NULL)
			$iSize = round($iSize, $iPrecision);
		
		// Make sure bytes is always spaced out; could be changed.
		
		return $iSize . ($bSpace || $sUnit == "bytes" ? " " : "") . $sUnit;
		
	}

function truncate($string, $max = 20, $replacement = '...') {
	
    if (strlen($string) <= $max)
        return $string;
    
	$leave = $max - strlen ($replacement);
    
	return substr_replace($string, $replacement, $leave);
	
}