   <div id="left">
        <div class="media user-media bg-dark dker">
          <div class="user-media-toggleHover">
            <span class="fa fa-user"></span> 
          </div>
          <div class="user-wrapper bg-dark">
              
              <?php
                                $img_url = $this->config->item('images_url') . 'owner_img.png';
                               if ($this->session->userdata('vImage') != '') {

                                    $img = 'admin/' . $this->session->userdata('iAdminId') . '/' . $this->session->userdata('vImage');
                                    $img_path = $this->config->item('upload_path') . $img;

                                    if (file_exists($img_path)) {
                                        $img_url = $this->config->item('upload_url') . $img;
                                    }
                                }
                                ?>
              <a data-toggle="modal" data-original-title="Help" data-placement="bottom" href="#helpModal" class="user-link" id="notificationLink">
              <img class="media-object img-thumbnail user-img" alt="User Picture" src="<?php echo $img_url; ?>">
            </a> 
            <div class="media-body">
              <h5 class="media-heading"><a href="#" onclick="window.location = '<?php echo $this->config->item('admin_site_url'); ?>my_account'"><?php echo (trim($this->config->item('YT_ADMIN_NAME')) != '') ? $this->config->item('YT_ADMIN_NAME') : 'Update Profile'; ?></a></h5>
              <ul class="list-unstyled user-info">
                <li><?php echo $this->config->item('YT_ADMIN_EMAIL') ?></li>
                <li><a href="#" onclick="window.location = '<?php echo $this->config->item('admin_site_url'); ?>logout'" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i> Logout
                </a></li>
              </ul>
            </div>
          </div>
        </div>
          
       <ul id="menu" class="bg-blue dker">
           <li class="nav-header">Menu</li>
          <li class="nav-divider"></li>
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
                    
                    $html .= '<li class="' . (in_array($currentUrl, $vSelectedMenu) ? 'active' : '') . '"><a href="' . $url . $value['vURL'] . '"><i class="fa ' . $value['vImage'] . ' "></i><span class="link-title">&nbsp;' . $value['vMenuDisplay'] . '</span>' . ((is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) ? '<span class="fa arrow"></span>' : '') . ' </a>';
                } else if ($value['vMainMenuCode'] == "cases" && strtolower($this->config->item('YT_USER_PROFILE')) == "administration") {
                    $html .= '<li class="' . (in_array($currentUrl, $vSelectedMenu) ? 'active' : '') . '"><a href="' . $url . $value['vURL'] . '" ><i class="fa ' . $value['vImage'] . ' "></i><span class="link-title">&nbsp;' . $value['vMenuDisplay'] . '</span>' . ((is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) ? '<i class="fa fa-angle-down"></i>' : '') . ' </a>';
                }

                if (is_array($frontPanelSubMenu) && count($frontPanelSubMenu) > 0) {
                    $html .= '<ul>';
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
        </ul>
      </div><!-- /#left -->