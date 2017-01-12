<link rel="stylesheet" href="<?php echo $this->config->item('bootstrap_url'); ?>bootstrap-switch/assets/lib/css/bootstrap-switch.css"/>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>bootstrap-switch/assets/lib/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('bootstrap_url'); ?>bootstrap-switch/assets/custom/js/bootstrap-switch.init.js"></script>
<div class="common_whitebg">
    <div class="col-md-12"> 
        <form class="form-horizontal" id="SectionForm" name="SectionForm" method="POST" action="">

            <div id="stickybutton" class="row sticky_div">
                <div class="col-md-12 text-center">                                            
                    <div class="submit-Btn martop_10">
                        <p>  
                            <button class="btn btn-success" value="save" onclick="addSection(this)"><i class="fa fa-floppy-o"></i> Save</button>
                            <button class="btn btn-danger" value="cancel" name="submit[]" onclick="cancelAction();
                                    return false;"><i class="fa fa-times"></i> Cancel</button>
                        </p>
                    </div>
                </div>                
            </div>

            <input type="hidden" id="isectionid" name="isectionid" <?php
            if (isset($all[0]['iSectionId'])) {
                echo "value='" . $all[0]['iSectionId'] . "'";
            }
            ?>>
            <input type="hidden" id="scecount" name="scecount" value="<?php echo $total; ?>">
            <input type="hidden" id="secmodid" name="secmodid" value="<?php echo $secmodid; ?>">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-box-main mar-top">
                        <h4 data-toggle="collapse" href="#secinfo" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-info"></i>Personal Information<i class="fa fa-chevron-down pull-right text-grey"></i></h4>
                        <div class="collapse in" id="secinfo">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inner">                                        
                                        <div class="form-group">
                                            <label for="vSectionName" class="col-sm-4 control-label">Section Name:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="vSectionName" name="vSectionName" placeholder=""<?php
                                                if (isset($all[0]['iSectionId'])) {
                                                    echo "value='" . $all[0]['vSectionName'] . "'";
                                                }
                                                ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="eColumnLayoutType" class="col-sm-4 control-label">Column Layout Type:</label>
                                            <div class="col-sm-8">                          
                                                <select class="form-control" name="eColumnLayoutType" id="eColumnLayoutType">
                                                    <?php
                                                    foreach ($coltype as $colk => $colval) {
                                                        echo '<option value="' . $colval . '" ' . ($colval == $all[0]['eColumnLayoutType'] ? 'Selected' : '') . ' >' . $colval . '</option>';
                                                    }
                                                    ?>
                                                </select>                        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vIcon" class="col-sm-4 control-label"><span class="require">*</span>Icon:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="vIcon" name="vIcon" placeholder=""<?php
                                                if (isset($all[0]['iSectionId'])) {
                                                    echo "value='" . $all[0]['vIcon'] . "'";
                                                }
                                                ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="isChangable" class="col-sm-4 control-label">Changeable:</label>
                                            <div class="col-sm-8">
                                                <div class="make-switch" style="width: 135px;" data-off="info" data-on="success" data-on-label="Yes" data-off-label="No">
                                                    <input type="hidden" name="isChangable" id="isChangable" value="0" <?php echo ($all[0]['isChangable'] == '0') ? 'checked' : ''; ?>>
                                                    <input type="checkbox" name="isChangable" id="isChangable" value="1" <?php echo ($all[0]['isChangable'] != '0') ? 'checked' : ''; ?>>
                                                </div>
                                                <span id="isChangableErr" class="help-block"></span>
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


<!--<link rel="stylesheet" href="<?php //echo $this->config->item('css_url');      ?>dev_style.css"/>-->
<script>
    $(document).ready(function () {
        $("#SectionForm").validate({
            // Specify the validation rules
            rules: {
                vSectionName: "required",
                vIcon: "required"            
            },
            // Specify the validation error messages
            messages: {
                vSectionName: "Please enter Section Name",
                vIcon: "Please enter Icon Name"
            },
            submitHandler: function (form) {
                //ajaxformsubmit(form);                
                var str = $("#SectionForm").serialize();
		    $.ajax({
			type: 'POST',
			async: false,
			url: rootPath + 'module/section_add_action',
			data: {value: str, formtype: 'ajax'},
			success: function (data) {                            
			    $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
			    $(':button[type="submit"]').attr('disabled', true);
			    $('#formClose').trigger('click');
			    $('#viewformiframe').html('')
                            resetData();
                            
			}
		    });                
            },
            showErrors: function (map, list)
            {
                this.currentElements.parents('label:first, div:first').find('.has-error').remove();
                this.currentElements.parents('.form-group:first').removeClass('has-error');

                $.each(list, function (index, error)
                {
                    var ee = $(error.element);
                    var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');

                    ee.parents('.form-group:first').addClass('has-error');
                    eep.find('.has-error').remove();
                    eep.append('<p class="has-error help-block">' + error.message + '</p>');
                });
                //refreshScrollers();
            }
        });

    });

    function addSection() {
        if ($("#SectionForm").valid()) {
//            $("#SectionForm").submit();
        }

    }

</script>