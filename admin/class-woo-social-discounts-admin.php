<?php


class Woo_Social_Discounts_Admin {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function add_plugin_admin_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'Woo Social Discounts', $this->plugin_name ),
			__( 'Woo Social Discounts', $this->plugin_name ),
			'manage_woocommerce',
			'woo-social-discounts',
			array( $this, 'display_admin_page' )
		);
	}
        
              
	public function register_settings() {
            
		register_setting( 'woo_social_discounts_group', 'woo_social_discounts');
                
	}
        
	public function display_admin_page() {
        
               global $wpdb;

               $post_table              = $wpdb->prefix . 'posts';

               $post_meta_table         = $wpdb->prefix . 'postmeta';

               $coupon_objects_array    = $wpdb->get_results("SELECT post_title FROM $post_table INNER JOIN $post_meta_table ON $post_table.ID = $post_meta_table.post_id WHERE $post_table.post_type = 'shop_coupon' AND $post_meta_table.meta_key =  'expiry_date' AND DATE( $post_meta_table.meta_value ) > CURRENT_DATE");
               
               $settings                = get_option( 'woo_social_discounts' );
               
               include_once 'partials/woo-social-discounts-admin-display.php';

	}
        

	public function plugin_settings_link( $links ) {
            
		$action_links = array(
                    
			'settings' => '<a href="' . admin_url( 'admin.php?page=woo-social-discounts' ) . '" title="' . esc_attr( __( 'View Settings', 'woo-social-discounts' ) ) . '">' . __( 'Settings', 'woo-social-discounts' ) . '</a>',
                    
		);

		return array_merge( $action_links, $links );
	}
        
}
