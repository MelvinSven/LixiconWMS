<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = 'NotFound';
$route['translate_uri_dashes'] = FALSE;

$route['items/(:num)'] = 'items/index/$1';
$route['units/(:num)'] = 'units/index/$1';
$route['users/(:num)'] = 'users/index/$1';
$route['inputs/(:num)'] = 'inputs/index/$1';
$route['outputs/(:num)'] = 'outputs/index/$1';
$route['suppliers/(:num)'] = 'suppliers/index/$1';
$route['suppliers/search/(:num)'] = 'suppliers/search/$1';
$route['items/register'] = 'items/register';
$route['items/store'] = 'items/store';

// Routes untuk Multi-Gudang
$route['warehouses'] = 'warehouses/index';
$route['warehouses/(:num)'] = 'warehouses/index/$1';
$route['warehouses/search'] = 'warehouses/search';
$route['warehouses/search/(:num)'] = 'warehouses/search/$1';
$route['warehouse/add'] = 'warehouse/add';
$route['warehouse/update'] = 'warehouse/update';
$route['warehouse/delete'] = 'warehouse/delete';
$route['items/warehouse/(:num)'] = 'items/warehouse/$1';
$route['items/warehouse/(:num)/(:num)'] = 'items/warehouse/$1/$2';

// Routes untuk Transfer Barang
$route['transfer'] = 'transfer/index';
$route['transfer/create'] = 'transfer/create';
$route['transfer/store'] = 'transfer/store';
$route['transfer/detail/(:num)'] = 'transfer/detail/$1';
$route['transfer/getStokByGudang/(:num)'] = 'transfer/getStokByGudang/$1';

// Routes untuk Lokasi Barang
$route['locations'] = 'locations/index';
$route['locations/(:num)'] = 'locations/index/$1';
$route['locations/search'] = 'locations/search';
$route['locations/search/(:num)'] = 'locations/search/$1';

// Routes untuk Permintaan Barang (Preorder)
$route['preorder'] = 'preorder/index';
$route['preorder/create'] = 'preorder/create';
$route['preorder/store'] = 'preorder/store';
$route['preorder/detail/(:num)'] = 'preorder/detail/$1';
$route['preorder/approve/(:num)'] = 'preorder/approve/$1';
$route['preorder/reject/(:num)'] = 'preorder/reject/$1';
$route['preorder/surat_jalan/(:num)'] = 'preorder/surat_jalan/$1';
$route['preorder/store_surat_jalan/(:num)'] = 'preorder/store_surat_jalan/$1';
$route['preorder/print_surat_jalan/(:num)'] = 'preorder/print_surat_jalan/$1';
$route['preorder/kirim/(:num)'] = 'preorder/kirim/$1';
$route['preorder/verifikasi/(:num)'] = 'preorder/verifikasi/$1';
$route['preorder/store_verifikasi/(:num)'] = 'preorder/store_verifikasi/$1';
$route['preorder/delete/(:num)'] = 'preorder/delete/$1';
$route['preorder/getStokByGudang/(:num)'] = 'preorder/getStokByGudang/$1';
$route['preorder/print_verifikasi/(:num)'] = 'preorder/print_verifikasi/$1';

