<div class="wrapper login-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form method="post" id="login-form" class="core-form" action="<?= base_url('user/register') ?>" role="form">
					<div class="form-group">
						<input type="text" class="form-control input-lg" placeholder="User name" maxlength="150" value="<?= set_value('user_name') ?>" id="user_name" name="user_name" required>
					</div>
					<div class="form-group">
						<input type="email" class="form-control input-lg" placeholder="Email address" maxlength="150" value="<?= set_value('email') ?>" id="email" name="email" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control input-lg" placeholder="Password" value="<?= set_value('password') ?>" id="password" name="password" required>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success btn-lg btn-block" value="Send">
					</div>
					<input type="hidden" name="ignore" value="i"/>
				</form> <!-- /#login-form .core-form -->
			</div> <!-- /.col-md-12 -->
		</div> <!-- /.row  -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper .login-wrapper -->