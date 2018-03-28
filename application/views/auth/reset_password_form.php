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
				$new_password = array(
					'name'	=> 'new_password',
					'id'	=> 'new_password',
					'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
					'size'	=> 30,
					'class' => 'form-control'
				);
				$confirm_new_password = array(
					'name'	=> 'confirm_new_password',
					'id'	=> 'confirm_new_password',
					'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
					'size' 	=> 30,
					'class' => 'form-control'
				);
			?>
			<?php echo form_open($this->uri->uri_string()); ?>
			<form class="login-form" action="index.html" method="post">
                <h3 class="form-title">New Password</h3>
                <div class="form-group">
					<div><?php echo form_label('New Password', $new_password['id']); ?></div>
					<div><?php echo form_password($new_password); ?></div>
				</div>
                <div class="alert alert-danger display-hide">
					<div style="color: red;">
						<?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
					</div>
				</div>
                <div class="form-group">
					<div><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?></div>
					<div><?php echo form_password($confirm_new_password); ?></div>
				</div>
                <div class="alert alert-danger display-hide">
					<div style="color: red;">
						<?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?>
					</div>
				</div>
                <div class="form-actions">
					<input class="col-lg-offset-4 col-md-offset-5 col-sm-offset-6 btn btn-primary" type="submit" name="change" value="Change Password">
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