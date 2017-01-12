<?php // include 'inc/config.php'; // Configuration php file ?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>error</title>

        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="img/favicon.ico">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="../public/styles/css/bootstrap.css">

        <!-- Related styles of various icon packs and javascript plugins -->
        <link rel="stylesheet" href="../public/styles/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="../public/styles/css/main.css">
        <link rel="stylesheet" href="../public/styles/css/dev-style.css">

        <!-- Load a specific file here from css/themes/ folder to alter the default theme of the template -->
        <?php if ($template['theme']) { ?>
        <link id="theme-link" rel="stylesheet" href="css/themes/<?php echo $template['theme']; ?>.css">
        <?php } ?>

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="../public/styles/css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
        <script src="../public/js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>
        <script>
            function cancelAction() {
                window.location.href = document.referrer
            }
        </script>
    </head>

    <body>
     
        <div class="error-container standalone themed-border-fire">
            <a href="javascript:void(0)" class="btn btn-success" onclick="cancelAction()"><i class="fa fa-chevron-left"></i> Go Back</a>
           
            <div class="error-text text-danger"> <h3><i class="fa fa-exclamation-triangle animate-360"></i> 404<?php echo $message;?></h3></div>
<!--            <form action="page_ready_search_results.php" method="post" class="error-search">
                <div class="input-group input-group-lg">
                    <input type="text" id="search-error-standalone" name="search-error-standalone" class="form-control" placeholder="Search..">
                    <span class="input-group-btn">
                        <button class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>-->
        </div>
    </body>
</html>