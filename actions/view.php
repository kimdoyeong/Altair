<?php
load('lib/Parser');
load('lib/wikiparser');
class view {
	
	function view() {
		if (empty($_GET['page'])) {
			header('location: '.Basic::shortURL('notfonud'));
			exit;
		}

		$db = new db();
		
		$ok = $db->execute('select `idx` from `alt_wiki` where `subject`=?', [$_GET['page']]);
		$isset = true;
		
		$content = null;
		$foot = null;
		if ($ok->rowCount() < 1) {
			$isset = false;
		} else {
			$ok= $ok->fetch();
			$view = $db->execute('select `content` from `alt_vers` where `doc`=? order by `ver` desc', [$ok['idx']]);
			
			$view = $view->fetch();
			
			$content = $view['content'];
			$wiki = new WikiParser($content);
			
			$content = $wiki->getParse();
			$foot = $wiki->getHtmlNotes();
		}
		
		$page = $_GET['page'];
		unset($db);
		
		$parser = new TemplateParser(_dir_.'/view/wiki.php', ["isset"=>$isset, "page"=>$page, 'con'=>$content, "note"=>$foot]);
		
		echo basic::utf8_chr(45207);
		echo $parser->parse();
		exit;
	}
}
?>