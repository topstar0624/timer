<!DOCTYPE html>
<html lang="ja">

<head>
	<? include_once __DIR__.'/../parts/head.php'; ?>
		<meta name="description" content="タスク名と目標タイムを決めて、いざスタート！経過時間と残り時間がひと目で分かるから、時間内にサクッと仕事が片付くようになります。会員登録すれば、過去ログ管理も可能！">
		<title>ログイン&nbsp;|&nbsp;サクッとタイマー</title>
</head>

<body>

	<? include_once __DIR__.'/../parts/header.php'; ?>

		<main>

			<section id="section_user-login">
				<h1>ログイン</h1>
				<div class="block_inner">
					<?=validation_errors()?:''?>
						<form action="/user/login_validation" method="post">
							<dl>
								<dt>メールアドレス</dt>
								<dd>
									<input type="text" name="email" pattern="^[a-zA-Z0-9!$&*.=^`|~#%'+\/?_{}-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,4}$" title="半角英数字を使い、xxx@xxx.xxx の形式で入力してください" placeholder="半角英数字" required="required" value="<? if(isset($_POST['email'])) {echo $_POST['email'];} ?>" />
								</dd>
								<dt>パスワード</dt>
								<dd>
									<input type="password" name="pass" pattern="^[0-9A-Za-z]+$" title="半角英数字で入力してください" placeholder="半角英数字" required="required" />
								</dd>
							</dl>
							<div class="block_button-container">
								<button type="submit">ログイン</button>
							</div>
							<p><a href="/user/signup" title="会員登録">会員登録がお済みでない方はコチラ</a></p>
						</form>
				</div>
				<!-- /.block_inner -->
			</section>
			<!-- /#section_user-login -->
			<hr />

		</main>

		<? include_once __DIR__.'/../parts/footer.php'; ?>

</body>

</html>