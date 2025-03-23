<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Register a new member</p>

        <!-- iCheck  -->
        <link rel="stylesheet" href="<?php echo base_url('./assets/admin-lte-2/plugins/iCheck/square/blue.css') ?>">
        <script src="<?php echo base_url('./assets/admin-lte-2/plugins/jQuery/jQuery-2.2.0.min.js') ?>"></script>
        <script src="<?php echo base_url('./assets/admin-lte-2/plugins/iCheck/icheck.min.js') ?>"></script>
        <script>
            var s = $.noConflict();
            s(function () {
                s('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
            });
        </script>

        <?php echo form_open('page=login&act=cek_login') ?>

        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Full name">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Retype password">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
        <?php echo form_close() ?>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
        </div>
        <!-- /.social-auth-links -->

        <a href="#">I forgot my password</a><br/>
        <a href="<?php echo base_url('member/register.html') ?>" class="text-center">Register a new member</a><br/>
        <a href="<?php echo base_url('teacher/register.html') ?>" class="text-center">Register a new teacher</a>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
