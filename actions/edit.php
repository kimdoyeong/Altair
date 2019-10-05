<?php
load("lib/Parser");
class edit {
	
	function view() {
		$db = new db();
		
		if (empty($_GET['page'])) {
			header('location: '.Basic::shortURL('notfonud'));
			exit;
		}
		
		$ok = $db->execute('select `idx` from `alt_wiki` where `subject`=?', [$_GET['page']]);
		
		if ($ok->rowCount() < 1) {
			header('location: '.Basic::shortURL('new', ['page'=>$_GET['page']]));
			exit;
		}
		$ok = $ok->fetch();
		$get = $db->execute('select `content` from `alt_vers` where `doc`=? order by `ver` desc', [$ok['idx']]);
		
		$get = $get->fetch();
		unset($db);
		
		$t = new TemplateParser(_dir_.'/view/edit.php', ['edit'=>$get['content']]);
		echo $t->parse();
	}
}
?>