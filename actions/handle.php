<?php
class handle {
	function view() {
		if (!method_exists($this, $_GET['handle'])) {
			exit;
		}
		$this->{$_GET['handle']}();
	}
	private function newwiki() {
		if (empty($_POST['con']) || empty($_POST['make'])) {
			$this->error('값이 없습니다.');
		}
		$db = new db();
		
		$ok = $db->execute('select `idx` from `alt_wiki` where `subject`=?', [$_POST['make']]);
		if ($ok->rowCount() > 0) {
			$this->error('이미 문서가 있습니다.');
		}
		
		$db->execute('insert into `alt_wiki` (`subject`, `acl`) values(?, ?)', [$_POST['make'], json_encode(['read'=>0, 'write'=>0])]);
		$get = $db->execute('select * from `alt_wiki` where `subject`=? order by `idx` desc', array($_POST['make']));
		$get = $get->fetch();
		
		$ver = $get['version'];
		$idx = $get['idx'];
		
		$db->execute('insert into `alt_vers`(`doc`, `content`, `by`, `ver`) values (?, ?, ?, ?)', array($idx, $_POST['con'], $_SERVER['REMOTE_ADDR'], $ver));
		
		unset($db);
		die(json_encode(['type'=>'success']));
	}
	
	private function edit() {
		if (empty($_POST['con']) || empty($_POST['make'])) {
			$this->error('값이 없습니다.');
		}
		$db = new db();
		
		$ok = $db->execute('select `idx`,`version` from `alt_wiki` where `subject`=?', [$_POST['make']]);
		if ($ok->rowCount() < 1) {
			$this->error('문서가 없습니다.');
		}
		
		$ok = $ok->fetch();
		
		$db->execute('insert into `alt_vers`(`doc`, `content`, `by`, `ver`) values (?, ?, ?, ?)', array($ok['idx'], $_POST['con'], $_SERVER['REMOTE_ADDR'], ($ok['version']+1)));
		$db->execute('update `alt_wiki` set `version`=`version`+1 where `idx`=?', [$ok['idx']]);
		
		unset($db);
		die(json_encode(['type'=>'success']));
	}
	
	private function search() {
		if (empty($_POST['search'])) {
			exit;
		}
		$db = new db();
		
		$get = $db->execute('select `subject` from `alt_wiki` where `subject` like ? limit 0,10', [$_POST['search'].'%']);
		$get = $get->fetchAll();
		
		unset($db);
		
		die(json_encode($get));
	}
	private function error($data) {
		die(json_encode(['type'=>'err', 'data'=>$data]));
	}
}
?>