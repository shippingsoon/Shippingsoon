<div class="col-md-4">
	<form id="contact-form" class="carousel-form core-form transition" method="post" action="<?= base_url('contact/feedback') ?>" role="form">
		<div class="form-group">
			<input type="text" class="form-control input-lg white-glow" placeholder="Your name" maxlength="20" value="<?= set_value('name') ?>" id="name" name="name" required>
		</div>
		<div class="form-group">
			<input type="email" class="form-control input-lg white-glow" placeholder="Email address" maxlength="100" value="<?= set_value('email') ?>" id="email" name="email" required>
		</div>
		<div class="form-group">
			<textarea class="form-control input-lg white-glow" placeholder="Message goes here" rows="3" id="message" name="message" required><?= set_value('message') ?></textarea>
		</div>
		<div class="form-group hidden">
			<input type="text" maxlength="100" value="<?= set_value('ignore') ?>" placeholder="ignore me" id="ignore" name="ignore" />
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary btn-lg btn-block" value="Send" id="contact-button">
			<p class="help-block">To send, or not to send</p>
		</div>
	</form> <!-- /#contact-form .carousel-form .core-form -->
</div> <!-- /.col-md-4 -->