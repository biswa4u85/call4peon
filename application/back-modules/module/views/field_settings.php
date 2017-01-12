<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>bootstrap-switch/assets/lib/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>bootstrap-switch/assets/custom/js/bootstrap-switch.init.js"></script>

<!--<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>backend/field_settings.js"></script>
<div class="common_whitebg">
    <div class="col-md-12"> 
        <form class="form-horizontal formclass" id="FieldSettingForm" method="POST" action="<?php echo $this->config->item('admin_site_url'); ?>module/field_settings_action" >

            <div  class="row sticky_div">
                <div class="col-md-12 text-center stick_btn" style="border: 0px; background: none;box-shadow: none" >
                    <div class="submit-Btn martop_10">
                        <p>
                            <button type="button" class="btn btn-success" value="save" name="submit" onclick="fieldSetting()" ><i class="fa fa-floppy-o"></i> Save</button>
                            <button type="button" class="btn btn-danger" onclick="closemodel()"><i class="fa fa-times"></i> Cancel</button>
                        </p>
                    </div>
                </div>
            </div>

            <input type="hidden" id="iModuleSettingsId" name="iModuleSettingsId" <?php
            if (isset($all[0]['iModuleSettingsId'])) {
                echo "value='" . $all[0]['iModuleSettingsId'] . "'";
            }
            ?>>
            <input type="hidden" id="iModuleId" name="iModuleId" <?php
            if (isset($all[0]['iModuleId'])) {
                echo "value='" . $all[0]['iModuleId'] . "'";
            }
            ?>>

            <input type="hidden" id="mode" name="mode" <?php
            echo "value='" . $mode . "'";
            ?>>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-box-main">
                        <h4 data-toggle="collapse" href="#fieldinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-university"></i>Custom Field Information<i class="fa fa-chevron-down pull-right text-grey"></i></h4>
                        <div class="form-inner collapse in" id="fieldinfo">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Module:</label>
                                <div class="col-sm-7">
                                    <label for="modulename" class="control-label"><?php echo $all[0]['eModule'] ?></label>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label for="iSectionId" class="col-sm-3 control-label">Section:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="iSectionId" id="iSectionId">
                                        <?php
                                        foreach ($sectype as $sectypek => $sectypev) {
                                            echo '<option value="' . $sectypev['iSectionId'] . '"' . ($sectypev['iSectionId'] == $all[0]['iSectionId'] ? 'Selected' : '') . '>' . $sectypev['vSectionName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="vLabel" class="col-sm-3 control-label"><span class="require">*</span>Label:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="vLabel" name="vLabel" placeholder="" <?php
                                    if (isset($all[0]['iModuleSettingsId'])) {
                                        echo "value='" . $all[0]['vLabel'] . "'";
                                    }
                                    ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="eType" class="col-sm-3 control-label">Type:</label>
                                <div class="col-sm-7">                          
                                    <select class="form-control" name="eType" id="eType">                                        
                                        <?php
                                        foreach ($type as $ktype => $vtype) {
                                            echo '<option value="' . $vtype . '"' . ($vtype == $all[0]['eType'] ? 'Selected' : '') . '>' . $vtype . '</option>';
                                        }
                                        ?>
                                    </select>                        
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label for="isMandatory" class="col-sm-3 control-label">Mandatory:</label>
                                <div class="col-sm-7">
                                    <div class="make-switch" data-off="info" data-on="success" data-on-label='Yes' data-off-label='No'>
                                        <input class="form-control" type='hidden' value='0' name='isMandatory'>
                                        <input type="checkbox" name="isMandatory" id="isMandatory" value="1" <?php
                                        if (isset($all[0]['iModuleSettingsId']) && $all[0]['isMandatory'] == '1') {
                                            echo 'checked';
                                        }
                                        ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isVisible" class="col-sm-3 control-label">Visible:</label>
                                <div class="col-sm-7">
                                    <div class="make-switch"  data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                                        <input type="hidden" name="isVisible" id="isVisible" value="0" <?php echo ($all[0]['isVisible'] == '0') ? 'checked' : ''; ?>>
                                        <input type="checkbox" name="isVisible" id="isVisible" value="1" <?php echo ($all[0]['isVisible'] != '0') ? 'checked' : ''; ?>>
                                    </div>
                                    <span id="isVisibleErr" class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isLocked" class="col-sm-3 control-label">Lock:</label>
                                <div class="col-sm-7">
                                    <div class="make-switch"  data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                                        <input type="hidden" name="isLocked" id="isLocked" value="0" <?php echo ($all[0]['isLocked'] == '0') ? 'checked' : ''; ?>>
                                        <input type="checkbox" name="isLocked" id="isLocked" value="1" <?php echo ($all[0]['isLocked'] != '0') ? 'checked' : ''; ?>>
                                    </div>
                                    <span id="isLockedErr" class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isChangable" class="col-sm-3 control-label">Changeable:</label>
                                <div class="col-sm-7">
                                    <div class="make-switch"  data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                                        <input type="hidden" name="isChangable" id="isChangable" value="0" <?php echo ($all[0]['isLocked'] == '0') ? 'checked' : ''; ?>>
                                        <input type="checkbox" name="isChangable" id="isChangable" value="1" <?php echo ($all[0]['isLocked'] != '0') ? 'checked' : ''; ?>>
                                    </div>
                                    <span id="isChangableErr" class="help-block"></span>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>