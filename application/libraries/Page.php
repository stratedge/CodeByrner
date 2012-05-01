<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeByrner
 *
 * An open source application development framework leveraging components and built on CodeIgniter for PHP 5.1.6 or newer
 *
 * @package     CodeByrner
 * @author      JB
 * @copyright   Copyright (c) 2012, Solvo Media, LLC
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://solvomedia.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------------------------------

/**
 * CodeByrner Page Class
 *
 * This class is one of the core files for the CodeByrner platform. The purpose of this class is to
 * provide methods that allow the developer to componentize their project by keeping track of
 * components and their locations within a layout and constructing the page. Controllers should
 * extend this class, or class that extends this class.
 *
 * @package		CodeByrner
 * @subpackage	Core
 * @category	Core
 * @author		JB
 */
class Page extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
    }
}

/* End of file Page.php */
/* Location: ./application/libraries/Page.php */
