<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<script src="//code.jquery.com/jquery-2.2.0.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/public/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="/public/script.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<title><?=_wiki_name_?></title>
</head>
<body>
	<noscript>
		<h1>자바스크립트 없이 이 홈페이지에 들어가실 수 없습니다.</h1>
	</noscript>
	<div id="wrap" class="hide">
		<div id="header">
			<nav class="navbar-custom nav-color">
				<div class="navc-head">
					<h1>
						<a href="/" style="color: white"><?=_wiki_name_?></a>
					</h1>
				</div>
				<div style="text-align: center">
					<ul class="navc-menu">
						<li>
							<a href="javascript:search()"><i class="fa fa-search"></i></a>
							<div id="search">
								<form action="/" id="search_form">
									<input type="text" id="search_input" />
									<input type="submit" class="btn btn-default" value="검색">
								</form>
								<div id="sslist">
								
								</div>
							</div>
						</li>
					<li>
						<a href="<?=Basic::shortURL('random')?>"><i class="fa fa-random"></i></a>
					</li>
				</ul>
				</div>
			</nav>
		</div>
		<div id="body">