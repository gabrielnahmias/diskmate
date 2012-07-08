<?php

require_once "functions.php";

class CDiskUsage {	
	
	var $m_Debug = false;
	var $m_nFiles = 0;
	var $m_nDirectories = 0;
	var $truncate = true;
	var $truncateLength = 49;
	
	function CDiskUsage() {
		// Constructor
	}
	
	function SetDebug($val) {
		$this->m_Debug = $val;
	}
	
	function SetTruncate($bool, $length) {
		$this->truncate = $bool;
		$this->truncateLength = $length;
	}
	
	function GetFiles() {
		return $this->m_nFiles;		
	}

	function GetDirectories() {
		return $this->m_nDirectories;
	}

	function Reset() {
		$this->m_nFiles = 0;
		$this->m_nDirectories = 0;
	}

	function CalculateUsage($dir) {
		$this->Reset();
		return $this->_CalculateUsage($dir);
	}

	// Called recursively.
	
	function _CalculateUsage($dir) {
		
		$size = 0;
		
		if ($dh = opendir($dir)) {
			while (($item = readdir($dh)) !== false) 
			{
				if ($item !== '.' 
					&& $item !== '..') 
				{
					$file = realpath($dir."/".$item);
					$this->Log('<div class="file" title="'.$file.'">'.($this->truncate ? truncate($file, $this->truncateLength) : "" )."</div> <span class=\"file-size\">(".filesize_exact( filesize($file) ).")</span>" );
					if (is_file($file)) 
					{
						$size += filesize($file);
						$this->m_nFiles++;
					} 
					else if (is_dir($file)) 
					{
						$size += $this->_CalculateUsage($file);
						$this->m_nDirectories++;
					}
				}
			}
		}
		
		return $size;
		
	}

	function Log($str) {
		if ($this->m_Debug)
			print($str);
	}

}