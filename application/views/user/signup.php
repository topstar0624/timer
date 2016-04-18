<!DOCTYPE html>
<html lang="ja">
<head>
	<? include_once __DIR__.'/../parts/head.php'; ?>
		<meta name="description" content="タスク名と目標タイムを決めて、いざスタート！経過時間と残り時間がひと目で分かるから、時間内にサクッと仕事が片付くようになります。会員登録すれば、過去ログ管理も可能！">
	<title><? echo $title = '会員登録';?><?=TITLE_ADD?></title>
</head>
<body>
	<? include_once __DIR__.'/../parts/header.php'; ?>
	<main>
		<? include_once __DIR__.'/../parts/section_user-signup.php'; ?>
	</main>
	<? include_once __DIR__.'/../parts/footer.php'; ?>
</body>
</html>