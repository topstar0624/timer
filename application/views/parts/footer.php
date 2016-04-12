<!-- **************************************** フッター **************************************** -->
<footer>
	<ul>
		<li><a href="/" title="トップページ">トップページ</a></li>
		<li><a href="/about" title="このサイトについて">このサイトについて</a></li>
		<li><a href="/about/us" title="運営者情報">運営者情報</a></li>
		<li><a href="/about/rule" title="規約">規約</a></li>
		<li><a href="/about/policy" title="個人情報保護方針">個人情報保護方針</a></li>
		<li><a href="/about/sitemap" title="サイトマップ">サイトマップ</a></li>
		<li><a href="/contact" title="お問い合わせ">お問い合わせ</a></li>
	</ul>
	<hr />

	<p>
		Copyright&nbsp;&copy;&nbsp;2016&nbsp;
		<a href="/" title="サクッとタイマー">サクッとタイマー</a> &nbsp;All&nbsp;Rights&nbsp;Reserved
		<a href="/admin" target="_blank">.</a>
	</p>
</footer>

<? /* 全ページ共通のjsはここに書く */ ?>
	<script>
		$(function () {
			// titleの中身をh1に入れる
			var title_text = $('title').html();
			$('#h1_title').html(title_text);
		});
	</script>