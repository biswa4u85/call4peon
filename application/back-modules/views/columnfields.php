<div class="btn-group btn-group-sm div_order_list">
    <select class="btn btn-default listname select_list_order">
        <option value="none" >--None--</option>
    </select>
</div>
<!--<div class="btn-group btn-group-sm div_order_list">
    <a href="javascript:void(0)" class="btn btn-default dropdown-toggle"  data-toggle="dropdown" data-toggle="tooltip" data-placement="bottom" title="Select Order To display list"><i class="fa fa-fw fa-list"></i> Filter List</a>
    <a href="javascript:void(0)" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </a>
    <ul role="menu" class="dropdown-menu select_list_order">
    </ul>
</div>-->
<?php //pr($sublist); ?>
<div class="btn-group btn-group-sm">
    <?php if ($sublist != 'notreq') { ?>
        <a href="javascript:void(0);" class="btn btn-default importbtn" data-toggle="tooltip" data-placement="bottom" title="Import Data" data-original-title="Import Data"><i class="fa fa-fw fa-download"></i> Import</a>
    <?php } ?>
    <?php if ($sublist != 'notreq') { ?>
        <div class="btn-group btn-group-sm">
            <?php if ($sublist != 'emaillist') { ?>
<!--                <a href="javascript:void(0);" class="btn btn-default dropdown-toggle exportdata" data-toggle="dropdown" data-toggle="tooltip" data-placement="bottom" title="Export Data" data-original-title="Export Data"><i class="fa fa-fw fa-upload"></i> Export</a>

                <a href="javascript:void(0)" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </a>-->
            <?php } ?>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $this->config->item('admin_site_url'); ?>exportFile?t=csv&c=" class="col-md-12 liexport"><i class="fa fa-list"></i> CSV</a>
                </li>
                <li><a href="<?php echo $this->config->item('site_url'); ?>exportPDF?t=pdf&c=" class="col-md-12 liexport"><i class="fa fa-file-text"></i> PDF</a>
                </li>
                <li class="divider"></li>
            </ul>
        </div>
    <?php } ?>
</div>
<div class="btn-group btn-group-sm selectcolumn">
    <select id="columnsname" class="btn btn-default columnsname showcolumngrid" multiple="">
        <option value="none" >--None--</option>
    </select>
</div>
<!--<div class="btn-group btn-group-sm">    
    <a href="javascript:void(0)" class="btn btn-default dropdown-toggle"  data-toggle="dropdown" data-toggle="tooltip" data-placement="bottom" title="Select column To display in list"><i class="fa fa-fw fa-check-circle"></i> Select Columns</a>
    <a href="javascript:void(0)" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </a>
    <ul role="menu" class="dropdown-menu inner selectpicker columnul">
    </ul>
</div>-->
<div class="btn-group btn-group-sm">
    <a href="javascript:$('#refreshbtn').trigger('click');void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Show All" id="showallcol"><i class="fa fa-fw fa-refresh"></i>Reset</a>
</div>