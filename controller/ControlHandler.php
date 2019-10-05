<?php
class ControlHandler {
	private static $actions = [];
	
	public static function NewAction($action, $actionFile=null, $actionClass = null) {
		$a = [];
		
		$a['actionClass'] = $actionClass;
		$a['actionFile'] = $actionFile;
		
		ControlHandler::$actions[$action] = $a;
	}
	public static function GetAction($action) {
		if (isset(ControlHandler::$actions[$action]))  {
			return ControlHandler::$actions[$action];
		}
		return null;
	}
}
?>