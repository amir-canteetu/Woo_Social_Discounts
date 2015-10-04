<?php

class Woo_Social_Discounts_Public {

	private $woo_social_discounts;

	private $version;

	public function __construct( $woo_social_discounts, $version ) {

		$this->woo_social_discounts = $woo_social_discounts;
                
		$this->version = $version;

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->woo_social_discounts, plugin_dir_url( __FILE__ ) . 'css/woo-social-discounts-public.min.css', array(), $this->version, 'all' );
                
	}

	public function enqueue_scripts() {
            
            global $post;
            
            if('product' == get_post_type( $post->ID ) && is_single()) {

		wp_enqueue_script( $this->woo_social_discounts, plugin_dir_url( __FILE__ ) . 'js/woo-social-discounts-public.min.js', array( 'jquery' ), $this->version, false );
            }
            
	}
        
        public function display_social_coupon() {
            
            $settings         = get_option( 'woo_social_discounts' );
            
            if(isset($settings['coupon_code'])) {
                
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

                    if(true==$value) {

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