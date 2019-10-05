{extends head.php}
	<h1><?=$_GET['page']?> 문서 편집</h1>
	<hr/>
	
	<form action="<?=Basic::shortURL('handle', ['handle'=>'edit'])?>" new="<?=$_GET['page']?>" id="newform">
		<textarea class="wiki-new" id="content"><?=$var['edit']?></textarea>
			버튼을 누르면 CCL 3.0 BY-SA로 배포하는 것에 동의한 것으로 간주합니다.
		<button class="wiki-btn">동의하고 기여</button>
	</form>
{extends footer.php}