<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * History Class
 * 
 * An open source history management library for PHP 5.0.1 or newer (instead of 4.3.2 like CodeIgniter)
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	History
 * @author		Grzegorz Kazulak <grzegorz.kazulak@gmail.com
 */

class History {
	
	/**
	 * Stores the history
	 *
	 * @var string
	 */
	private $historyStack = array();
	
	/**
	 * Public constructor, gets instance of CI session object
	 *
	 * @return void
	 * @author Grzegorz Kazulak
	 */
	public function __construct(){
		$this->historyStack = array();
		$this->ciInstance 	= get_instance();
		$this->session 		= $this->ciInstance->session;
		$this->historyStack = $this->session->userdata('history_stack');
		
		# Push item to the stack
		$this->pushItem($this->ciInstance->uri->uri_string());
		$this->historyStack = $this->session->userdata('history_stack');
	}
	
	/**
	 * Pushes the item to the history stac
	 *
	 * @param string $URLString
	 * @return void
	 * @author Grzegorz Kazulak
	 */
	public function pushItem($URLString = null){
		(!is_array($this->historyStack) ? $this->historyStack = array() : false);

		if (end($this->historyStack) != $URLString) {
			array_push($this->historyStack, $URLString);
		}
		
		# Save the session data and assign it to current object property
		$this->session->set_userdata('history_stack', $this->historyStack);
	}
	
	/**
	 * Clears the history of visited pages. Takes no parameters.
	 *
	 * @return void
	 * @author Grzegorz Kazulak
	 */
	public function clear(){
		$this->historyStack = array();
        $this->session->set_userdata('history_stack', $this->historyStack);
	}
	
	/**
	 * Takes the last page URL of the history stack.
	 * Returns false if there is no information at all about 
	 * previously executed actions
	 *
	 * @return void
	 * @author Grzegorz Kazulak
	 */
	public function previous(){
		$count = count($this->historyStack);
		if (is_array($this->historyStack)){
			$this->historyStack = array_slice($this->historyStack, 0, $count - 1);
			return array_pop($this->historyStack);
		}
		return false;
	}
	
	/**
	 * Returns full actions history
	 *
	 * @return void
	 * @author Grzegorz Kazulak
	 */
	public function stack(){
		return $this->historyStack;
	}
	
	/**
	 * Usual object destructor
	 *
	 * @return void
	 * @author Grzegorz Kazulak
	 */
	public function __destruct(){
		
	}
	
}

?>