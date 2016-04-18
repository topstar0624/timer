<!DOCTYPE html>
<html lang="ja">
<head>
	<? include_once __DIR__.'/../parts/head.php'; ?>
	<meta name="description" content="タスク名と目標タイムを決めて、いざスタート！経過時間と残り時間がひと目で分かるから、時間内にサクッと仕事が片付くようになります。会員登録すれば、過去ログ管理も可能！">
	<title><? echo $title = '仮登録完了';?><?=TITLE_ADD?></title>
</head>
<body>
	<? include_once __DIR__.'/../parts/header.php'; ?>
	<main>
		<section>
			<h1><?=$title?></h1>
			<div class="block_inner">
				<p>仮登録が完了しました。ご登録いただいた <a href="mailto:<?=$_POST['email']?>" title="登録したメールアドレス"><?=$_POST['email']?></a> 宛てに本登録のご案内をお送りしました。ご確認ください。</p>
				<div class="block_button-container"><a href="/" title="トップページへ戻る" class="button button_center">トップページへ戻る</a></div>
			</div>
			<!-- /.block_inner -->
		</section>
		<hr />
	</main>
	<? include_once __DIR__.'/../parts/footer.php'; ?>
</body>
</html>