<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

define("_dir_", realpath(__DIR__.'/..'));
define("_action_dir_", _dir_."/actions/");

define("_shorturl_", true);
define('_wiki_main_', 'Altair:main');
define('_wiki_name_', '알타이르위키');
function load($module) {
	require_once _dir_.'/'.$module.'.php';
}

class Basic {
	public static function shortURL($action, array $a = null) {
		if (!_shorturl_) {
			
			$g = [];
			
			if (!empty($a))
				$g = array_keys($a);
			
			$url = "/index.php?action=".$action;
			foreach ($g as $d) {
				$url.='&'.$d.'='.$a[$d];
			}
			return $url;
		}
		
		switch ($action) {
			case "view":
				return '/w/'.$a['page'];
				break;
			case "new":
				return "/new/".$a['page'];
				break;
			case "handle":
				return "/handle/".$a['handle'];
				break;
			default:
				$g = [];
				if (!empty($a))
					$g = array_keys($a);
					
				$url = "/index.php?action=".$action;
				
				
				foreach ($g as $d) {
					$url.='&'.$d.'='.$a[$d];
				}
				return $url;
				break;
		}
	}
	public static function utf8_ord($ch)
	{
		$len = strlen($ch);
  		if($len <= 0) return false;
 		$h = ord($ch{0});
  		if ($h <= 0x7F) return $h;
  		if ($h < 0xC2) return false;
 		if ($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($ch{1}) & 0x3F);
 		if ($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);          
 		if ($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
  		return false;
	}
	public static function utf8_chr($num) {
		if($num<128) return chr($num);
		if($num<2048) return chr(($num>>6)+192).chr(($num&63)+128);
		if($num<65536) return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
		if($num<2097152) return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128).chr(($num&63)+128);
		return false;
	}
}
load('controller/ControlHandler');
load('lib/db');
?>