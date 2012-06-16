<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| CodeByrner Core Files Directory
|--------------------------------------------------------------------------
|
| The CodeByrner core files are the classes in the application's library
| folder that both empower the component system, and relate only to
| the system. For the sake of organization, these files are by default
| kept in their own folder in the application/libraries folder. If the
| developer wishes to place the core files anywhere else inside the
| application/libraries directory they can set this property to the
| folder(s), or empty if the files are placed directly in
| application/libraries.
|
*/
$config['cb_core_folder'] = 'codebyrner';


/*
|--------------------------------------------------------------------------
| Components Default Location
|--------------------------------------------------------------------------
|
| CodeByrner uses components to construct an entire page. Given the
| structure of CodeIgniter, components are libraries and go in the
| application/libraries folder. For the sake of organization, CodeByrner
| will by default expect that components are placed inside a folder
| called "components" inside the application/libraries folder so that
| components can be out of the way. Changing this option will allow you
| to put components in whatever subfolder you desire, or directly in the
| application/libraries directory.
|
*/
$config['cb_components_folder'] = 'components';


/*
|--------------------------------------------------------------------------
| Use Record Layer
|--------------------------------------------------------------------------
|
| CodeByrner introduces a record layer as an extension of model classes.
| Records are models and extend the MY_Model class, but should be used
| specifically with database tables that have one auto-incrementing
| numerical primary key. By using the loading functions the record class
| will grab the requested row or rows and keeps the rows as objects
| within the CodeIgniter class so any subsequent attempts to load that
| same database row can be take directly from memory instead of having to
| hit memcache (if enabled) or the database again during the same server
| request. Records are disabled by default.
|
*/
$config['cb_enable_records'] = FALSE;


/*
|--------------------------------------------------------------------------
| Use Service Layer
|--------------------------------------------------------------------------
|
| CodeByrner introduces a service layer to CodeIgniter that allows a
| developer to consolidate common logic and decisions around a single
| feature or data type into a single file. Common logic checks, like
| "does this user have access to this?", can then be placed in a service
| layer, devorcing business logic from your models, and making it reusable
| throughout your components and controllers. This option turns the usage
| of services on and off. When enabled, the Service class will be loaded
| so that services can extend it, otherwise the service class will not
| be loaded. Services are disabled by default.
|
*/
$config['cb_enable_services'] = FALSE;


/*
|--------------------------------------------------------------------------
| Services Default Location
|--------------------------------------------------------------------------
|
| This option defines where your service classes are located within the
| application/libraries directory. Updating this value allows the developer
| to move the services to any subfolder within the application/libraries
| directory desired, or directly in the application/libraries directory
| by changing this to an empty string.
|
*/
$config['cb_services_folder'] = 'services';


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
| will automatically go to that folder to find your layout file. To place
| layouts directly in the application/views directory, then set this
| option to an empty string.
|
*/
$config['cb_default_layout_folder'] = 'layouts';


/*
|--------------------------------------------------------------------------
| Default Content Section Name
|--------------------------------------------------------------------------
|
| CodeByrner uses layouts to construct pages, which are simply views that
| define the structure of a page with variables where the content should
| go. If a component is added to a page, but no location is provided
| for where on the page the component's output should go, it will be added
| to the location listed below.
|
*/
$config['cb_default_location'] = 'content';


/*
|--------------------------------------------------------------------------
| Default Cmpt Show 404
|--------------------------------------------------------------------------
|
| CodeByrner uses a controller called Cmpt (by default) that allows the
| developer to access a specifc component and run a specific method
| within that component. If the Cmpt controller is called without a URI
| segment defining the class to be called, it will return nothing by
| default. Setting this value to TRUE will return whatever 404 page is
| configured within CodeIgniter.
|
*/
$config['cb_redirect_cmpt_to_404'] = FALSE;


/*
|--------------------------------------------------------------------------
| Set Default Timezone
|--------------------------------------------------------------------------
|
| Developers that upgrade PHP from version 5.2 to 5.3 might start getting
| errors on their pages stating that date functions require that the
| timezone be set. This should generally be done in the php.ini file
| using date.timezone = "TIMEZONE IDENTIFIER". If you are using multiple
| environments, don't want to update your php.ini file, or can't update
| your php.ini file, then uncomment the section below. The following
| section defaults to UTC, but you may change it to suit your needs.
|
| For a complete list of timezone identifiers, visit:
| http://www.php.net/manual/en/timezones.php
*/
//if(ini_get('date.timezone') == '')
//{
//	date_default_timezone_set('UTC');
//}

/* End of file codebyrner.php */
/* Location: ./application/config/codebyrner.php */