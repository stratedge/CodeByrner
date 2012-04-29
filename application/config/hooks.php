<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/



/* End of file hooks.php */
/* Location: ./application/config/hooks.php */


/*
 * Pre-system hook that will load the classes required for CodeByrner's functionality so that our
 * controllers can extend them. Would use the pre-controller hook, but that actually gets called
 * after the controller is loaded.
 */
$hook['pre_controller_load'][] = array(
    'class'    => 'CodeByrner',
    'function' => 'loadCodeByrner',
    'filename' => 'Codebyrner.php',
    'filepath' => 'hooks',
    'params' => array('Page')
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
