<!doctype html>
<html class="no-js" ng-app="Call4peonApp">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $this->config->item('SITE_TITLE'); ?></title>

    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" href="<?php echo $this->config->item('back_assets_url'); ?>img/favicon.ico" type="image/x-icon" />        
    <?php include APPPATH . '/back-modules/views/common_files.php'; ?>
    
  </head>
  <body onload="onloadbody()">
  <div class="bg-dark dk" id="wrap">
      <div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container-fluid">
          <?php include APPPATH . '/back-modules/views/top.php'; ?>
          </div><!-- /.container-fluid -->
        </nav><!-- /.navbar -->
        <header class="head">
          <div class="search-bar">
            <form class="main-search" action="">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Live Search ...">
                <span class="input-group-btn">
            <button class="btn btn-primary btn-sm text-muted" type="button">
                <i class="fa fa-search"></i>
            </button>
        </span> 
              </div>
            </form><!-- /.main-search -->
          </div><!-- /.search-bar -->
          <div class="main-bar">
            <h3>
              <i class="fa fa-table"></i>&nbsp; <?php echo str_replace('-', ' ', $currentUrl) ; ?></h3>
          </div><!-- /.main-bar -->
        </header><!-- /.head -->
      </div><!-- /#top -->
      
      <?php if ($module != 'mailbox') { ?>
        <div id="left">
            <?php include APPPATH . '/back-modules/views/left.php'; ?>
        </div>
     <?php } ?>
   
      <div id="content">
        <div class="outer inner bg-light lter">                
        <?php include APPPATH . '/back-modules/views/loader.php'; ?>
        <div id="RightsideMain" style="display: none">

        