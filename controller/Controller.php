<?php
class Controller {
	function __construct() {
		$action = "home";
		
		if (isset($_GET['action'])) {
			$action = $_GET['action'];
		}
		
		$get = ControlHandler::GetAction($action);
		
		if (!isset($get)) {
			echo "<h1>Can't execute action</h1><p>fail get a action</p>";
			exit;
		}
		
		$class = $get['actionClass'];
		$require = _action_dir_.$get['actionClass'].'.php';
		
		if (isset($get['actionFile'])) {
			$require = $get['actionFile'];
		}
		
		if (!file_exists($require)) {
			echo "<h1>Can't execute action</h1><p>file not fonud</p>";
			exit;
		}
		
		require $require;
		
		$a = new $class();
		
		$a->view();
	}
}
?>