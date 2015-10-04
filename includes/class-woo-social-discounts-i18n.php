<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so it is ready for translation.
 *
 * @since      1.0.1
 * @package    Woo_Social_Discounts
 * @subpackage Woo_Social_Discounts/includes
 * @author     Amir Canteetu <amircanteetu@gmail.com>
 */
    class Woo_Social_Discounts_i18n {

            private $domain;

            public function load_plugin_textdomain() {

                    load_plugin_textdomain(
                            $this->domain,
                            false,
                            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
                    );

            }

            public function set_domain( $domain ) {
                    $this->domain = $domain;
            }

    }
