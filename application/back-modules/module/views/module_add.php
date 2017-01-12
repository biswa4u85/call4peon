<?php include APPPATH . '/back-modules/views/header.php'; ?>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/module.js"></script>
<div class="col-md-12 his_upc">
    <div class="row">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#Mdetail" role="tab" data-toggle="tab">
                    <i class="fa fa-user" style="padding-right: 10px;border-right: 1px solid #d1d1d1;margin-right: 10px;"></i> Module Information
                </a>
            </li>            
            <?php if ($all[0]['iModuleId'] != '' && $all[0]['vRefTable'] != '') { ?>
                <li>
                    <a href="#cust" role="tab" data-toggle="tab">
                        <i class="fa fa-unlock-alt" style="padding-right: 10px;border-right: 1px solid #d1d1d1;margin-right: 10px;"></i> Customization
                    </a>
                </li>
            <?php } ?>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade active in" id="Mdetail">
                <div class="panel-wrapper collapse in" style="height: auto;">
                    <div>
                        <div class="common_whitebg">
                            <div class="col-md-12"> 
                                <form class="form-horizontal formclass" id="ModuleForm" name="ModuleForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>module/module_action">

                                    <div id="stickybutton" class="row sticky_div">
                                        <div class="col-md-12 text-center stick_btn">
                                            <div class="Left-Head">
                                                <h3><?php echo (!isset($iModuleId) && $mode == "add") ? 'Create' : ucfirst($mode); ?> Module</h3>
                                            </div>
                                            <div class="submit-Btn martop_10">
                                                <p>  
                                                    <button type="submit" class="btn btn-success" value="save" name="submit[]"><i class="fa fa-floppy-o"></i> Save</button>
                                                    <button type="submit" class="btn btn-info" value="savenew" name="submit[]"><i class="fa fa-file-text-o"></i> Save &amp; New </button> 
                                                    <button class="btn btn-danger" value="cancel" onclick="cancelAction();
                                                            return false;"><i class="fa fa-times"></i> Cancel</button>
                                                </p>
                                            </div>
                                        </div>                
                                    </div>


                                    <input type="hidden" id="iModuleId" name="iModuleId" <?php
                                    if (isset($all[0]['iModuleId'])) {
                                        echo "value='" . $all[0]['iModuleId'] . "'";
                                    }
                                    ?>>
                                    <input type="hidden" id="mode" name="mode" <?php
                                    echo "value='" . $mode . "'";
                                    ?>>

                                    <?php
                                    if (isset($iModuleId) && isset($frompage) && $frompage == "view") {
                                        echo '<input type="hidden" id="frompage" name="frompage" value="' . $frompage . '"  >';
                                    }
                                    ?>

                                    <div id="sortable">
                                        <div class="row">
                                            <div class="col-md-12 handle">
                                                <div class="form-box-main">
                                                    <h4 data-toggle="collapse" href="#modinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-sitemap"></i> Module Information <i class="fa fa-chevron-down pull-right text-grey"> </i>
                                                    </h4>
                                                    <div class="collapse in" id="modinfo">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-inner">
                                                                    <div class="form-group">
                                                                        <label for="vModule" class="col-sm-4 control-label">Module Name:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vModule" name="vModule" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vModule'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vModuleErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="iParentId" class="col-sm-4 control-label">Parent Module:</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" id="iParentId" name="iParentId">
                                                                                <option value="0">-none-</option>
                                                                                <?php
                                                                                foreach ($parents as $kp => $vp) {
                                                                                    echo '<option value="' . $vp['iModuleId'] . '" ' . ($vp['iModuleId'] == $all[0]['iParentId'] ? 'Selected' : '') . ' >' . $vp['vModule'] . '</option>';
                                                                                }
                                                                                ?>    
                                                                            </select>
                                                                        </div>   
                                                                        <span id="iParentIdErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="iMenuParentId" class="col-sm-4 control-label">Parent Menu:</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" id="iMenuParentId" name="iMenuParentId">
                                                                                <option value="0">-none-</option>
                                                                                <?php
                                                                                foreach ($parents as $kp => $vp) {
                                                                                    echo '<option value="' . $vp['iModuleId'] . '" ' . ($vp['iModuleId'] == $all[0]['iMenuParentId'] ? 'Selected' : '') . ' >' . $vp['vModule'] . '</option>';
                                                                                }
                                                                                ?>    
                                                                            </select>
                                                                        </div>   
                                                                        <span id="iMenuParentIdErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="iSequenceOrder" class="col-sm-4 control-label">Sequence Order:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="iSequenceOrder" name="iSequenceOrder" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['iSequenceOrder'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="iSequenceOrdereErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="vMenuDisplay" class="col-sm-4 control-label">Menu Display:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vMenuDisplay" name="vMenuDisplay" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vMenuDisplay'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vMenuDisplayErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="vImage" class="col-sm-4 control-label">Icon:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vImage" name="vImage" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vImage'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vImageErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="vURL" class="col-sm-4 control-label">URL:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vURL" name="vURL" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vURL'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vURLErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="vMainMenuCode" class="col-sm-4 control-label">MainMenu Code:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vMainMenuCode" name="vMainMenuCode" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vMainMenuCode'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vMainMenuCodeErr" class="help-block"></span>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-inner">                                                                    
                                                                    <div class="form-group">
                                                                        <label for="DisplayAsMenu" class="col-sm-4 control-label">Display As Menu:</label>
                                                                        <div class="col-sm-8">
                                                                            <div class="make-switch"  data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                                                                                <input type="hidden" name="DisplayAsMenu" id="DisplayAsMenu" value="0" <?php echo ($all[0]['DisplayAsMenu'] == '0') ? 'checked' : ''; ?>>
                                                                                <input type="checkbox" name="DisplayAsMenu" id="DisplayAsMenu" value="1" <?php echo ($all[0]['DisplayAsMenu'] != '0') ? 'checked' : ''; ?>>
                                                                            </div>
                                                                            <span id="DisplayAsMenuErr" class="help-block"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="DisplayAsSubMenu" class="col-sm-4 control-label">Display As SubMenu:</label>
                                                                        <div class="col-sm-8">
                                                                            <div class="make-switch"  data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                                                                                <input type="hidden" name="DisplayAsSubMenu" id="DisplayAsSubMenu" value="0" <?php echo ($all[0]['DisplayAsSubMenu'] == '0') ? 'checked' : ''; ?>>
                                                                                <input type="checkbox" name="DisplayAsSubMenu" id="DisplayAsSubMenu" value="1" <?php echo ($all[0]['DisplayAsSubMenu'] != '0') ? 'checked' : ''; ?>>
                                                                            </div>
                                                                            <span id="DisplayAsSubMenuErr" class="help-block"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="vSelectedMenu" class="col-sm-4 control-label">Selected Menu:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vSelectedMenu" name="vSelectedMenu" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vSelectedMenu'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vSelectedMenuErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="vRefTable" class="col-sm-4 control-label">Reference Table:</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control requiredview" id="vRefTable" name="vRefTable" placeholder=""<?php
                                                                            if (isset($all[0]['iModuleId'])) {
                                                                                echo "value='" . $all[0]['vRefTable'] . "'";
                                                                            }
                                                                            ?>>
                                                                        </div>
                                                                        <span id="vSelectedMenuErr" class="help-block"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="eMenuType" class="col-sm-4 control-label">Menu Type:</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" id="eMenuType" name="eMenuType">
                                                                                <?php
                                                                                foreach ($menutype as $mk => $mv) {
                                                                                    echo '<option value="' . $mv . '" ' . ($mv == $all[0]['eMenuType'] ? 'Selected' : '') . ' >' . $mv . '</option>';
                                                                                }
                                                                                ?>    
                                                                            </select>
                                                                        </div>                                                    
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="eStatus" class="col-sm-4 control-label">Status:</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" id="eStatus" name="eStatus">
                                                                                <?php
                                                                                foreach ($status as $statusk => $statusv) {
                                                                                    echo '<option value="' . $statusv . '" ' . ($statusv == $all[0]['eStatus'] ? 'Selected' : '') . ' >' . $statusv . '</option>';
                                                                                }
                                                                                ?>    
                                                                            </select>
                                                                        </div>                                                    
                                                                    </div>
                                                                </div>
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
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cust">
                <div class="panel-wrapper collapse in" style="height: auto;">
                    <div>
                        <div class="common_whitebg">
                            <div class="col-md-12">
                                <div id="stickybutton" class="row sticky_div">
                                    <div class="col-md-12 text-center stick_btn">
                                        <div class="Left-Head">
                                            <h3>Edit PageLayout</h3>
                                        </div>
                                        <div class="submit-Btn martop_10">
                                            <p>  
                                                <a href="javascript:void(0)" data-href="<?php echo $this->config->item('admin_site_url'); ?>section_add?secmodid=<?php echo $all[0]['iModuleId']; ?>&N=Add PageLayout" onclick="showformpage(this)" class="btn btn-success" value="save" name=""><i class="fa fa-floppy-o"></i> Create Section</a>                                 
                                            </p>
                                        </div>
                                    </div>                
                                </div>
                                <div id="total_column_div">
                                    <?php include APPPATH . '/back-modules/module/views/module_total_column.php'; ?>
                                </div>
                                <div id="module_pagelayout">
                                    <?php include APPPATH . '/back-modules/module/views/module_pagelayout.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>
<script>
    $(document).ready(function () {
        resetData()
    });
    function sort_columns() {
        $(".column").sortable({
            connectWith: ".column",
            handle: ".portlet-header",
            placeholder: "portlet-placeholder ui-corner-all",
            start: function (event, ui) {
                ui.item.startPos = ui.item.index();
            },
            stop: function () {

                var DIV_POSITION = 'positions';
                var order = [];
                $('.column').find('div.portlet-header').each(function (e) {
                    //var parent = $(this).parent().parent().closest('collapse in'); 
                    var sectionid = $(this).parent().parent().parent().parent().attr('id');
                    var colid = $(this).parent().parent().attr('id');

                    if (typeof ($(this).attr('id')) != 'undefined') {
                        var id = $(this).attr('id') + ',' + colid;
                        order.push([sectionid, id]);
                    }

                    if (sectionid == 0) {
                        $(this).parents('.portlet').addClass('col-md-2');
                        $(this).addClass('total_column');
                    } else {
                        $(this).parents('.portlet').removeClass('col-md-2');
                        $(this).removeClass('total_column');
                    }

                    // test.push([i, "lol"]);
                });
                var positions = order.join('|');
                //console.log(positions);
                setCookie(DIV_POSITION, positions, 10);
                $.ajax({
                    type: 'POST',
                    url: rootPath + 'module/changeOrder',
                    data: {positions: positions},
                    success: function (data) {
                        resetData();
                    }
                });
                //var positions = order.join(',');
                //  console.log("update" + positions);
            }
        });


        $(".column-section").sortable({
            connectWith: ".column-section",
            handle: ".portlet-section",
            placeholder: "portlet-placeholder ui-corner-all",
            start: function (event, ui) {
                ui.item.startPos = ui.item.index();
            },
            stop: function () {

                var SECTION_POSITION = 'positions';
                var order = [];
                $('.column-section').find('h4.portlet-section').each(function (e) {
                    //var parent = $(this).parent().parent().closest('collapse in'); 
                    var sectionid = $(this).parent().attr('id');
                    if (typeof (sectionid) != 'undefined') {
                        order.push(sectionid);
                    }
                    ;
                });
                var positions = order.join('|');
                setCookie(SECTION_POSITION, positions, 10);
                $.ajax({
                    type: 'POST',
                    url: rootPath + 'module/changeSectionOrder',
                    data: {positions: positions},
                    success: function (data) {
                        resetData();
                    }
                });
                //var positions = order.join(',');
                //  console.log("update" + positions);
            }
        });
    }

    function resetData() {
        $.ajax({
            type: 'POST',
            url: rootPath + 'module/getPageLayout',
            data: {module: $("#iModuleId").val()},
            success: function (data) {
                $("#module_pagelayout").empty();
                $("#module_pagelayout").append(data);
            }
        });
    }
</script>
