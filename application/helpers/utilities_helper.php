<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Utilities
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		JB
 */

// ------------------------------------------------------------------------

if ( ! function_exists('dump'))
{
    /**
     * Stop output of the page, and just return a human-readable copy of the variable that
     * is passed in.
     * 
     * @access	public
     * @param	mixed		$data	The variable to investigate
     * @author	JB
     * @version 2011-04-24
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
	    
		//If we've gotten here it must be an object or an array
		print_r($data);
		
		$output = ob_get_clean();
		
		exit("<pre>".$output."</pre>");
	}
}


//-------------------------------------------------------------------


if(!function_exists('SQLTimestamp'))
{
    /**
     *  Takes the passed in timestamp, otherwise the current UNIX timestamp and converts
     *  it into the sql format for a DATETIME and TIMESTAMP.
     *  
     * @access	public
     * @param	integer		$time	A UNIX timestamp
     * @return	string				Formatted date and time
     * @author	JB
     * @version 2011-04-24
     */
    function SQLTimestamp($time = NULL)
    {
        $time = ($time) ? $time : time();
        return date('Y-m-d H:i:s', $time);
    }
}


//-------------------------------------------------------------------


if(!function_exists('CI'))
{
    /**
     * Gets the CodeIgniter global class and returns it. Strictly for making life just a
     * little bit easier.
     * 
     * @access	public
     * @return	CodeIgniter		The core CodeIgniter object
     * @author	JB
     * @version	2011-04-24
     */
    function CI()
    {
        $CI =& get_instance();
        return $CI;
    }
}


//-------------------------------------------------------------------


if(!function_exists('formatText'))
{
    /**
     * Replaces double line breaks with paragraphs and then resulting single line breaks
     * with break tags.
     * 
     * @param	string		$str	The string to strip new lines from
     * @return	string				The correctly formmatted string
     * @author	JB
     * @version NOT COMPLETE
     */
    function formatText($str)
    {
        $str = "<p>" . implode( "</p><p>", preg_split('/\n(?:\s*\n)/', $str)) . "</p>";
        $str = preg_replace('/\n/g', '<br />', $str);
        return $str;
    }
}


//-------------------------------------------------------------------


if(!function_exists('flatten'))
{
	/**
     * Takes a multidimensional array where each 2nd dimension value is an array with at
     * least 1 key matching the passed in key. Returns a single dimension array with all
     * the values of the passed in key.
     * 
     * @param	array		$data	The array to flatted
     * @param	string		$key	The key to flatten by
     * @return	array|mixed			The flattened array, or the original value if it wasn't an array
     * @author	JB
     * @version	2011-04-24
     */
    function flatten($data, $key)
    {
        $result = array();
        if(is_array($data))
        {
           foreach($data as $value)
           {
               $result[] = $value[$key];
           }
           return $result;
        } else return $data;
    }
}


//-------------------------------------------------------------------


if(!function_exists('getMonth'))
{
    /**
     * Takes the month number passed to it, and the optional style passed in, and returns
     * the month as defined by style. Default style is a full month representation.
     * 
     * @param	integer			$month
     * @param	string			$style	Either F, M, m, n, or t
     * @return	string|integer			The month represented according to $style
     * @author	JB
     * @version 2011-05-29	
     */
    function getMonth($month, $style='F')
    {
        $date = sprintf('2011-%d-01', $month);
        return date($style, strtotime($date));
    }
}

/* End of file utilities.php */
/* Location: ./application/helpers/utilities.php */