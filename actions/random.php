<?php
class random {
	function view() {
		$db = new db();
		$get = $db->execute('select `subject` from `alt_wiki` order by rand()');
		$get = $get->fetch();
		
		header('location: '.Basic::shortURL('view', ['page'=>$get['subject']]));
	}
}
?>