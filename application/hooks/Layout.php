<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout Class
 *
 * @package hooks
 */

class Layout
{
	
	public $base_url;
	
	/**
	 * this is a init method
	 * @return
	 */
	public function init()
	{
		// instance of CI.
		$CI =& get_instance();
		
		// defining base url
		$this->base_url = $CI->config->slash_item('base_url');
		
		// geting the CI output
		$output = $CI->output->get_output();
		
		// getting the page title is set in the controller
		$title = (isset($CI->title)) ? $CI->title : '';
				
		// setting the default layout or a custom layout defined in controller
		if (isset($CI->layout) && !preg_match('/(.+).php$/', $CI->layout)) {
			$CI->layout .= '.php';
		} else {
			$CI->layout = 'default.php';
		}
		
		// defining the complete path of layout file
		$layout = LAYOUTPATH . $CI->layout;
		
		// layout does not exists
		if ($CI->layout !== 'default.php' && !file_exists($layout)) {
			// show the message
			if ($CI->layout != '.php')
				show_error("You have specified a invalid layout: " . $CI->layout);
		}
		
		if (file_exists($layout)) {
			$layout = $CI->load->file($layout, true);
			
			// replacing layout variables
			$view = str_replace('{content_for_layout}', $output, $layout);
		} else {
			$view = $output;
		}
		
		echo $view;
	}	
}