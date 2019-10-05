{extends head.php}
			<?php
			if (!$var['isset']) {
				?>
				<h1>
					"<?=$var['page']?>" 문서를 찾을 수 없습니다.
				</h1>
				<hr/>
				
				<h3>아래 내용을 확인해주세요.</h3>
				
				<ul>
					<li>오탈자가 있는 지 확인해주세요.</li>
					<li><a href="<?=Basic::shortURL('new', array('page'=>$var['page']))?>">문서를 새로 만들어주세요.</a></li>
				</ul>
				<?php
			} else {
				?>
				<div class="wiki-menu-zone">
					<ul class="wiki-menu" style="float: right">
					<li><a href="<?=Basic::shortURL('edit', ['page'=>$_GET['page']])?>">편집</a></li>
				</ul>
				</div>
				
				<h1><?=$_GET['page']?></h1>
				<hr/>
				<?=$var['con']?>
				<hr/>
				<?=$var['note']?>
				<?php
			}
			?>
{extends footer.php}
