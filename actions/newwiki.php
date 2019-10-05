<?php

load('lib/Parser');
class newwiki {
	function view() {
		if (empty($_GET['page'])) {
			header('location: '.Basic::shortURL('notfonud'));
			exit;
		}
		$db = new db();
		$ok = $db->execute('select `idx` from `alt_wiki` where `subject`=?', [$_GET['page']]);
		if ($ok->rowCount() > 0) {
			header('location: '.Basic::shortURL('view', ['page'=>$_GET['page']]));
			exit;
		}
		
		unset($db);
		$page = $_GET['page'];
		
		$parser = new TemplateParser(_dir_.'/view/new.php', ["isset"=>false, "page"=>$page]);
		
		echo $parser->parse();
		exit;
	}
}
?>