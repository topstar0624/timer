<!DOCTYPE html>
<html lang="ja">

	<head>
		<? include_once __DIR__.'/../parts/head.php'; ?>
		<meta name="description" content="タスク名と目標タイムを決めて、いざスタート！経過時間と残り時間がひと目で分かるから、時間内にサクッと仕事が片付くようになります。会員登録すれば、過去ログ管理も可能！">
		<title>仮登録完了&nbsp;|&nbsp;サクッとタイマー</title>
	</head>

	<body>

		<? include_once __DIR__.'/../parts/header.php'; ?>

		<main>

			<section>
				<h1>仮登録完了</h1>
				<div class="block_inner">
					<?=$message?:''?>
					<p>仮登録が完了しました。ご登録いただいた <?=$_POST['email']?> 宛てに本登録のご案内をお送りしました。ご確認ください。</p>
				</div>
				<!-- /.block_inner -->
			</section>
			<hr />

		</main>

		<? include_once __DIR__.'/../parts/footer.php'; ?>

	</body>
</html>