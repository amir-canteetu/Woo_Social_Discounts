<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.1
 * @package    Woo_Social_Discounts
 * @subpackage Woo_Social_Discounts/includes
 * @author     Amir Canteetu <amircanteetu@gmail.com>
 */
class Woo_Social_Discounts_Deactivator {

	public static function deactivate() {
            
            delete_option( 'woo_social_discounts' );

	}

}
