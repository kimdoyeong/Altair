{extends head.php}
			<h1><?=$var['page']?> 만들기</h1>
			<hr/>
			<form action="<?=Basic::shortURL('handle', array('handle'=>'newwiki'))?>" id="newform" new="<?=$var['page']?>">
				<textarea class="wiki-new" id="content"></textarea>
				
				버튼을 누르면 CCL 3.0 BY-SA로 배포하는 것에 동의한 것으로 간주합니다.
				<button class="wiki-btn">동의하고 기여</button>
			</form>
			
			
{extends footer.php}
