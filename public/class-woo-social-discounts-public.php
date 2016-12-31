<?php

class Woo_Social_Discounts_Public {

	private $woo_social_discounts;

	private $version;
        
        private $settings;

        public function __construct( $woo_social_discounts, $version ) {

		$this->woo_social_discounts = $woo_social_discounts;
                
		$this->version = $version;
                            
                $this->settings = get_option( 'woo_social_discounts' );

	}
        
	/**
	 * Check if the coupon has not expired and is valid for this product.
	 * @return bool
	 */        
        private function is_coupon_valid() {
            
            global $post, $woocommerce;
            
            $product = new WC_Product( $post );
            
            if( $this->settings['coupon_code'] ) {
                
                if( array_key_exists ( 'social_shares' , $this->settings ) ) {
             
                    $coupon = new WC_Coupon( $this->settings['coupon_code'] );

                    if( $coupon->is_valid_for_product($product) && ( $coupon->expiry_date && current_time( 'timestamp' ) < $coupon->expiry_date ) ) {

                        return true;

                    }                      
                }
                
            }            
            
            return false;
            
        }
        
	/**
	 * Enqueue frontend css file.
	 */
	public function enqueue_styles() {
            
            if( $this->is_coupon_valid() ) {

		wp_enqueue_style( $this->woo_social_discounts, plugin_dir_url( __FILE__ ) . 'css/woo-social-discounts-public.min.css', array(), $this->version, 'all' );
                
            }            
                
	}
        
	/**
	 * Enqueue frontend js file.
	 */
	public function enqueue_scripts() {
            
            global $post;
            
            if( $this->is_coupon_valid() ) {

		wp_enqueue_script( $this->woo_social_discounts, plugin_dir_url( __FILE__ ) . 'js/woo-social-discounts-public.js', array( 'jquery' ), $this->version, false );
            }
            
	}

	/**
	 * Displays share icons.
	 */           
        public function display_social_icons() {
            
            if( $this->is_coupon_valid() ) {
                
                global $post;
                
                include_once 'partials/woo-social-discounts-public-display.php'; 
                
            }
            
        }

        public function http() {
            
            return is_ssl() ? 'https' : 'http';
                        
        }

        public function process_request() {
            
            global $post;
            
            $postID = $post->ID;

            if ( is_product() && isset( $_GET['wsd_share'] ) ) {

                switch ($_GET['wsd_share']) {

                case 'facebook':
                    
                    $fb_url = $this->http() . '://www.facebook.com/sharer.php?u=' . rawurlencode( get_permalink( $postID ) ) . '&t=' . rawurlencode( $post->post_title );

                    // Redirect to Facebook
                    wp_redirect( $fb_url );
                    
                    die();
                
                break;

                }

            }

        }
        
        public function js_windowOpen() {
            
            global $post;
            
            if('product' == get_post_type( $post->ID ) && is_single()) {
        
                $settings         = get_option( 'woo_social_discounts' );

                $defaults = array(
                        'menubar'   => 1,
                        'resizable' => 1,
                        'width'     => 600,
                        'height'    => 400,
                );

                $opts = array();

                foreach( $defaults as $key => $val ) {

                        $opts[] = "$key=$val";

                }

                $opts = implode( ',', $opts );

                foreach($settings['social_shares'] as $key => $value) {

                    if($value) {

                        ?>

                            <script type="text/javascript">

                                var windowOpen;

                                jQuery(document).ready(function($) {

                                    $( '.wsd-content a.share-<?php echo $key; ?>' ).on( 'click', function() {

                                            if ( 'undefined' !== typeof windowOpen ){ 
                                                    windowOpen.close();
                                            }

                                            InIntervId = setInterval(WSDSharing["<?php echo ($key == 'google-plus')? 'google_plus': $key; ?>_compare_shares"], 1500);

                                            windowOpen = window.open( $(this).attr( 'href' ), 'wsd<?php echo $key; ?>', '<?php echo $opts; ?>' );

                                            return false;

                                    });

                                });

                            </script>

                        <?php

                    }

                }

            }
        }
    
        public function apply_discount() {
            
            if( isset($_COOKIE["wsd_cookie"]) ) {
                
                global $woocommerce;
                
                $settings         = get_option( 'woo_social_discounts' );
                
                $coupon_code = $settings['coupon_code'];
                
                if ( $woocommerce->cart->has_discount( $coupon_code ) ) {
                    
                    return;
                    
                } else {
                    
                     $woocommerce->cart->add_discount( $coupon_code ); 
                    
                }
                
             }

        }

}