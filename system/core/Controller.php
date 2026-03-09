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
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	protected $benchmark;
	protected $hooks;
	protected $utf8;
	protected $router;
	protected $lang;
	
	public $security;
	public $config;
	public $uri;
	public $output;
	public $input;
	public $load;
	
	public $db;
	public $session;
	public $form_validation;
	public $pagination;
	public $system_functions;
	public $login_model;
	public $header_model;

	public $home_model;
	public $leaves_model;
	public $administrators_model;
	public $admin_model;

	public $main_nav_model;
	public $main_table_01_model;
	public $main_table_02_model;
	public $selfservices_model;
	public $technos_encryption;
	public $companies_model;

	public $employee_module_model;
	public $employees_model;
	public $assets_model;
	public $logger;

	public $overtimes_model;
	public $encrypt;

	public $payrolls_model;
	public $benefits_model;
	public $reports_model;
	public $superadministrators_model;

	public $attendance_model;
	public $teams_model;

	public $hressentials_model;
	public $offsets_model;
	public $cache;
	public $upload;
	 public $exceptions;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */