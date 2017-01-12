<!-- Brand and toggle get grouped for better mobile display -->
            <header class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
              </button>
              <a href="index.php" class="navbar-brand">
                <img src="<?php echo $this->config->item('back_assets_url');?>img/call4peon.png" alt="">
              </a> 
            </header>
            <div class="topnav">
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                  <i class="glyphicon glyphicon-fullscreen"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a href="#" onclick="window.location = '<?php echo $this->config->item('admin_site_url'); ?>logout'" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i>
                </a> 
              </div>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">

              <!-- .nav -->
              <ul class="nav navbar-nav">
                <?php
            $frontPanelMenu = $this->general->getBackPanelMenu('', '', 'activities');
//            pr($frontPanelMenu);exit;
            $html = '';
            $currentUrl = basename($this->uri->uri_string);


            if ($_REQUEST['cs'] == 'vendor_representative' && $currentUrl == 'imports') {
                $currentUrl = 'import_representatives';
            } else if ($currentUrl == 'imports') {
                if ($_REQUEST['cs'] == "visa" || $_REQUEST['cs'] == "transport" || $_REQUEST['cs'] == "mealplan") {
                    $currentUrl = 'import_' . $_REQUEST['cs'];
                } else {
                    $currentUrl = 'import_' . $_REQUEST['cs'] . 's';
                }
            }

            $selected_menu = 'dashboard';
            foreach ($frontPanelMenu as $key => $value) {
                $vSelectedMenu = explode(',', $value['vSelectedMenu']);

                $frontPanelSubMenu = $this->general->getBackPanelMenu($value['iModuleId'], '', 'activities');
//                pr($frontPanelSubMenu);
                $selected_menu = (strtolower($currentUrl) == strtolower($value['main_menu_code'])) ? $value['main_menu_code'] : $selected_menu;

                $url = (stristr($value['vURL'], 'javascript') === false) ? $this->config->item('admin_site_url') : '';
                $onclickfunction = ($value['vURL'] != 'javascript:void(0)') ? 'onclick="urlParse(this)"' : '';
                if ($value['vMainMenuCode'] != "cases") {
                    
                    $html .= '<li class="' . (in_array($currentUrl, $vSelectedMenu) ? 'active' : '') . ' ' . ((is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) ? 'dropdown' : '') . '  "><a '. ((is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) ? 'class="dropdown-toggle" data-toggle="dropdown"' : '') .' href="' . $url . $value['vURL'] . '"><i class="fa ' . $value['vImage'] . ' "></i><span class="link-title">&nbsp;' . $value['vMenuDisplay'] . '</span>' . ((is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) ? '<b class="caret"></b>' : '') . ' </a>';
                } else if ($value['vMainMenuCode'] == "cases" && strtolower($this->config->item('YT_USER_PROFILE')) == "administration") {
                    $html .= '<li class="' . (in_array($currentUrl, $vSelectedMenu) ? 'active' : '') . '"><a href="' . $url . $value['vURL'] . '" ><i class="fa ' . $value['vImage'] . ' "></i><span class="link-title">&nbsp;' . $value['vMenuDisplay'] . '</span>' . ((is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) ? '<i class="fa fa-angle-down"></i>' : '') . ' </a>';
                }

                if (is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) {
                    $html .= '<ul class="dropdown-menu">';
                    foreach ($frontPanelSubMenu as $skey => $svalue) {
//pr($svalue,1);
                        $vSubSelectedMenu = explode(',', $svalue['vSelectedMenu']);
                        if ($svalue['vMainMenuCode'] == "activities" && $svalue['vURL'] != "activities") {
                            $url = $svalue['vURL'] . "?f=activities";
                        } else {
                            $url = $svalue['vURL'];
                        }

                        $selected_menu = (strtolower($currentUrl) == strtolower($svalue['vURL'])) ? $svalue['main_menu_code'] : $selected_menu;
                        $suburl = (stristr($svalue['vURL'], 'javascript') === false) ? $this->config->item('admin_site_url') : '';
                        $html .= '<li class="' . (in_array($currentUrl, $vSubSelectedMenu) ? 'active' : '') . '">
                            <a href="' . $suburl . $url . '">
                                <i class="fa ' . $svalue['vImage'] . ' "></i><span class="link-title">&nbsp;' . $svalue['vMenuDisplay'] . '</span></a>
                        </li>';
                    }
                    $html .= '</ul>
                    </li>';
                } else {
                    $html .= '
                    </li>';
                }
            }
            echo $html;
            ?>
              </ul><!-- /.nav -->
            </div>