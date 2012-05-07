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
 * CodeByrner Utilities
 *
 * @package		CodeByrner
 * @subpackage	Helpers
 * @category	Helpers
 * @author		JB
 * @version		1.0
 * @since		1.0
 */

// ------------------------------------------------------------------------------------------------


if ( ! function_exists('dump'))
{
    /**
     * Stop output of the page and just returns a human-readable copy of the variable that
     * is passed in.
     * 
     * @param	mixed	$data	The variable to investigate
     * @author	JB
	 * @version	1.0
	 * @since	1.0
     */
	function dump($data)
	{
		ob_end_clean();
	    ob_start();
	    
	    if(is_bool($data)) {
	        if($data === TRUE) {
	            exit('<pre>Boolean: TRUE</pre>');
	        } else exit('<pre>Boolean: FALSE</pre>');
	    }
	    
	    if(is_string($data)) exit("<pre>String: {$data}</pre>");
	    
	    if(is_float($data)) exit("<pre>Float: {$data}</pre>");
	    
	    if(is_int($data)) exit("<pre>Integer: {$data}</pre>");
	    
	    if(is_numeric($data)) exit("<pre>Number: {$data}</pre>");
	    
	    if(is_null($data)) exit("<pre>NULL</pre>");
	    
		print_r($data);
		
		$output = ob_get_clean();
		
		exit("<pre>".$output."</pre>");
	}
}

/* End of file utilities_helper.php */
/* Location: ./application/helpers/utilities_helper.php */