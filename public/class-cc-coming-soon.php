<?php
/**
 * CC Coming Soon
 *
 * @package   CcComingSoon
 * @author    Chop-Chop.org <talk@chop-chop.org>
 * @license   GPL-2.0+
 * @link      https://shop.chop-chop.org
 * @copyright 2014 
 */

/**
 * Plugin class.
 *
 * @package CcComingSoon
 * @author  Chop-Chop.org <talk@chop-chop.org>
 */
 
if (!function_exists('array_replace_recursive'))
{
  function array_replace_recursive($array, $array1)
  {
    function recurse($array, $array1)
    {
      foreach ($array1 as $key => $value)
      {
        // create new key in $array, if it is empty or not an array
        if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key])))
        {
          $array[$key] = array();
        }

        // overwrite the value in the base array
        if (is_array($value))
        {
          $value = recurse($array[$key], $value);
        }
        $array[$key] = $value;
      }
      return $array;
    }

    // handle the arguments, merge one by one
    $args = func_get_args();
    $array = $args[0];
    if (!is_array($array))
    {
      return $array;
    }
    for ($i = 1; $i < count($args); $i++)
    {
      if (is_array($args[$i]))
      {
        $array = recurse($array, $args[$i]);
      }
    }
    return $array;
  }
}

class CcComingSoon {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   0.1.0
	 *
	 * @var     string
	 */
	const VERSION = '0.2.5';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'cc-coming-soon';

	/**
	 * Instance of this class.
	 *
	 * @since    0.1.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Plugin options
	 * 
	 * @since  0.1.0
	 * 
	 * @var array
	 */
	protected $options = array();

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     0.1.0
	 */
	private function __construct() {

		// Load plugin options
		$this->options = get_option('CcComingSoonAdminOptions');

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Newsletter AJAX subscription
		add_action( 'wp_ajax_cc_cs_newsletter_subscribe', array( $this, 'ajax_newsletter_subscribe' ));
		add_action( 'wp_ajax_nopriv_cc_cs_newsletter_subscribe', array( $this, 'ajax_newsletter_subscribe' ));

		// Display Coming Soon Page
		add_action( 'template_redirect', array( $this, 'on_init' ) );
		
		add_filter( 'cc_the_content', array( $this, 'cc_the_content' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    0.1.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function get_options() {
		return $this->options;
	}

	public function get_option($section, $option) {
		return isset($this->options[$section][$option]) ? $this->options[$section][$option] : null;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();

					restore_current_blog();
				}

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

					restore_current_blog();

				}

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    0.1.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    0.1.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    0.1.0
	 */
	private static function single_activate() {
		
		$defaults = (include(dirname( __FILE__ ) . '/../config/defaults.php'));

		if(!get_option('CcComingSoonAdminOptions')) {
			add_option('CcComingSoonAdminOptions', $defaults);
		} else {

			$options = get_option('CcComingSoonAdminOptions');
 
			// Save merged options
			update_option('CcComingSoonAdminOptions', array_replace_recursive($defaults, $options));
		} 
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    0.1.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * @TODO
	 *
	 * @since    0.1.0
	 */
	public function on_init() {

		// preserve canonical urls
		redirect_canonical();

		// is preview
		if(isset($_GET['cc-cs-preview']) && $_GET['cc-cs-preview'] === '1') {
			$this->show_cs_page();
			return false;
		}

		// Enabled option
		if($this->get_option('status', 'enabled') !== 'yes')
			return false;

		// Not on front-end
		$paths = array(
			'wp-admin',
			'wp-login',
			'login',
			'wp-cron',
			'feed',
			'async-upload.php',
			'upgrade.php',
			'/plugins/',
			'/xmlrpc.php'
		);
		foreach ($paths as $path) {
			if(
				   (!empty($_SERVER['PHP_SELF']) && strstr($_SERVER['PHP_SELF'], $path))
				|| (!empty($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'], $path))
			)
				return false;
		}

		// custom login
		if (in_array($GLOBALS['pagenow'], array('wp-login.php')))
			return false;

		// is admin
		if(is_super_admin())
			return false;

		$this->show_cs_page();
	}

	/**
	 * [show_cs_page description]
	 * @return [type] [description]
	 */
	public function show_cs_page() {
		include('themes/default/index.php');
		exit();
	}

	/**
	 * [ajax_newsletter_subscribe description]
	 * @return [type] [description]
	 */
	public function ajax_newsletter_subscribe() {

		check_ajax_referer( 'cc-cs-newsletter-subscribe' );

		$to_email = $this->get_option('newsletter', 'email') ? $this->get_option('newsletter', 'email') : get_option( 'admin_email' );

		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

			$sent = wp_mail(
				$to_email,
				__('You have a new subscriber!', $this->plugin_slug),
				sprintf(__("Hello,\n\nA new user has subscribed through your Coming Soon page.\n\nSubscriber's email: %s", $this->plugin_slug), $_POST['email'])
			);

			if($sent) {
				print json_encode(array('status' => 'ok'));
				die();
			}
		}

		print json_encode(array('status' => 'error'));
		die();
	}

	public function get_logo_type() {
		$e = explode('_', $this->get_option('content', 'logo_type'));
		return array_pop($e);
	}

	public function get_background_type() {
		$e = explode('_', $this->get_option('background', 'type'));
		return array_pop($e);
	}
	
	/**
	 * reset_options_to_default
	 * @return boolean
	 */
	public function reset_options_to_default($sections,$tab) {
			$options = (include(dirname( __FILE__ ) . '/../config/defaults.php'));
			$current_settings = get_option('CcComingSoonAdminOptions');
			
			$to_reset = array(); 
			
			foreach($sections as $section)
			{
				if(isset($options[$section]))
				{
				$to_reset[$section] = $options[$section];
				}
			} 
			
			if($tab != 'design')
			{	
				$settings = array_replace_recursive($current_settings, $to_reset);
			}
			elseif($tab == 'design')
			{
				$template =  'default'; 
				$current_settings = array_merge($current_settings, $to_reset); 
				$settings = $this->merge_template_settings($current_settings, $template);
			}
			if(count($settings)) {
				return update_option('CcComingSoonAdminOptions', $settings);
			}  
	}
	
	public function merge_template_settings($base = array(), $template) {

		$file = CC_CS_PLUGIN_DIR . 'public/themes/' . $template . '/defaults.json';
		$settings = file_exists($file) ? json_decode(file_get_contents($file), true) : null;

		if($settings) {
			$settings['options'] = isset($settings['options']) ? $settings['options'] : array();

			if(isset($settings['files']) && count($settings['files'])) {
				foreach($settings['files'] as $sKey => $section) {
					foreach($section as $oKey => $option) {
						$settings['files'][$sKey][$oKey] = plugins_url($option, $file);
					}
				}

				$settings['options'] = array_replace_recursive($settings['options'], $settings['files']);
			}

			return array_replace_recursive($base, $settings['options']);
		} else {
			return array();
		}
		
	}
	
	public function cc_the_content($content = null) {
		
		remove_all_filters('the_content');
		
		 $allow_filters = array(
			'capital_P_dangit',
			'do_shortcode',
			'wptexturize',
			'convert_smilies',
			'convert_chars',
			'wpautop',
			'shortcode_unautop',
			'prepend_attachment',
		);
		
		foreach($allow_filters as $filter)
		{	
			add_filter('the_content', $filter); 
		}
		return  apply_filters('the_content', $content);
	}
	
}
