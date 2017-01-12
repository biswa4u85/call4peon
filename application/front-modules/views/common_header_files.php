<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="user-scalable = yes" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="call4peon - PRE-BOOKED INSTANT EXPRESS SERVICES">
<meta name="keywords" content="BOUQUET DELIVERY,CAKE DELIVERY,DOCUMENT DELIVERY,CHEQUE DEPOSIT/PICK-UP,GIFT DELIVERY,GROCERY DELIVERY,PICKUP AND DROP,INVITATION DELIVERY,MEDICINE DELIVERY">
<meta name="author" content="Biswajit Sahoo, Vijay Amin">

<title><?php echo $this->config->item('SITE_TITLE');?></title>

<!--================================FAVICON================================-->
<link rel="shortcut icon" href="<?php echo $this->config->item('front_assets_url'); ?>images/favicon.ico" type="image/x-icon">

<?php if(ENVIRONMENT == 'developments') { ?>
<!--================================BOOTSTRAP STYLE SHEETS================================-->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/bootstrap.min.css">

<!--================================ Main STYLE SHEETs====================================-->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/menu.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/color/color.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/responsive.css">

<!--================================FONTAWESOME==========================================-->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/font-awesome.css">

<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets_url'); ?>css/main.min.css">

<!--================================GOOGLE FONTS=========================================-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAB3IOEhIUhLrj8e9hDWxx6pVBSquLApEA"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
<script src="<?php echo $this->config->item('front_assets_url'); ?>js/autocomplete.js"></script>
<script src="<?php echo $this->config->item('front_assets_url'); ?>js/ng-upload.js"></script>

<script>
    var site_url = "<?php echo $this->config->item('site_url'); ?>";
    var upload_url = "<?php echo $this->config->item('upload_path'); ?>";
    var parent_url = (parseInt('<?php echo $this->session->userdata('iParentId'); ?>') > 0) ? true : false;
    var currentTimezone = "<?php echo $this->config->item('LBU_USER_TIME_ZONE'); ?>";
    var companyid = "<?php echo $this->config->item('YT_USER_COMPANY_ID'); ?>";
    var rootPath = "<?php echo $this->config->item('site_url'); ?>";
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
    var userid = '<?php echo $this->session->userdata('iUserId') ?>'; 
    var profimage = '<?php echo $this->session->userdata('vProfileImage') ?>'; 
    var profimagepath =  rootPath+'/public/upload/users/'+companyid+'/'+userid+'/'+profimage; 
    var fullimagepath =  rootPath+'/public/upload/users/'+companyid+'/'+userid+'/'; 
</script>

<!--================================JQuery===========================================-->      
<script type="text/javascript" src="<?php echo $this->config->item('front_assets_url'); ?>js/jquery-1.11.3.min.js"></script>
<script src="<?php echo $this->config->item('front_assets_url'); ?>js/jquery.js"></script><!-- jquery 1.11.2 -->
<script src="<?php echo $this->config->item('front_assets_url'); ?>js/jquery.validate.min.js"></script>