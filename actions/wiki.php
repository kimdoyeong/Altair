<?php

class wiki {
	function view() {
		
		header('location: '.Basic::shortURL('view', [page=> _wiki_main_]));
		break;
	}
}
?>