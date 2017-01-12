<?php 
include APPPATH . '/config/config.php';
$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
$base_url .= '://' . $_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$site_url = str_replace('admin/', '', $base_url);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>404</title>
    <link rel="shortcut icon" href="<?php echo $config['back_assets_url']; ?>img/favicon.ico" type="image/x-icon" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?php echo $config['back_assets_url']; ?>css/main.css">
  </head>
  <body class="error">
    <div class="container">
      <div class="col-lg-8 col-lg-offset-2 text-center">
        <div class="logo">
          <h1>404</h1>
        </div>
        <p class="lead text-muted">Oops, an error has occurred. Forbidden!</p>
        <div class="clearfix"></div>
        <div class="col-lg-6 col-lg-offset-3">
          <form action="<?php echo $config['base_url']; ?>">
            <div class="input-group">
              <input type="text" placeholder="search ..." class="form-control">
              <span class="input-group-btn">
              <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
            </div>
          </form>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-lg-6 col-lg-offset-3">
          <div class="btn-group btn-group-justified">
            <a href="<?php echo $base_url; ?>" class="btn btn-info">Return Dashboard</a>
            <a href="<?php echo $site_url; ?>" class="btn btn-warning">Return Website</a>
          </div>
        </div>
      </div><!-- /.col-lg-8 col-offset-2 -->
    </div>
  </body>
</html>