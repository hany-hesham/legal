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
				$login = array(
					'name'	=> 'login',
					'id'	=> 'login',
					'value' => set_value('login'),
					'maxlength'	=> 80,
					'size'	=> 30,
					'class' => 'form-control'
				);
				if ($this->config->item('use_username', 'tank_auth')) {
					$login_label = 'Email or login';
				} else {
					$login_label = 'Email';
				}
			?>
			<?php echo form_open($this->uri->uri_string()); ?>
            <form class="login-form" action="index.html" method="post">
                <h3 class="form-title">Forget your Password</h3>
                <div class="form-group">
					<div><?php echo form_label($login_label, $login['id']); ?></div>
					<div><?php echo form_input($login); ?></div>
                </div>
                <div class="alert alert-danger display-hide">
					<div style="color: red;">
						<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
					</div>
				</div>
                <div class="form-actions">
					<input class="col-lg-offset-4 col-md-offset-5 col-sm-offset-6 btn btn-primary" type="submit" name="reset" value="Get a new password">
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