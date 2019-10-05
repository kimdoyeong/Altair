<?php
class TemplateParser {
	private $get;
	private $components;
	function __construct($url, $comp) {
		if (!file_exists($url)) {
			echo "Not exists ".$url;
			exit;
		}
		
		$fp = fopen($url, 'r');
		$get = fread($fp, filesize($url));
		fclose($fp);
		$this->get = $get;
		$this->components = $comp;
	}
	function parse() {
		$this->get = preg_replace_callback('/\{extends (.+)\}/', 'self::extend', $this->get);
		
		$var = $this->components;
		
		ob_start();
		eval('?>'.$this->get.'<?php ');
		$xs = ob_get_contents();
		ob_end_clean();
		
		$xs = preg_replace_callback('/\{(.+)\}/', 'self::place', $xs);
		$xs = str_replace("\{", '{', $xs);
		$xs = str_replace("\}", '}', $xs);
		
		return $xs;
	}
	function view() {
		echo $this->parse();
	}
	private function place($place) {
		if (!isset($this->components[$place[1]])) {
			return null;
		}
		$replace = $this->components[$place[1]];
		$replace = str_replace('<?', '&lt;?', $replace);
		$replace = str_replace('?>', '?&gt;', $replace);
		return $replace;
	}
	private function extend($a) {
		$t = new TemplateParser(_dir_.'/view/'.$a[1], $this->components);
		return $t->parse();
	}
}
?>