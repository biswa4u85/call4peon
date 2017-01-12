<?php if (count($csvData) > 0) { 
    if($this->session->userdata('case') == 'product_master') {
    $contactfield_arr[] = 'f-iPrimaryRep';
    }
   ?>
    <form class="form-horizontal" action="<?php echo $this->config->item('site_url'); ?>import_export/import_file_action" method="post" id='finalImportForm'> 
        <input type="hidden" name='csv_file_name' value='<?php echo $csv_file_name; ?>'/>
        <p>Please map the <?php echo ucfirst($this->session->userdata('imode')) . 's'; ?> variables to your file column.</p>
        <table class="tableTools table table-striped table-primary " cellpadding="0" cellspacing="0" width="100%">          
            <thead>
                <tr>
                    <th width = "30%"><?php echo ucfirst($this->session->userdata('imode')) . 's'; ?> Variables</th>
                    <th class="text-center" width = "30%">Your File Column</th>
                    <th class="text-center" width = "40%">Your File Value</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($csvData[1] as $csvDataKey => $csvDataField) { ?>

                    <tr>
                        <th width = "20%">
                <div class="form-group">
                    <div class="col-md-8">
                        <select name="importselect[]" class="importselect" style="width:100%">
                            <option value=""></option>
                            <?php
                            foreach ($contactfield_arr as $key => $value) {
                                if ($value == 'f-dtDOB') {
                                    echo '<option value="' . $value . '" ' . (strtolower(substr($value, 4)) == str_replace(' ', '', strtolower($csvDataKey)) ? 'selected' : '') . '>' . substr($value, 4) . '</option>';
                                } else if ($value == 'f-dtClosingDate') {
                                    echo '<option value="' . $value . '" ' . (strtolower(substr($value, 4)) == str_replace(' ', '', strtolower($csvDataKey)) ? 'selected' : '') . '>' . $this->general->addSpaceInString(substr($value, 4)) . '</option>';
                                } else if ($value == 'f-iPrimaryRep') {
                                    $name = 'Primary Representative';
                                    echo '<option value="' . $value . '" ' . (strtolower($name) == strtolower($csvDataKey) ? 'selected' : '') . '>' . $name . '</option>';
                                } else {
                                    echo '<option value="' . $value . '" ' . (strtolower(substr($value, 3)) == str_replace(' ', '', strtolower($csvDataKey)) ? 'selected' : '') . '>' . $this->general->addSpaceInString(substr($value, 3)) . '</option>';
                                }
                            }
                            ?>                                
                        </select>
                    </div>
                </div>
                </th>

                <td width = "20%">
                    <input type='hidden' name='csv_field_name[]' value='<?php echo $csvDataKey; ?>'/>
        <?php echo $csvDataKey; ?>
                </td>
                <td width = "60%">
                    <?php
                    $f_value = '';
                    for ($i = 1; $i <= count($csvData); $i++) {
                        if ($i < 4) {
                            $f_value .= (($f_value != '') ? ',' : '') . $csvData[$i][$csvDataKey];
                        } else {
                            break;
                        }
                    }
                    echo $f_value;
                    ?>                                
                </td>
                </tr>
    <?php } ?>
            <tr>
                <td colspan="3">
                    <p>What should we do when we encounter duplicate? <select name="duplicate" class="btn btn-default">
                            <option value="Skip">Skip</option>
                            <option value="Update">Update</option>                                                      </select> </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-default" id='finalImport'><i class="fa fa-check-circle"></i> Import </button>
                        <a href="javascript:$('#importFromFile').show();$('#final_form').hide();$('.dz-remove').trigger('click');void(0);"><button type="button" class="btn btn-default" id="clear-dropzone"><i class="fa fa-times"></i> Cancel</button></a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <script>
        $(document).ready(function () {
    	$("#finalImport").click(function () {
    	    $("#finalImportForm").validate({
    		submitHandler: function (form) {
    		    form.submit();
    //                        ajaxformsubmit(form);
    		}
    	    });
    	});
    	$('.importselect').each(function () {
    	    if ($(this).val() == '' || $(this).val() === undefined) {
    		var trobj = $(this).parent().parent().parent().parent();
    		$(trobj).css('background-color', '#f1837f')
    		$(trobj).css('color', 'white')
    	    }
    	})
        });
    </script>
<?php } else { ?>
    <h3 style="color:#cc3a3a;">Oops... Invalid Format. Please check your csv file and try again</h3>
    <a href="<?php echo $this->config->item('site_url'); ?>imports?cs=<?php echo $this->session->userdata('imode');?>" class="redirecttoimport btn btn-default">Back</a>
    <script>$('.redirecttoimport').trigger();</script>
<?php } ?>
