<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
    </head>
    <body class=" login">
        <div class="logo">
            <h1 class="font-white" style="color: white !important; font-weight: bolder; font-size: 56px;">الاجندة القانونية</h1> 
        </div>
        <div class="content">
			<?php
				$email = array(
					'name'	=> 'email',
					'id'	=> 'email',
					'value'	=> set_value('email'),
					'maxlength'	=> 80,
					'size'	=> 30,
				);
			?>
			<?php echo form_open($this->uri->uri_string()); ?>
			<form class="login-form" action="index.html" method="post">
                <h3 class="form-title">Email</h3>
                <div class="form-group">
					<div><?php echo form_label('Email Address', $email['id']); ?></div>
					<div><?php echo form_input($email); ?></div>
				</div>
                <div class="alert alert-danger display-hide">
					<div style="color: red;">
						<?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
					</div>
				</div>
                <div class="form-actions">
					<?php echo form_submit('send', 'Send'); ?>
					<?php echo form_close(); ?>
				</div>
			</form>
        </div>
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/pages/scripts/login-4.min.js" type="text/javascript"></script>
    </body>
</html>