<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ViewHelpers {

	/**
	 * @brief Generates the "Login Text" for the banner.
	 */
    public function loginText()
    {
    	$CI =& get_instance();

    	//Check if user is logged in
    	if( $CI->session->userdata('loggedin') == TRUE )
    	{
    		return "Logged in as " . $CI->session->userdata('username');
    	} else {
    		return "Login";
    	}
    }

    public function forceLoggedIn()
    {
        $CI =& get_instance();

        if( $CI->session->userdata('loggedin') == FALSE )
        {
            $CI->load->helper('url');
            redirect( '/admin/login', 'refresh' );
        }
    }
}

/* End of file Someclass.php */