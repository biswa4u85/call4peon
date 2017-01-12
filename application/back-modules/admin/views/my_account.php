<?php
include APPPATH . '/back-modules/views/header.php';

$dateFormat = $this->config->item('date_format');
?>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>bootstrap-switch/assets/lib/css/bootstrap-switch.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/css/select2.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item('assets_url'); ?>gallery/blueimp-gallery/assets/lib/css/blueimp-gallery.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url'); ?>gallery/blueimp-gallery/assets/custom/blueimp-gallery.less" media="screen" />
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>select2/assets/lib/js/select2.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('assets_url'); ?>gallery/blueimp-gallery/assets/lib/js/jquery.blueimp-gallery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>custom/my_account.js"></script>

<div>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->config->item('admin_site_url'); ?>account">Account</a></li>
        <li class="active">My Account</li>
    </ol>
    <div class="col-md-6 text-right">
    </div>
</div>

<div class="common_whitebg">
    <div class="col-md-12"> 
        <form class="form-horizontal" id="myAccountForm" method="POST" action="<?php echo $this->config->item('site_url'); ?>admin/my_account_action" enctype="multipart/form-data">

            <div id="stickybutton" class="row sticky_div">
                <div class="col-md-12 text-center stick_btn">
                    <div class="Left-Head">
                        <h3>My Account</h3>
                    </div>
                    <div class="submit-Btn martop_10">
                        <p>  
                            <button class="btn btn-success" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                            <button class="btn btn-danger" value="cancel" name="submit[]" onclick="cancelAction();
                                    return false;"><i class="fa fa-times"></i> Cancel</button>
                        </p>
                    </div>
                </div>                
            </div>

            <input type="hidden" id="admin_id" name="admin_id" <?php
            if (isset($admin_id)) {
                echo "value='" . $admin_id . "'";
            }
            ?>>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-box-main mar-top">
                        <!--data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"<i class="fa fa-chevron-down pull-right text-grey"></i>-->
                        <h4><i class="fa fa-info"></i>Personal Information</h4>
                        <div class="collapse in" id="modinfo">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <div class="form-group">
                                            <label for="vName" class="col-sm-4 control-label"><span class="require">*</span>Name:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="vName" name="vName" placeholder=""<?php
                                                if (isset($admin_id)) {
                                                    echo "value='" . $all[0]['vName'] . "'";
                                                }
                                                ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vUserName" class="col-sm-4 control-label"><span class="require">*</span>UserName:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="vUserName" name="vUserName" placeholder=""<?php
                                                if (isset($admin_id)) {
                                                    echo "value='" . $all[0]['vUserName'] . "'";
                                                }
                                                ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <div class="form-group">
                                            <label for="vEmail" class="col-sm-4 control-label"><span class="require">*</span>Email:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="vEmail" name="vEmail" placeholder=""<?php
                                                if (isset($admin_id)) {
                                                    echo "value='" . $all[0]['vEmail'] . "'";
                                                }
                                                ?>>
                                            </div>
                                        </div>
                                        <!-- Group -->                       
                                        <?php if ($admin_id == '') { ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-4" for="columns-text">Profile Image:</label>
                                                <div class="col-md-8">
                                                    <input type="file" id="vImage" name="vImage" class="form-control" accept=".jpg,.jpeg,.gif,.png">
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group">
                                                <!-- Blueimp Gallery -->
                                                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                                                    <div class="slides"></div>
                                                    <h3 class="title"></h3>
                                                    <a class="prev no-ajaxify">‹</a>
                                                    <a class="next no-ajaxify">›</a>
                                                    <a class="close no-ajaxify">×</a>
                                                    <a class="play-pause no-ajaxify"></a>
                                                    <ol class="indicator"></ol>
                                                </div>
                                                <!-- // Blueimp Gallery END -->
                                                <label class="control-label col-md-4" for="columns-text">Profile Image:</label>
                                                <div class="col-md-8">
                                                    <div class="input-group gallery">
                                                        <?php
                                                        $img_url = '';

                                                        if ($all[0]['vImage'] != '') {
                                                            $img = 'admin/' . $admin_id . '/' . $all[0]['vImage'];

                                                            $img_path = $this->config->item('upload_path') . $img;
                                                            if (file_exists($img_path)) {
                                                                $img_url = $this->config->item('upload_url') . $img;
                                                            }
                                                        }
                                                        ?>
                                                        <input type="file" id="vImage" name="vImage" class="form-control"  style="<?php echo ($img_url != '') ? 'display:none' : ''; ?>" accept=".jpg,.jpeg,.gif,.png">
                                                        <button type="button" id="cancel" class="btn btn-primary" style="display:none; margin-top: 0.3em;"><i class="fa fa-times"></i></button>
                                                        <?php if ($img_url != '') { ?>
                                                            <div class="col-md-6" id="vProfileImg">
                                                                <a class="thumb no-ajaxify" href="<?php echo $img_url; ?>" data-gallery="gallery">
                                                                    <img src="<?php echo $this->config->item('upload_url') . 'admin/' . $admin_id. '/' . $all[0]['vImage']; ?>"  alt="photo" class="img-responsive"></a>
                                                                <button type="button" id="changeimg" class="btn btn-success"><i class="fa fa-repeat"></i></button>
                                                                <button type="button" id="Deleteimg" title="Delete" class="btn btn-danger" onclick="deleteimg()"><i class="fa fa-trash-o"></i></button>
                                                                <!-- // Gallery item END -->
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <!-- // Group END -->
                                    </div>                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>