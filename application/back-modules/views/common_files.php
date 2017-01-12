    <!-- Bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?php echo $this->config->item('back_assets_url'); ?>css/main.css">

    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css">
    
    
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.1/css/datepicker3.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.0.1/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
      <script src="<?php echo $this->config->item('back_assets_url'); ?>lib/html5shiv/html5shiv.js"></script>
      <script src="<?php echo $this->config->item('back_assets_url'); ?>lib/respond/respond.min.js"></script>
      <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
    
    <!--Modernizr-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>multiselect/assets/lib/css/jq.multi-select.css"/>


<script>
    var admin_url = "<?php echo $this->config->item('admin_url'); ?>";
    var site_url = "<?php echo $this->config->item('admin_site_url'); ?>";
    var parent_url = (parseInt('<?php echo $this->session->userdata('iParentId'); ?>') > 0) ? true : false;
    var currentTimezone = "<?php echo $this->config->item('LBU_USER_TIME_ZONE'); ?>";
    var companyid = "<?php echo $this->config->item('YT_USER_COMPANY_ID'); ?>";
    var rootPath = "<?php echo $this->config->item('admin_site_url'); ?>";
    var imagesUrl = "<?php echo $this->config->item('images_url'); ?>";
    var commonPath = '<?php echo $this->config->item('js_url'); ?>';
    var componentsPath = '<?php echo $this->config->item('js_url'); ?>';
    var fb_appid = '<?php echo $this->config->item('fb_appid'); ?>';
    var curdatetime = '<?php echo $this->general->getCurrentDateTime(); ?>';
    var curdate = '<?php echo $this->general->getCurrentDateTime('Y-m-d'); ?>';
    var curdatetime_ms = '<?php echo strtotime($this->general->getCurrentDateTime('Y-m-d H:i')) * 1000; ?>';
    var curdate_ms = '<?php echo strtotime($this->general->getCurrentDateTime('Y-m-d')) * 1000; ?>';
    var prevdate_ms = '<?php echo strtotime($this->general->getDate(date('Y-m-d', strtotime("-1 days")))) * 1000; ?>';
    var timeout = '<?php echo $this->config->item('SESSION_TIMEOUT'); ?>';
    var ownname = '<?php echo trim($this->config->item('YT_USER_NAME')); ?>'; 
    var userid = '<?php echo $this->session->userdata('iAdminId') ?>'; 
    var profimage = '<?php echo $this->session->userdata('vProfileImage') ?>'; 
    var profimagepath =  rootPath+'/public/upload/users/'+companyid+'/'+userid+'/'+profimage; 
    var fullimagepath =  rootPath+'/public/upload/users/'+companyid+'/'+userid+'/'; 
</script> 

    <!--jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>!window.jQuery && document.write('<script src="jquery-1.4.2.min.js"><\/script>')</script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.4/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.18.4/js/jquery.tablesorter.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.1/js/bootstrap-datepicker.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.0.1/js/bootstrap-colorpicker.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
    
    
    
    <!--Bootstrap -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- MetisMenu -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.js"></script>

    <!-- Screenfull -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/screenfull.js/2.0.0/screenfull.min.js"></script>
    
    <script src="<?php echo $this->config->item('back_assets_url'); ?>/lib/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Metis core scripts -->
    <script src="<?php echo $this->config->item('back_assets_url'); ?>js/core.min.js"></script>

    <script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>multiselect/assets/lib/js/jq.multi-select.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/admin/general.js"></script>
