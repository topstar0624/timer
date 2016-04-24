	<section id="section_user-signup">
		<h1><?=$title?></h1>
		<div class="block_inner">
			<?=validation_errors()?:''?>
			<? if(isset($message)) { echo '<p>'.$message.'</p>'; } ?>
			<form action="/user/signup_validation" method="post">
				<dl>
					<dt>メールアドレス</dt>
					<dd>
						<input type="text" name="email" pattern="^[a-zA-Z0-9!$&*.=^`|~#%'+\/?_{}-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,4}$" title="半角英数字を使い、xxx@xxx.xxx の形式で入力してください" placeholder="半角英数字" required="required" value="<? if(isset($_POST['email'])) {echo $_POST['email'];} ?>" />
					</dd>
					<dt>パスワード</dt>
					<dd>
						<input type="password" name="pass" pattern="^[0-9A-Za-z]+$" title="半角英数字で入力してください" placeholder="半角英数字" required="required" />
					</dd>
					<dt>パスワード再入力</dt>
					<dd>
						<input type="password" name="confirm_pass" pattern="^[0-9A-Za-z]+$" title="半角英数字で入力してください" placeholder="半角英数字" required="required" />
					</dd>
				</dl>
				<div class="block_button-container">
					<button type="submit">会員登録</button>
				</div>
			</form>
		</div>
		<!-- /.block_inner -->
	</section>
	<!-- /#section_user-signup -->
	<hr />
