<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $this->config->item('SITE_TITLE'); ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    
    <link rel="shortcut icon" href="<?php echo $this->config->item('back_assets_url'); ?>img/favicon.ico" type="image/x-icon">
    
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?php echo $this->config->item('back_assets_url'); ?>css/main.css">
    
    <!--jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    
    <script>
            var site_url = "<?php echo $this->config->item('site_url'); ?>";
    </script>
  </head>
  <body class="login">
    <div class="form-signin">
      <div class="text-center">
        <img src="<?php echo $this->config->item('back_assets_url');?>img/logo.png" alt="Metis Logo">
      </div>
      <hr>
      <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form action="admin/login_action" method="POST" id="login_form" autocomplete="off">
             <p class="text-muted text-center">Enter your username and password</p>
                <input type="text" class="form-control top" id="login-email" name="login-email" placeholder="Enter Email" value="<?php echo $vUserName; ?>" autocomplete="off">
                <input type="password" class="form-control bottom" id="login-password" name="login-password" placeholder="Enter Password" value="<?php echo $vPassword; ?>" autocomplete="off">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="login-remember-me" <?php echo ($eRemember == 'On') ? 'checked="checked"' : ''; ?> >Remember my details
                </label>
            </div>
            <div class="form-actions text-center">
                <button type="submit" class="btn btn-lg btn-success btn-block"><i class="fa fa-lock"></i> Login</button>
            </div>
        </form>
        </div>
        <div id="forgot" class="tab-pane">
            <form action="admin/forgotpassword_action" method="POST" id="forgot_password" autocomplete="off">
                <p class="text-muted text-center">Enter your valid Username/Email</p>
                <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Enter Username/Email" autocomplete="off" required="">
                                                         
                <div class="form-actions text-center">
                    <button type="submit" class="btn btn-lg btn-danger btn-block">Recover Password</button>
                </div>
            </form>
        </div>
        <div id="signup" class="tab-pane">
          <form action="index.html">
            <input type="text" placeholder="username" class="form-control top">
            <input type="email" placeholder="mail@domain.com" class="form-control middle">
            <input type="password" placeholder="password" class="form-control middle">
            <input type="password" placeholder="re-password" class="form-control bottom">
            <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
          </form>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a class="text-muted" href="<?php echo $this->config->item('site_url'); ?>">Home</a>  </li>
          <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a>  </li>
          <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a>  </li>
          <!--<li> <a class="text-muted" href="#signup" data-toggle="tab">Signup</a></li>-->
        </ul>
      </div>
    </div>
      
    <!--Bootstrap -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      (function($) {
        $(document).ready(function() {
          $('.list-inline li > a').click(function() {
            var activeForm = $(this).attr('href') + ' > form';
            //console.log(activeForm);
            $(activeForm).addClass('animated fadeIn');
            //set timer to 1 seconds, after that, unload the animate animation
            setTimeout(function() {
              $(activeForm).removeClass('animated fadeIn');
            }, 1000);
          });
        });
      })(jQuery);
    </script>
  </body>
</html>
<?php include APPPATH . '/back-modules/views/notification_message.php'; ?>