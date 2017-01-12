<?php include APPPATH . '/front-modules/views/top.php'; ?>
<script>
    var client_id = '<?php echo $this->config->item('g_appid'); ?>';
</script>
<style>
    .dropzone-previews {
        position: relative;
        border: 1px solid rgba(0,0,0,0.08);
        background: rgba(0,0,0,0.02);
        padding: 1em;
        border-color: rgba(0,0,0,0.15);
        background: rgba(0,0,0,0.04);
    }
</style>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/css/select2.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>dropzone/assets/lib/css/dropzone.css"/>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>dropzone/assets/lib/js/dropzone.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/js/select2.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>dropzone/assets/custom/dropzone.init.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>custom/import_file.js"></script>
<!--<div>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->config->item('site_url'); ?>dashboard">Dashboard</a></li>
        
        <li class="active">Imports</li>        

    </ol>
    <div class="col-md-6 text-right">
    </div>
</div>-->

<div class="common_whitebg">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center stick_btn">
                <div class="Left-Head">
                    <h3>Import <?php
                        if ($_REQUEST['cs'] == "visa" || $_REQUEST['cs'] == "transport" || $_REQUEST['cs'] == "mealplan") {
                            echo ucfirst($_REQUEST['cs']);
                        } else {
                            echo ucfirst($_REQUEST['cs']) . 's';
                        }
                        ?></h3>
                </div>
            </div>                
        </div>
        <div class="row">
            <div class="col-md-12"> 
                <!-- Widget -->
                <div class="widget">
                    <div class="widget-body" id="importFromFile">
                        <p class="label label-stroke label-danger text-small border-none padding-left-none">We accept the CSV formats. You can can import 498 rows at a time.<br>
                            The first row in your file must contain column headers add your data, and import the file.<br/></p><br/>
                        <strong>Note: </strong> These fields are mandatory. <strong style="color:red;"><?php echo $mandatory_fields; ?></strong><br/><?php echo $extra_message; ?><br/>
                        <p class="label label-stroke label-success text-small border-none padding-left-none">
                            <a href="<?php echo $this->config->item('site_url') ?>samplefile?cs=<?php echo $_REQUEST['cs']; ?>" style="color: #FFFFFF" download="">Download the sample file</a></p>
                        <br/><br/>
                        <p id="clickable" class="label label-info label-stroke text-medium border-none padding-left-none" style="cursor:pointer;text-align: left;width: 100%;">Click here to select file / Drop file to upload</p>


                        <!--Dropzone -->
                        <div id="dropzone">
                            <form class="form-horizontal margin-none dropzone" action="<?php echo $this->config->item('site_url'); ?>import_export/import_csv" method="post" enctype="multipart/form-data"> 
                                <div class="fallback">
                                    <input type="file" name="csv" class="margin-none" accept=".csv" runat="server"/>
                                </div>
                            </form>
                        </div>
                        <!--            <div id="dropzone">
                                        <form class="dropzone" action="<?php echo $this->config->item('site_url'); ?>contact/import_csv" method="post" enctype="multipart/form-data"> 
                                            <input type="file" name="csv" class="margin-none" accept=".csv" runat="server"/>
                                        </form>
                                    </div>-->
                        <!--// Dropzone END -->
                    </div>
                    <div class="separator"></div>
                    <div class="widget-body innerAll">
                        <div id="final_form">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include APPPATH . '/front-modules/views/footer.php'; ?>
<!---->
