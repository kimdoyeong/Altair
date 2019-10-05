<?php
/*
 * 클래스 제작: 김도영,
 * 클래스 설명: 위키 문법 파싱,
 * 기타 설명: sp = 스페셜(즉, 특수처리)
 * */
class WikiParser {
	private $content;
	private $parseData;
	private $datas;
	private $db;
	function __construct($content) {
		$this->content = htmlspecialchars($content);
		$this->parseData['pattern'] = [
				'/\'\'\'(.+)\'\'\'/m',
				'/\[img:(.+)\]/m'
		];
		$this->parseData['replacement'] = [
				'<strong>$1</strong>',
				'<div class="wiki wrapper-img"><img src="$1"></div>'
		];
		
		$this->datas['prevSubject'] = 0;
		$this->datas['list'] = [];
		$this->datas['notecount'] = 0;
		$this->datas['notes'] = [];
		$this->datas['listhtml'] = "";
		$this->getSp();
		
		$this->db = new db();
	}
	
	function getRaw() {
		return $this->content;
	}
	function getParse() {
		$con = preg_replace($this->parseData['pattern'], $this->parseData['replacement'], $this->content);
		$con = $this->handleSP($con);
		
		
		$con = $this->li($con);
		$con = str_replace("\n", "<br>", $con);
		
		$con = preg_replace('/\\\(.)/', '$1', $con);
		
		unset($this->db);
		return $con;
	}
	private function li($con) {
		$list = '<div class="wiki list">';
			$list.=$this->datas['listhtml'];
		$list.='</div>';
		
		$con = preg_replace('/\[목차\]/m', $list, $con);
		return $con;
	}
	private function getSp() {
		$this->parseData['sp'] = [
			new WikiSpecial('/^(\#+)(.+)$/m', function($get) {
				$count = substr_count($get[1], '#');
				
				if ($this->datas['prevSubject'] < $count) {
					$count = $this->datas['prevSubject']+1;
					$this->datas['list'][$count-1] = 0;
				}
				
				$this->datas['list'][$count-1]++;
				
				
				$h = $count;
				if ($count > 4) {
					$h = 4;
				}
				$list = '';
				for ($i=0; $i<$count; $i++) {
					$list.=$this->datas['list'][$i].'.';
				}
				
				$this->datas['listhtml'].='<div style="margin-left: '.(($count-1)*10).'px"><a href="#list-'.rtrim($list, '.').'">'.$list.'</a>'.$get[2].'</div>';
				$this->datas['prevSubject'] = $count;
				return "<h".$h.' id="list-'.rtrim($list, '.').'"><a href="#">'.$list.'</a>'.$get[2].'</h'.$h.'><hr>';
			}),
			new WikiSpecial('/\&lt;note\&gt;(.+)\\&lt;\/note\&gt;/m', function($data) {
				$this->datas['notecount']++;
				$count = $this->datas['notecount'];
				
				$this->datas['notes'][$count] = $data[1];
				
				return '<a href="#note-'.$count.'">['.$count.']</a>';
			}),
			new WikiSpecial('/\[\[(.+)\]\]/m', function($data) {
				$wiki = $data[1];
				$get = $this->db->execute('select `idx` from `alt_wiki` where `subject`=?', [$wiki]);
				$is = true;
				if ($get->rowCount() < 1) {
					$is = false;
				}
				
				if ($is) {
					return "<a href='".Basic::shortURL('view', ['page'=>$wiki])."' title='".$wiki."' class='wiki url'>".$wiki."</a>";
				}
				return "<a href='".Basic::shortURL('view', ['page'=>$wiki])."' title='".$wiki."(없는 문서)' class='wiki url none'>".$wiki."</a>";
			})
		];
	}
	
	function getNotes() {
		return $this->datas['notes'];
	}
	function getHtmlNotes() {
		$note = "<div class='wiki notes'>";
		
		$count = 0;
		foreach ($this->datas['notes'] as $a) {
			$count++;
			$note.="<div id='note-".$count."'><a href='#'>[".$count."]</a>".$a."</div>";
		}
		$note.='</div>';
		
		return $note;
	}
	private function handleSP($get) {
		foreach ($this->parseData['sp'] as $a) {
			$get = preg_replace_callback($a->getPreg(), $a->getFunction(), $get);
		}
		return $get;
	}
}

/*
 * 클래스 제작: 김도영
 * 클래스 설명: 스페셜 문법 파싱
 */

class WikiSpecial {
	private $preg;
	private $function;
	function __construct($preg, $function) {
		$this->preg = $preg;
		$this->function = $function;
	}
	function getFunction() {
		return $this->function;
	}
	function getPreg() {
		return $this->preg;
	}
}
?>