<?php

/**
 * @since             1.0.1
 * @package           Woo_Social_Discounts
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Social Discounts
 * Plugin URI:        https://wordpress.org/plugins/woo-social-discounts/
 * Description:       Give customers discounts for sharing your products on social media.
 * Version:           1.0.1
 * Author:            Amir Canteetu
 * Author URI:        https://github.com/amir-canteetu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-social-discounts
 * Domain Path:       /languages
 */

    // If this file is called directly, abort.
    if ( ! defined( 'WPINC' ) ) {
            die;
    }


    $active_plugins         = get_option( 'active_plugins', array() );

    $woocommerce_installed  = in_array( 'woocommerce/woocommerce.php', $active_plugins );

    if ( !$woocommerce_installed) {

        add_action( 'admin_notices', 'wsd_admin_notice' );

        add_action( 'admin_init', 'wsd_plugin_deactivate' );

        function wsd_plugin_deactivate() {

            deactivate_plugins( plugin_basename( __FILE__ ) );

        }

        function wsd_admin_notice() {

            echo '<div id="message" class="error"><p>Woo Social Discounts requires <a href="https://wordpress.org/plugins/woocommerce/">Woo</a> to be installed; please install or upgrade your installation.</div>';

        }

    } else {

        function define_constants() {
            
            define( 'WSD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
            
        }
            

        function activate_woo_social_discounts() {

                require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-social-discounts-activator.php';

                Woo_Social_Discounts_Activator::activate();
        }

        function deactivate_woo_social_discounts() {

                require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-social-discounts-deactivator.php';

                Woo_Social_Discounts_Deactivator::deactivate();

        }

        register_activation_hook( __FILE__, 'activate_woo_social_discounts' );

        register_deactivation_hook( __FILE__, 'deactivate_woo_social_discounts' );
        
        define_constants();

        require plugin_dir_path( __FILE__ ) . 'includes/class-woo-social-discounts.php';

        function run_woo_social_discounts() {

                $plugin = new Woo_Social_Discounts();

                $plugin->run();

        }

    run_woo_social_discounts();

    }
