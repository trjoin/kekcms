<div class="account-container stacked">
	<div class="content clearfix">
		<form method="POST" />
			<h1>Bejelentkezés</h1>		
			<div class="login-fields">
				<p>Kérem adja meg a bejelentkezési adatait:</p>
				<?php echo $error; ?>
				<div class="field">
					<label for="username">Felhasználónév:</label>
					<input type="text" id="username" name="username" value="" placeholder="felhasználónév" class="login username-field" />
				</div>
				<div class="field">
					<label for="password">Jelszó:</label>
					<input type="password" id="password" name="password" value="" placeholder="jelszó" class="login password-field" />
				</div>
			</div>
			<div class="login-actions">
				<button class="button btn btn-warning btn-large">BEJELENTKEZÉS</button>
			</div>
		</form>
	</div>
</div>