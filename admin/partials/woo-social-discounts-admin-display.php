<?php
/**
 * Administration page.
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php settings_errors(); ?>
    
    
    <?php if(!empty($coupon_objects_array)):  ?>
    
            <form method="post" action="options.php">
                <?php settings_fields( 'woo_social_discounts_group' ); ?>
                
                <h3><?php _e( 'Woo Social Discounts Settings', 'woo-social-discounts' ); ?></h3>
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><label for="woo_social_discounts_message">Share Message</label></th>
                                <td><input type="text" class="input-text regular-input" size="70" value="<?php echo esc_attr( $settings['message'] ); ?>" id="woo_social_discounts_message" name="woo_social_discounts[message]" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="woo_social_discounts_network">Choose Social Networks</label></th>
                                <td>
                                    <p>
                                        <input type="checkbox" name="woo_social_discounts[social_shares][facebook]" id="woo_social_discounts_fb" <?php echo isset($settings['social_shares']['facebook']) ? 'checked="checked"': ''; ?>/>Facebook&nbsp;&nbsp;&nbsp;
                                    </p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label for="woo_social_discounts_coupon">Choose Coupon</label></th>
                                <td>
                                    <p>
                                       <select name="woo_social_discounts[coupon_code]" size="1">


                                           <?php 

                                                $coupon_code = isset($settings['coupon_code']) ? $settings['coupon_code'] : '';

                                                foreach ($coupon_objects_array as $coupon_object) {
                                                    echo '<option value="' . esc_attr($coupon_object->post_title) . '" ' . selected($coupon_code, $coupon_object->post_title, false) . '>' . esc_html($coupon_object->post_title) . '</option>';
                                                }

                                           ?>
                                       </select>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php submit_button(); ?>
            </form>    
    
        <?php else:  ?>
    
    
    <div>
        
        <h3>
            <?php _e( 'Woo Social Discounts Settings', 'woo-social-discounts' ); ?>
        </h3>
        
        <p>
                <?php 
                echo sprintf(
                    esc_html__( 'It seems you have not created any discount coupons yet, or all your coupons have expired. Please create at least one coupon %1$shere%2$s before setting up woo social discounts. Learn about coupon management %3$shere%4$s.', 'woo-social-discounts' ),
                    '<a href="' . esc_url( admin_url( 'post-new.php?post_type=shop_coupon' ) ) . '">',
                    '</a>',
                    '<a target="_blank" href="https://docs.woocommerce.com/document/coupon-management/">',
                    '</a>'
                );
                ?>
            </p>
        
    </div>
        
    <?php endif; ?>
    
    
</div>
