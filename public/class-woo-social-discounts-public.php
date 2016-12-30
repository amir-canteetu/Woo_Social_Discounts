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
        
        //Not Used. See woo-social-discounts-public.js
        public function wsd_share_action_javascript () {
            
            global $post;
            
            $ajax_url = admin_url( 'admin-ajax.php' );
            
            $nonce = wp_create_nonce("wsd_nonce");
            
        ?>

            <script type="text/javascript" >
                
                jQuery(document).ready(function($) {
                    
                    var ajax_url = '<?php echo $ajax_url; ?>';

                    var data = {
                            'action': 'wsd_get_fb_shares',
                            'post_id': '<?php echo $post->ID; ?>',
                            'nonce': '<?php echo $nonce; ?>'
                    };

                    jQuery.post(ajax_url, data, function(response) {

                        WSDSharing.total_counts.facebook = response;

                    });

                });
            
            </script> 
            
        <?php            
            
        }
        
        //Not Used. See woo-social-discounts-public.js
        public function wsd_get_fb_shares ( ) {
            
           if ( wp_verify_nonce( $_POST['nonce'], "wsd_nonce") ) {

                $post_id = $_POST['post_id'];

                $cache_key = 'wsd_share' . $post_id;
                
                $count = get_transient( $cache_key );

                $access_token = $this->settings['facebook_app_id']. '|'. $this->settings['facebook_app_secret'];
                
                $response = wp_remote_get( 'https://graph.facebook.com/v2.8/?id=' . urlencode( get_permalink( $post_id ) ) . '&access_token=' . $access_token );
                        
                $body = json_decode( $response['body'] );

                $count = intval( $body->share->share_count );
                
                set_transient( $cache_key, $count, 60 ); 
                
                echo $count;

                wp_die(); 
                
            }  

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
                
                case 'twitter':

                    $post_title =  html_entity_decode( wp_kses( $post->post_title, null ) );    

                    $post_link = get_permalink( $postID );

                    $text = $post_title;

                    $url = $post_link;

                    $twitter_url = add_query_arg(
                            urlencode_deep( array_filter( compact('text', 'url' ) ) ),
                            'https://twitter.com/intent/tweet'
                    );

                    // Redirect to Twitter
                    wp_redirect( $twitter_url );

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