<!DOCTYPE html>
<html lang="ja">
<head>
	<? include_once __DIR__.'/../parts/head.php'; ?>
	<meta name="robots" content="none" />
	<title><? echo $title = '管理画面';?><?=TITLE_ADD?></title>
</head>
<body>
	<? include_once __DIR__.'/../parts/header.php'; ?>
	<main>
		<section>
			<h1><?=$title?></h1>
			<div class="block_inner">
				<ul>
					<li><a href="/manage/create_table/temp_user_table">/manage/create_table/temp_user_table</a></li>
					<li><a href="/manage/drop_table/temp_user_table">/manage/drop_table/temp_user_table</a></li>
					<li><a href="/manage/create_table/user_table">/manage/create_table/user_table</a></li>
					<li><a href="/manage/drop_table/user_table">/manage/drop_table/user_table</a></li>
					<li><a href="/manage/create_table/task_table">/manage/create_table/task_table</a></li>
					<li><a href="/manage/drop_table/task_table">/manage/drop_table/task_table</a></li>
				</ul>
			</div>
			<!-- /.block_inner -->
		</section>
		<hr />
	</main>
	<? include_once __DIR__.'/../parts/footer.php'; ?>
</body>
</html>
