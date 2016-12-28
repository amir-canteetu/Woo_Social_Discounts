<?php

/**
 * @since      1.0.1
 * @package    Woo_Social_Discounts
 * @subpackage Woo_Social_Discounts/includes
 * @author     Amir Canteetu <amircanteetu@gmail.com>
 */
class Woo_Social_Discounts {

	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {

		$this->plugin_name = 'woo-social-discounts';
                
		$this->version = '1.0.1';

		$this->load_dependencies();
                
		$this->set_locale();
                
		$this->define_admin_hooks();
                
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-social-discounts-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-social-discounts-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-social-discounts-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-social-discounts-public.php';
                
		$this->loader = new Woo_Social_Discounts_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Woo_Social_Discounts_i18n();
                
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Woo_Social_Discounts_Admin( $this->get_plugin_name(), $this->get_version() );
                
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
                
                $this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
                
                $this->loader->add_filter( 'plugin_action_links_' . WSD_PLUGIN_BASENAME, $plugin_admin, 'plugin_settings_link' );

	}

	private function define_public_hooks() {
            
                $settings         = get_option( 'woo_social_discounts' );
                
                $wseo_options     = get_option( 'wpseo_social' );
                
                $active_plugins   = get_option('active_plugins', array());

		$plugin_public = new Woo_Social_Discounts_Public( $this->get_plugin_name(), $this->get_version() );

                $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
                
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
               
                $this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'display_social_icons' );
            
                $this->loader->add_action( 'template_redirect', $plugin_public, 'process_request' );
                    
                $this->loader->add_action( 'wp_footer', $plugin_public, 'js_windowOpen' );
                                
                $this->loader->add_action( 'woocommerce_before_checkout_form', $plugin_public, 'apply_discount' );
                
                $this->loader->add_action( 'woocommerce_before_cart_table', $plugin_public, 'apply_discount' );
                
	}

	public function run() {
            
		$this->loader->run();
                
	}

	public function get_plugin_name() {
            
		return $this->plugin_name;
                
	}

	public function get_loader() {
            
		return $this->loader;
                
	}

	public function get_version() {
            
		return $this->version;
                
	}

}
