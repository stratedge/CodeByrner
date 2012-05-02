<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Default Layout View
|--------------------------------------------------------------------------
|
| The default layout view is the view file that will be loaded when
| the developer does not explicitly set a layout to use. If the developer
| finds that most of the pages have the same layout, it'll be easier to
| set that as the default here.
|
*/
$config['cb_default_layout'] = 'basic';


/*
|--------------------------------------------------------------------------
| Default Layout Folder Name
|--------------------------------------------------------------------------
|
| For the sake of simplicity, CodeByrner is package under the assumption
| that layout files be kept within the views folder just like any other
| views. To keep things organized, a developer may set a folder that
| contains the layout views so that when pages are built, the builder
| will automatically go to that folder to find your layout file. To
| use no folder set this value to FALSE.
|
*/
$config['cb_default_layout_folder'] = 'layouts';


/*
|--------------------------------------------------------------------------
| Default Content Section Name
|--------------------------------------------------------------------------
|
| CodeByrner uses layouts to construct pages, which are simply views that
| define the structure of page with variables where the content should
| go. If a component is added to a page, but no location is provided
| for where on the page the component should go, it will be added to the
| location listed below.
|
*/
$config['cb_default_location'] = 'content';


/*
|--------------------------------------------------------------------------
| Default Cmpt Show 404
|--------------------------------------------------------------------------
|
| CodeByrner uses a controller called Cmpt (by default) that allows the
 * developer to access a specifc component and run a specific method
 * within that component. If Cmpt controller is called without a URI
 * segment defining the class to be called, it will by default show a 404
 * error page. Turn this off by setting this value to FALSE; 
|
*/
$config['cb_redirect_cmpt_to_404'] = TRUE;

/* End of file codebyrner.php */
/* Location: ./application/config/codebyrner.php */