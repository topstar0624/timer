<!DOCTYPE html>
<html lang="ja">

<head>
	<? include_once __DIR__.'/../parts/head.php'; ?>
		<meta name="description" content="タスク名と目標タイムを決めて、いざスタート！経過時間と残り時間がひと目で分かるから、時間内にサクッと仕事が片付くようになります。会員登録すれば、過去ログ管理も可能！">
		<title>カウント&nbsp;|&nbsp;サクッとタイマー</title>
</head>

<body>

	<? include_once __DIR__.'/../parts/header.php'; ?>

		<main>

			<section id="section_timer">
				<form action="/" method="post">
					<input type="hidden" name="time_limit" />
					<input type="hidden" name="time_total" />
					<input type="hidden" name="start" />
					<input type="hidden" name="stop" />
					<input type="hidden" name="ticket" value="<?=$ticket?>" />
					<div id="block_timer-title">
						<p>
							<? if(empty($_GET['title'])) { ?>
								本日1つめのタスク
								<input type="hidden" name="title" value="本日1つめのタスク" />
								<? } else { ?>
									<?=$_GET['title']?>
										<input type="hidden" name="title" value="<?=htmlspecialchars($_GET['title'], ENT_QUOTES)?>" />
										<? } ?>
						</p>
					</div>
					<!-- /#block_timer-title -->
					<? if(empty($_GET['hours']) && empty($_GET['minutes'])) { ?>
						<? } else { ?>
							<div id="block_timer-limit">
								<div class="block_inner">
									<table>
										<tr>
											<td>目標</td>
											<td class="td_time"></td>
											<td></td>
										</tr>
									</table>
								</div>
								<!-- /.block_inner -->
							</div>
							<!-- /#block_timer-limit -->
							<? } ?>
								<div id="block_timer-elapse">
									<div class="block_inner">
										<table>
											<tr>
												<td></td>
												<td class="td_time"></td>
												<td>経過</td>
											</tr>
										</table>
									</div>
									<!-- /.block_inner -->
								</div>
								<!-- /#block_timer-limit -->
								<? if(empty($_GET['hours']) && empty($_GET['minutes'])) { ?>
									<? } else { ?>
										<div id="block_timer-subtract">
											<div class="block_inner">
												<table>
													<tr>
														<td>残り</td>
														<td class="td_time"></td>
														<td></td>
													</tr>
												</table>
											</div>
											<!-- /.block_inner -->
										</div>
										<!-- /#block_timer-limit -->
										<? } ?>
											<div class="block_inner">
												<div class="block_button-container">
													<button type="submit" onclick="stop_timer();">ストップ</button>
													<button type="button" onclick="restart_timer();" class="button_back">はじめからやり直し</button>
													<button type="button" onclick="closed_timer();" class="button_next">閉じる</button>
												</div>
											</div>
											<!-- /.block_inner -->
				</form>
			</section>
			<!-- /#section_timer -->
			<hr />

		</main>

		<? include_once __DIR__.'/../parts/footer.php'; ?>

			<script>
				$(function () {
					var limitHours = parseInt(<?=$_GET['hours']?:0?>);
					var limitMinutes = parseInt(<?=$_GET['minutes']?:0?>);

					//目標時間を表示
					if (limitMinutes >= 60) {
						limitHours = limitHours + Math.floor(limitMinutes / 60);
						limitMinutes = limitMinutes % 60;
					}
					limitHours = ("00" + limitHours).slice(-2); //経過分数
					limitMinutes = ("00" + limitMinutes).slice(-2); //経過分数
					$("#block_timer-limit .td_time").html(limitHours + "<small>:</small>" + limitMinutes + "<small>:00</small>");

					//タイマー開始時刻を設定
					startTime = new Date();
					$('input[name="start"]').val(dateFormat(startTime));

					//タイマー終了予定時刻を設定
					if (limitHours != 0 || limitMinutes != 0) {
						estimatedTime = getEstimatedTime(limitHours, limitMinutes);

						function getEstimatedTime(limitHours, limitMinutes) {
							var limitTotalSecond = ((limitHours * 60 * 60) + (limitMinutes * 60));
							$('input[name="time_limit"]').val(limitTotalSecond);
							var limitTotalMillisecond = limitTotalSecond * 1000;
							var estimatedTime = new Date(); //現在日時を取得してdatetimeに代入
							return new Date(estimatedTime.setTime(estimatedTime.getTime() + limitTotalMillisecond));
						}
					}

					countTimer();
				});

				function countTimer() {
					var nowTime = new Date(); //現在日時
					var millisecond = 24 * 60 * 60 * 1000; //ミリ秒計算用

					//経過時間
					var elapseTime = nowTime - startTime + 500; //現在時刻と開始時刻の差を取得
					var elapseHours = ("00" + Math.floor(elapseTime % millisecond / (60 * 60 * 1000)) % 60).slice(-2); //残り時間
					var elapseMinutes = ("00" + Math.floor(elapseTime % millisecond / (60 * 1000)) % 60).slice(-2); //経過分数
					var elapseSecond = ("00" + Math.floor(elapseTime % millisecond / 1000) % 60).slice(-2); //経過分数
					$('#block_timer-elapse .td_time').html(elapseHours + '<small>:</small>' + elapseMinutes + '<small>:' + elapseSecond + '</small>');
					var elapseTotalSecond = Math.floor(elapseTime % millisecond / 1000); //経過秒数
					$('input[name="time_total"]').val(elapseTotalSecond);

					//タイマー終了予定時刻(目標時間)がある場合
					if (typeof estimatedTime !== 'undefined') {
						if (estimatedTime > nowTime) {

							//残り時間
							var subtractTime = estimatedTime - nowTime + 500; //終了予定時刻と現在時刻の差を取得
							var subtractHours = ('00' + Math.floor(subtractTime % millisecond / (60 * 60 * 1000)) % 60).slice(-2); //残り時間
							var subtractMinutes = ('00' + Math.floor(subtractTime % millisecond / (60 * 1000)) % 60).slice(-2); //残り分数
							var subtractSecond = ('00' + Math.floor(subtractTime % millisecond / 1000) % 60).slice(-2); //経過分数
							$('#block_timer-subtract .td_time').html(subtractHours + '<small>:</small>' + subtractMinutes + '<small>:' + subtractSecond + '</small>');

						} else {

							//超過時間
							var overTime = nowTime - estimatedTime + 500; //終了予定時刻と現在時刻の差を取得
							var overHours = ('00' + Math.floor(overTime % millisecond / (60 * 60 * 1000)) % 60).slice(-2); //残り時間
							var overMinutes = ('00' + Math.floor(overTime % millisecond / (60 * 1000)) % 60).slice(-2); //残り分数
							var overSecond = ('00' + Math.floor(overTime % millisecond / 1000) % 60).slice(-2); //経過分数
							$('#block_timer-subtract').addClass('over');
							$('#block_timer-subtract td:first').text('');
							$('#block_timer-subtract .td_time').html(overHours + '<small>:</small>' + overMinutes + '<small>:' + overSecond + '</small>');
							$('#block_timer-subtract td:last').text('超過');

						}
					}

					//繰り返す
					setTimeout('countTimer()', 500);
				}

				function dateFormat(date) {
					var y = date.getFullYear();
					var m = ('0' + (date.getMonth() + 1)).slice(-2);
					var d = ('0' + date.getDate()).slice(-2);
					var h = date.getHours();
					var i = date.getMinutes();
					var s = date.getSeconds();
					return y + '-' + m + '-' + d + ' ' + h + ':' + i + ':' + s;
				}

				function stop_timer() {
					//タイマー終了時刻を設定
					stopTime = new Date();
					$('input[name="stop"]').val(dateFormat(stopTime));

					//親ウインドウがあればリロードさせる
					if (window.opener || !window.opener.closed) {
						window.opener.location.reload();
					}
				}

				function restart_timer() {
					if (!confirm('はじめからカウントをやり直しますか？')) {
						return false;
					} else {
						location.reload();
					}
				}

				function closed_timer() {
					if (!confirm('カウントを削除してこのウインドゥを閉じますか？')) {
						return false;
					} else {
						window.close();
					}
				}

				$('a').on('click', function () {
					if (!confirm('カウントを削除して別のページに移動しますか？')) {
						return false;
					}
				});
			</script>
</body>

</html>