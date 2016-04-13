<div class="login-box">

	<div class="login-logo"><b><?php echo $site_name; ?></b></div>

	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session </p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs3_text('Username', 'username', ''); ?>
			<?php echo $form->bs3_password('Password', 'password', ''); ?>
			<div class="row">
				<div class="col-xs-4">
					<?php echo $form->bs3_submit('Log In', 'btn btn-primary btn-block btn-flat'); ?>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>

</div>