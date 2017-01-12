<div class="col-md-12 column-section ui-sortable">
    <div class="form-box-main" id="0">
        <h4 class="">
            <i class="fa fa-sitemap handle"></i>
            <span id="section_1">Total Column</span>
            <i class="fa fa-chevron-down pull-right text-grey" data-toggle="collapse" href="#totalinfo" aria-expanded="true" aria-controls="collapseExample"> </i>                                                
        </h4>
        <div class="collapse in" id="totalinfo">
            <div class="column fullwidth ui-sortable" id="0" style="max-height: 300px;overflow-y: scroll ">
                <?php foreach ($col as $colkey => $colvalue) { ?>
                    <?php if ($colvalue['isVisible'] == '0') { ?>
                        <div class="portlet col-md-2">
                            <i class="fa fa-ellipsis-v drag-arrow"></i> 
                            <i class="fa fa-ellipsis-v drag-arrow"></i>
                            <div class="portlet-header total_column" id="<?php echo $colvalue['iModuleSettingsId'] ?>">
                                <?php echo $colvalue['vFields'] ?> 
                                <a href="javascript:void(0)" class="text-danger"></a>
                            </div>
                        </div>                                           
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        sort_columns();
    });
</script>
