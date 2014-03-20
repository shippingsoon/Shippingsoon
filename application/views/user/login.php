<div class="wrapper login-wrapper <?php if (!$no_terminal):?>hide<?php endif ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form method="post" id="login-form" class="core-form" action="<?= base_url("user/login/$redirect_url?no_terminal=1") ?>" role="form">
					<div class="form-group">
						<input type="email" class="form-control input-lg" placeholder="Email address" maxlength="150" value="<?= set_value('email') ?>" id="email" name="email" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control input-lg" placeholder="Password" value="<?= set_value('password') ?>" id="password" name="password" required>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success btn-lg btn-block" value="Send" id="contact-button">
					</div>
				</form> <!-- /#login-form .core-form -->
			</div> <!-- /.col-md-4 -->
		</div> <!-- /.row  -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper .login-wrapper -->