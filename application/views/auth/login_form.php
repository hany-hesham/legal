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
            <?php $login = array(
                'name'  => 'login',
                'id'    => 'login',
                'value' => set_value('login'),
                'maxlength' => 80,
                'size'  => 30,
                'class' => 'form-control'
            );
            if ($login_by_username AND $login_by_email) {
                $login_label = 'إيميل أو اسم المستخدم';
            } else if ($login_by_username) {
                $login_label = 'اسم المستخدم';
            } else {
                $login_label = 'إيميل';
            }
            $password = array(
                'name'  => 'password',
                'id'    => 'password',
                'size'  => 30,
                'class' => 'form-control'
            );
            $remember = array(
                'name'  => 'remember',
                'id'    => 'remember',
                'value' => 1,
                'checked'   => set_value('remember'),
                'style' => 'margin:0;padding:0',
            );
            $captcha = array(
                'name'  => 'captcha',
                'id'    => 'captcha',
                'maxlength' => 8,
                'class' => 'form-control'
            ); ?>
            <?php echo form_open($this->uri->uri_string()); ?>
            <form class="login-form" action="index.html" method="post">
                <h3 class="form-title">الدخول إلى حسابك</h3>
                <div class="alert alert-danger display-hide">
                    <div style="color: red;">
                        <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
                    </div>
                    <div style="color: red;">
                        <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
                    </div>
                    <div style="color: red;">
                        <?php echo form_error('recaptcha_response_field'); ?>
                    </div>
                    <div style="color: red;">
                        <?php echo form_error($captcha['name']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div><?php echo form_label($login_label, $login['id']); ?></div>
                    <div><?php echo form_input($login); ?></div>
                </div>
                <div class="form-group">
                    <div><?php echo form_label('كلمة السر', $password['id']); ?></div>
                    <div><?php echo form_password($password); ?></div>
                </div>
                <?php if ($show_captcha) {
                    if ($use_recaptcha) { ?>
                        <div class="col-lg-6 col-md-8 col-sm-10 form-group">
                            <div>
                                <div id="recaptcha_image"></div>
                            </div>
                            <div>
                                <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                <div class="recaptcha_only_if_image">
                                    <a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a>
                                </div>
                                <div class="recaptcha_only_if_audio">
                                    <a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-8 col-sm-10 form-group">
                            <div>
                                <div class="recaptcha_only_if_image">Enter the words above</div>
                                <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
                            </div>
                            <div><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></div>
                            <?php echo $recaptcha_html; ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-6 col-md-8 col-sm-10 form-group">
                            <div>
                                <p>Enter the code exactly as it appears:</p>
                                <?php echo $captcha_html; ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-8 col-sm-10 form-group">
                            <div><?php echo form_label('Confirmation Code', $captcha['id']); ?></div>
                            <div><?php echo form_input($captcha); ?></div>
                        </div>
                    <?php }
                } ?>
                <div class="form-actions">
                    <?php echo form_checkbox($remember); ?>
                    <?php echo form_label('تذكرني', $remember['id']); ?><br>
                    <?php //echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
                    <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
                    <input class="btn green pull-right" type="submit" name="submit" value="دخول">
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