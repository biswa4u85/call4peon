<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "content";

/*
 *  Frontend Routes
 */
/*
 * online payment
 *  */
$route['index'] = 'content/index';
$route['signin'] = 'user/index';
$route['payment'] = 'content/payment';
$route['response'] = 'content/payment_response';
/*imports*/
//$route['imports'] = 'import_export/imports_list';
//$route['exportFile'] = 'import_export/exportFile';
//$route['exportPDF'] = 'import_export/exportPDF';
//$route['samplefile'] = 'import_export/download_sample_file';
/*end imports*/
/*notes*/
$route['notes'] = 'notes/notes_list';
$route['exportFile'] = 'import_export/exportFile';
$route['exportPDF'] = 'import_export/exportPDF';
/*end notes*/
$route['index'] = "content/index";
$route['check'] = "content/shipment_add";
$route['transporter_add'] = "content/transporter_add";
$route['user_add'] = "content/user_add";
$route['contact_form'] = "content/contact_form";

$route['signup'] = "user/signup";
$route['signin'] = "user/signin";
$route['serviceAuth'] = "user/serviceAuth";
$route['forgot_password'] = "user/forgot_password";
$route['signout'] = "user/signout";
$route['dashboard'] = "user/dashboard";


/*
 *  Backend Routes
 */
$route['admin'] = "admin/login";
$route['admin/(.*)'] = 'admin/$1';

$route['login'] = 'admin/login';
$route['login_action'] = 'admin/login_action';
$route['logout'] = 'admin/logout';
$route['dashboard'] = 'admin/dashboard';
$route['search_result_page'] = 'admin/search_result_page';
$route['autocomplete'] = 'admin/autocomplete';
$route['search_result'] = 'admin/search_result';

// Module Management
$route['modules'] = 'module/modules';
$route['module_add'] = 'module/module_add';
$route['module_edit'] = 'module/module_add';
$route['section_add'] = 'module/section_add';
$route['field_settings'] = 'module/field_settings';

//Admin Management
$route['admins'] = 'admin/admins';
$route['admin-add'] = 'admin/admin_add';
$route['admin-edit'] = 'admin/admin_add';
$route['demo'] = 'admin/demo';
$route['forgotpassword'] = 'admin/forgotpassword';
$route['forgotpassword_action'] = 'admin/forgotpassword_action';
$route['system_setting'] = 'admin/system_setting';

//user
$route['users'] = 'user/users';
$route['user-add'] = 'user/user_add';
$route['user-edit'] = 'user/user_add';

//vehicle
$route['vehicles'] = 'vehicle/vehicles';
$route['vehicle-add'] = 'vehicle/vehicle_add';
$route['vehicle-edit'] = 'vehicle/vehicle_add';

//shipment
$route['shipments'] = 'shipment/shipments';
$route['shipment-add'] = 'shipment/shipment_add';
$route['shipment-edit'] = 'shipment/shipment_add';

//Country Management
$route['countries'] = 'country/countries';
$route['country_add'] = 'country/country_add';
$route['country_edit'] = 'country/country_add';

//State Management
$route['states'] = 'state/states';
$route['state_add'] = 'state/state_add';
$route['state_edit'] = 'state/state_add';

//City Management
$route['cities'] = 'city/cities';
$route['city_add'] = 'city/city_add';
$route['city_edit'] = 'city/city_add';

//Area Management
$route['area'] = 'area/areas';
$route['area_add'] = 'area/area_add';
$route['area_edit'] = 'area/area_add';

//location
$route['locations'] = 'location/locations';
$route['location-add'] = 'location/location_add';
$route['location-edit'] = 'location/location_add';

// routes for role master
$route['roles_permissions'] = 'roles/roles_main';
$route['role_add'] = 'roles/permission';
$route['role_edit'] = 'roles/permission';
$route['role'] = 'roles/permission';

//pages Management
$route['pages'] = 'page/page_list';
$route['page_add'] = 'page/page_add';
$route['page_edit'] = 'page/page_add';

$route['system_setting']="admin/system_setting";

require_once(BASEPATH . 'database/DB' . EXT);
$db = getDBObject();
$static_pages = $db->select("vPageCode, vUrl, vPageTitle")->where('eStatus','Active')->get('page_settings')->result_array();
foreach($static_pages as $i=>$route_arr){
    $route[$route_arr['vUrl']] = "content/staticpage/".$route_arr['vPageCode'];
}
/* End of file routes.php */
/* Location: ./application/config/routes.php */
