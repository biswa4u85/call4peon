<?php
foreach ($msection as $key => $section) {
    if ($section['eColumnLayoutType'] == "One Column") {
        $secClass = 'col-md-12';
        $full = "";
    } else {
        $secClass = 'col-md-6';
        $full = "fullwidth";
    }

    $html = '<div class="' . $secClass . ' column-section ">
                                        <div class="form-box-main" id="' . $section['iSectionId'] . '">
                                            <h4 class="portlet-section">
                                                <i class=" fa ' . $section['vIcon'] . '"></i>';

    $html.='<span id="section_1">' . $section['vSectionName'] . '</span>
                                                <i class="fa fa-chevron-down pull-right text-grey" data-toggle="collapse" href="#info' . $key . '" aria-expanded="true" aria-controls="collapseExample"> </i>
                                                <a href="javascript:void(0)" data-href="' . $this->config->item('admin_site_url') . 'section_add?secid=' . $section['iSectionId'] . '&secmodid=' . $section['iModuleId'] . '&N=Edit PageLayout" onclick="showformpage(this)">
                                                <i class="fa fa-edit  pull-right text-grey"> </i>
                                                </a>
                                            </h4>
                                            <div class="collapse in" id="info' . $key . '">
                                               ';

    $field = "iModuleSettingsId,iModuleId,iSectionId,iSectionColumn,vFields,vLabel,iSequenceOrder";
    $ext_cond = "iModuleId =" . $section['iModuleId'] . ' and iSectionId=' . $section['iSectionId'] . " and isDelete!='1' and isVisible ='1' order by iSequenceOrder asc";
    $rply = $this->model_module->get_data("module_settings_master", $field, array(), $ext_cond);
    $seccol = '';
    $firstcol = '';
    foreach ($rply as $rplyk => $rplyv) {
        if ($rplyv['iSectionColumn'] == '1') {
            $firstcol.='<div class="portlet">
                    <i class="fa fa-ellipsis-v drag-arrow"></i> 
                    <i class="fa fa-ellipsis-v drag-arrow"></i>
                  <div class="portlet-header" id="' . $rplyv['iModuleSettingsId'] . '">
                    ' . $rplyv['vFields'] . '
                    <a href="javascript:void(0)" class="fa fa-cog fa-fw" data-href="' . $this->config->item('admin_site_url') . 'field_settings?modulesettingsid=' . $rplyv['iModuleSettingsId'] . '&moduleid=' . $rplyv['iModuleId'] . '&N=Field Settings" onclick="showformpage(this)">                                                            
            </a>                                                        
            </div>
            </div>';
        } else {
            $seccol.='<div class="portlet">
                    <i class="fa fa-ellipsis-v drag-arrow"></i> 
                    <i class="fa fa-ellipsis-v drag-arrow"></i>
                  <div class="portlet-header" id="' . $rplyv['iModuleSettingsId'] . '">
                    ' . $rplyv['vFields'] . '
                    <a href="javascript:void(0)" class="fa fa-cog fa-fw" data-href="' . $this->config->item('admin_site_url') . 'field_settings?modulesettingsid=' . $rplyv['iModuleSettingsId'] . '&moduleid=' . $rplyv['iModuleId'] . '&N=Field Settings" onclick="showformpage(this)">                                                            
            </a>                                                        
            </div>
            </div>';
        }
    }
    $html.='<div class="column ' . $full . '" id="1">' . $firstcol . '</div>';
//    if (isset($seccol) && $seccol != '')
    $html.='<div class="column ' . $full . '" id="2">' . $seccol . '</div>';
    $html.='</div>
            </div>
            </div>';
    echo $html;
}
?>
<script>
    $(document).ready(function () {
        sort_columns();
    });
</script>
