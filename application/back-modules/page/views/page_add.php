<?php include APPPATH . '/back-modules/views/header.php'; ?>
<link rel="stylesheet" href="assets/lib/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css">
<script src="<?php echo $this->config->item('back_assets_url'); ?>lib/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js"></script>
<div class="row">
              <div class="col-lg-12">
                <div class="box">
                 <form class="form-horizontal formclass" id="pageForm" name="pageForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>page/page_add_action" enctype="multipart/form-data">
                  <header>
                    <div class="icons"><i class="fa fa-edit"></i></div>
                    <h5><?php echo (!isset($all[0]['iPageId']) && $mode == "add") ? 'Add Page' : ucfirst($mode) . ' Page'; ?></h5>
                    <div class="toolbar">
                         <button type="submit" class="btn btn-success btn-xs" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                         <button type="submit" class="btn btn-info btn-xs" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                         <button class="btn btn-danger btn-xs" value="cancel" onclick="cancelAction();
        return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                           
                    </div>
                  </header>
                    
                    
<div class="body">
<input type="hidden" id="iPageId" name="iPageId" <?php if (isset($all[0]['iPageId'])) {
                                        echo "value='" . $all[0]['iPageId'] . "'";
                                    }
                                    ?>>
                                    <input type="hidden" id="mode" name="mode" <?php
                                    echo "value='" . $mode . "'";
                                    ?>>
<div class="row">
    <div class="col-md-6">
        <div class="form-inner">
            <div class="form-group">
                <label for="user" class="col-sm-3 control-label"><sup class="text-danger">*</sup>Page Title:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control requiredview" id="pagetitle" name="pagetitle" placeholder=""<?php
                    if (isset($all[0]['vPageTitle'])) {
                        echo "value='" . $all[0]['vPageTitle'] . "'";
                    }
                    ?>>
                </div>                                                   
            </div>  
            
             <div class="form-group">
                <label for="status" class="col-sm-3 control-label"><sup class="text-danger">*</sup>Type:</label>
                <div class="col-sm-9">
                    <label><input type="radio" name="eType" id="Page" value="Page"  <?php echo (!empty($all[0]['eType']) && $all[0]['eType'] == "Page") ? "checked" : '' ?> class="flat-red" > Page&nbsp;&nbsp;</label>
                    <label><input type="radio" name="eType" id="Guide" value="Guide" <?php echo $all[0]['eType'] != "Page" ? "checked" : '' ?> class="flat-red"> Guide&nbsp;&nbsp;</label>
                </div>                                                    
            </div>
            
            

            <div class="form-group">
                <label for="user" class="col-sm-3 control-label">Image:</label>
                <div class="col-sm-9">
                    <input type="file" name="images" id="images"/>
                    <?php
                        if ($all[0]['vUrl'] != "") {
                            $file = $this->config->item('upload_path') . 'pages/' . $all[0]['iPageId'] . '/' . $all[0]['vUrl'];
                            if (file_exists($file)) {
                                ?>
                                <div class="col-md-2 pull-left">
                                    <img src="<?php echo $this->config->item('upload_url') . 'pages/' . $all[0]['iPageId'] . '/' . $all[0]['vUrl']; ?>" height="100" width="100"/>
                                </div>
                                <?php
                            }
                        }
                        ?>
                </div>                                                   
            </div>

            

        </div>
    </div>  
    <div class="col-md-6">
        <div class="form-group">
                <label for="user" class="col-sm-3 control-label"><sup class="text-danger">*</sup>Page Code:</label>
                <div class="col-sm-9">
                    <?php
                    if (isset($all[0]['vPageCode'])) {
                        //echo "value='" . $all[0]['vPageCode'] . "'";
                        echo "<input type='text' class='form-control requiredview' id='pagecode' name='pagecode' placeholder='" . $all[0]['vPageCode'] . "' value='" . $all[0]['vPageCode'] . "' readonly>";
                    } else {
                        echo "<input type='text' class='form-control requiredview' id='pagecode' name='pagecode' placeholder=''>";
                    }
                    ?>
                </div>                                                   
            </div>
     <div class="form-group">
                <label for="status" class="col-sm-3 control-label"><sup class="text-danger">*</sup>Status:</label>
                <div class="col-sm-9">
                    <select class="form-control" id="status" name="status">
                        <option value="Active" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Active") ? "selected" : '' ?>>Active</option>
                        <option value="Inactive" <?php echo (!empty($all[0]['eStatus']) && $all[0]['eStatus'] == "Inactive") ? "selected" : '' ?>>Inactive</option>
                    </select>
                </div>                                                    
            </div>
    </div>
    <div class="col-md-12">
        <div class="form-group show-guide">
                <h4 for="user" class="col-sm-12"><sup class="text-danger">*</sup>Page Content:</h4>
                <div class="col-sm-12">
                    <textarea id="tContent" class="form-control requiredview" rows="7" name="tContent"><?php
                        if (isset($all[0]['tContent'])) {
                            echo $all[0]['tContent'];
                        }
                        ?></textarea>
                    <span id="tContentErr" class="help-block"></span>
                </div>                                                   
            </div>
    </div>
    
    
    <div class="col-md-12">
        <div class="form-group show-page">
                <h4 for="user" class="col-sm-12"><sup class="text-danger">*</sup>Page Content:</h4>
                <div class="col-sm-12">
                    <textarea id="tContent" class="form-control ckeditor" rows="7" name="tContentCKe"><?php
                        if (isset($all[0]['tContent'])) {
                            echo $all[0]['tContent'];
                        }
                        ?></textarea>
                    <span id="tContentErr" class="help-block"></span>
                </div>                                                   
            </div>
    </div>
</div> 
 <div class="clearfix"></div>
    </div>
</form>
</div>
</div></div>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/pages.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>ckeditor/ckeditor.js"></script>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>