<!DOCTYPE html>
<html lang="ja">
<head>
	<? include_once __DIR__.'/../parts/head.php'; ?>
	<meta name="description" content="タスク名と目標タイムを決めて、いざスタート！経過時間と残り時間がひと目で分かるから、時間内にサクッと仕事が片付くようになります。会員登録すれば、過去ログ管理も可能！">
	<title><?=SITE_NAME?></title>
</head>
<body>
	<? include_once __DIR__.'/../parts/header.php'; ?>
	<main>
		<section id="section_task-log">
			<h1>タスクログ</h1>
			<h2>2016年3月3日(木)</h2>
			<div class="block_inner">
				<h3>■タスク名タスク名タスク名</h3>
				<table>
					<tr>
						<th>目標タイム&nbsp;</th>
						<td>00:00</td>
					</tr>
					<tr>
						<th>合計タイム&nbsp;</th>
						<td>00:00（00:00オーバー）</td>
					</tr>
					<tr>
						<th>実行時間　&nbsp;</th>
						<td>00:00〜00:00</td>
					</tr>
				</table>
				<div class="block_hidden">
					<br />
				</div>
				<h3>■タスク名タスク名タスク名タスク名</h3>
				<table>
					<tr>
						<th>目標タイム&nbsp;</th>
						<td>00:00</td>
					</tr>
					<tr>
						<th>合計タイム&nbsp;</th>
						<td>00:00（00:00あまり！）</td>
					</tr>
					<tr>
						<th>実行時間　&nbsp;</th>
						<td>00:00〜00:00</td>
					</tr>
				</table>
				<div class="block_hidden">
					<br />
				</div>
				<h3>■タスク名タスク名タスク名タスク名タスク名</h3>
				<table>
					<tr>
						<th>目標タイム&nbsp;</th>
						<td>00:00</td>
					</tr>
					<tr>
						<th>合計タイム&nbsp;</th>
						<td>00:00（00:00あまり！）</td>
					</tr>
					<tr>
						<th>実行時間　&nbsp;</th>
						<td>00:00〜00:00</td>
					</tr>
				</table>
				<div class="block_hidden">
					<br />
				</div>
				<div class="block_hidden">──────────────────────────────</div>
				<div class="block_hidden">
					<br />
				</div>
			</div>
			<!-- /.block_inner -->
			<h2>2016年3月4日(金)</h2>
			<div class="block_inner">
				<h3>■タスク名タスク名タスク名</h3>
				<table>
					<tr>
						<th>目標タイム&nbsp;</th>
						<td>00:00</td>
					</tr>
					<tr>
						<th>合計タイム&nbsp;</th>
						<td>00:00（00:00あまり！）</td>
					</tr>
					<tr>
						<th>実行時間　&nbsp;</th>
						<td>00:00〜00:00</td>
					</tr>
				</table>
				<div class="block_hidden">
					<br />
				</div>
				<h3>■タスク名タスク名タスク名タスク名</h3>
				<table>
					<tr>
						<th>目標タイム&nbsp;</th>
						<td>00:00</td>
					</tr>
					<tr>
						<th>合計タイム&nbsp;</th>
						<td>00:00（00:00オーバー）</td>
					</tr>
					<tr>
						<th>実行時間　&nbsp;</th>
						<td>00:00〜00:00</td>
					</tr>
				</table>
				<div class="block_hidden">
					<br />
				</div>
				<h3>■タスク名タスク名タスク名タスク名タスク名</h3>
				<table>
					<tr>
						<th>目標タイム&nbsp;</th>
						<td>00:00</td>
					</tr>
					<tr>
						<th>合計タイム&nbsp;</th>
						<td>00:00（00:00あまり！）</td>
					</tr>
					<tr>
						<th>実行時間　&nbsp;</th>
						<td>00:00〜00:00&nbsp;<img src="/common/img/sample.gif" height="16px" /></td>
					</tr>
				</table>
				<div class="block_hidden">
					<br />
				</div>
				<div class="block_hidden">──────────────────────────────</div>
				<div class="block_hidden">
					<br />
				</div>
			</div>
			<!-- /.block_inner -->
		</section>
		<!-- /#section_tasklog -->
		<hr />

		<section id="section_task-timer">
			<h1>タイマー</h1>
			<div class="block_inner">
				<form name="form_timer" target="timer" action="/main/timer">
					<dl>
						<dt>タスク名</dt>
						<dd>
							<input type="text" name="title" placeholder="英単語10個覚える" />
						</dd>
						<dt>目標タイム</dt>
						<dd>
							<table>
								<tr>
									<td>
										<input type="number" name="hours" pattern="^[0-9]+$" placeholder="時" maxlength="2" onKeyup="this.value=this.value.replace(/\D|\d{3,}/,'')" />
									</td>
									<td width="10px" class="text-align_center">:</td>
									<td>
										<input type="number" name="minutes" pattern="^[0-9]+$" placeholder="分" maxlength="3" onKeyup="this.value=this.value.replace(/\D|\d{4,}/,'')" />
									</td>
								</tr>
							</table>
						</dd>
					</dl>
					<div class="block_button-container">
						<button type="submit" onclick="open_timer();">タイマースタート</button>
					</div>
				</form>
			</div>
			<!-- /.block_inner -->
		</section>
		<!-- /#section_tasktimer -->
		<hr />

		<? if(!isset($_SESSION['login'])) { ?>
			<? include_once __DIR__.'/../parts/section_user-signup.php'; ?>
		<? } ?>

	</main>
	<? include_once __DIR__.'/../parts/footer.php'; ?>
	<script>
		$(function () {
			//タイマー設定までスムーズスクロール
			$('html,body').animate({
				scrollTop: $('#section_task-timer').offset().top-40
			}, 1000, 'swing');
		});

		function open_timer() {
			var hours = parseInt($('[name=hours]').val());
			var minutes = parseInt($('[name=minutes]').val()) || 0;
			if (hours + minutes / 60 >= 24) {
				alert('24時間以上は設定できません');
				$('[name=hours]').val('');
				$('[name=minutes]').val('');
				return false;
			} else if (<?=$mobile?'true':'false';?> || $(window).width() * 1.05 < 600 || window.name == 'timer') {
				$('[name=form_timer]').attr('target', '_self');
				return false;
			} else {
				window.name = 'index';
				window.open('/main/timer', 'timer', 'width=320, height=480');
				location.reload();
				return false;
			}
		}
	</script>
</body>
</html>