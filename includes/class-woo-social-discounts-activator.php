<?php

/**
 * Fired during plugin activation
 *
 * @since      1.0.1
 *
 * @package    Woo_Social_Discounts
 * @subpackage Woo_Social_Discounts/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    Woo_Social_Discounts
 * @subpackage Woo_Social_Discounts/includes
 * @author     Amir Canteetu <amircanteetu@gmail.com>
 */
class Woo_Social_Discounts_Activator {

	public static function activate() {
      
            add_option( 'woo_social_discounts', array('message' =>'Share this for a discount',
                                                            'social_shares' => array('facebook'=>true,
                                                                                    'twitter'=>true)) );

	}

}
