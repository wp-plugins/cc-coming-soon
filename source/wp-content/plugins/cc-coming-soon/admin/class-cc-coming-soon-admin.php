<?php
/**
 * CC Coming Soon
 *
 * @package   CcComingSoonAdmin
 * @author    Chop-Chop.org <talk@chop-chop.org>
 * @license   GPL-2.0+
 * @link      https://shop.chop-chop.org
 * @copyright 2014 
 */

if ( ! class_exists( 'CcComingSoonAdminOptions' ) )
    require_once( dirname( __FILE__ ) . '/views/admin.php' );

if ( ! class_exists( 'CcComingSoonPreview' ) )
    require_once( dirname( __FILE__ ) . '/includes/class-cc-coming-soon-preview.php' );

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * @package CcComingSoonAdmin
 * @author  Chop-Chop.org <talk@chop-chop.org>
 */
class CcComingSoonAdmin {

	/**
	 * Instance of this class.
	 *
	 * @since    0.1.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     0.1.0
	 */
	private function __construct() {

		$plugin = CcComingSoon::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		new CcComingSoonAdminOptions;

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Enqueue scripts
		add_action( 'admin_print_scripts-settings_page_cc_coming_soon', array( $this,'enqueue_tinymce_event') );
		add_action( 'admin_print_scripts-settings_page_cc_coming_soon', array( $this, 'enqueue_admin_scripts' ));

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

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    0.1.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=cc_coming_soon') . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_style('wp-color-picker' ); 
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider'); 
		
		wp_enqueue_media();
		
		wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), CcComingSoon::VERSION );
		
		wp_enqueue_script( $this->plugin_slug .'-admin-scripts', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), CcComingSoon::VERSION );  
		wp_localize_script( $this->plugin_slug .'-admin-scripts', 'chch_put_ajax_object', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ),'chch_pop_up_url' => CC_CS_PLUGIN_URL) );
		
		wp_enqueue_style( $this->plugin_slug .'-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css', null, CcComingSoon::VERSION,'all' );
	}

	public function enqueue_tinymce_event() {
		add_filter( 'mce_external_plugins', array( $this, 'enqueue_tinymce_keyup') );
	}

	public function enqueue_tinymce_keyup($plugin_array) {
		if ( get_bloginfo('version') < 3.9 ) { 
			$plugin_array['keyup_event'] = CC_CS_PLUGIN_URL .'admin/assets/js/chch-tinymce-old.js'; 
			return $plugin_array;
		} else {
			$plugin_array['keyup_event'] = CC_CS_PLUGIN_URL .'admin/assets/js/chch-tinymce.js'; 
			return $plugin_array;
		}
	}
}
