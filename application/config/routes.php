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

$route['default_controller'] = 'core';
$route['404_override'] = '';

//about/index
$route['what-does-shipping-soon-mean'] = 'about';
$route['what-does-shipping-soon-mean/resume'] = 'about/resume';

//about/credits
$route['credits'] = 'about/credits';

//portfolio/search
$route['portfolio/search/(:num)/(:num)/(:any)'] = 'portfolio/search/$1/$2/$3';
$route['portfolio/search/(:num)/(:num)'] = 'portfolio/search/$1/$2';
$route['portfolio/search/(:num)'] = 'portfolio/search/$1';
$route['portfolio/search'] = 'portfolio/search';

//portfolio/index
$route['portfolio/(:any)/(:num)'] = 'portfolio/index/$1/$2';

//sitemap/index
$route['sitemap.xml'] = 'sitemap/index';

//sitemap/page
$route['page-sitemap.xml'] = 'sitemap/page';

//sitemap/blog
$route['blog-sitemap.xml'] = 'sitemap/blog';

//sitemap/portfolio
$route['portfolio-sitemap.xml'] = 'sitemap/portfolio';

//sitemap/search
$route['search-sitemap.xml'] = 'sitemap/search';

/* End of file routes.php */
/* Location: ./application/config/routes.php */