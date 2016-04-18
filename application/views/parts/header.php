<!-- jQueryでtitleの中身が#h1に入る -->
<h1 id="h1"><?=SITE_NAME?></h1>

<header>
	<a href="/" title="トップページ" id="a_logo" class="button">
		<span>サクッと</span><span>タイマー</span>
	</a>
	<nav>
		<h1>ナビゲーション</h1>
		<? if(isset($_SESSION['login'])) { ?>
			<ul>
				<li><a href="/user/mypage" title="マイページ"><i class="material-icons">&#xE8B8;</i>マイページ</a></li>
				<li><a href="/user/logout" title="ログアウト"><i class="material-icons">&#xE566;</i>ログアウト</a></li>
			</ul>
		<? } else { ?>
			<ul>
				<li><a href="/user/login" title="ログイン"><i class="material-icons">&#xE5C8;</i>ログイン</a></li>
				<li><a href="/user/signup" title="会員登録"><i class="material-icons">&#xE897;</i>会員登録</a></li>
			</ul>
		<? } ?>
	</nav>
</header>
<hr />
