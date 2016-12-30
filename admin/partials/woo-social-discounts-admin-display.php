<?php
/**
 * Administration page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields( 'woo_social_discounts_group' ); ?>
        <h3><?php _e( 'Woo Social Discounts Settings', 'woo-social-discounts' ); ?></h3>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_message">Share Message</label></th>
                        <td><input type="text" class="input-text regular-input" size="70" value="<?php echo $settings['message']; ?>" id="woo_social_discounts_message" name="woo_social_discounts[message]" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_network">Choose Social Networks</label></th>
                        <td>
                            <p>
                                <input type="checkbox" name="woo_social_discounts[social_shares][facebook]" id="woo_social_discounts_fb" <?php echo isset($settings['social_shares']['facebook'])? 'checked="checked"': ''; ?>/>Facebook&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="woo_social_discounts[social_shares][twitter]" id="woo_social_discounts_twitter" <?php echo isset($settings['social_shares']['twitter'])? 'checked="checked"': ''; ?>/>Twitter&nbsp;&nbsp;&nbsp;
                            </p>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_network">Facebook App ID</label></th>
                        <td>
                            <p>
                                <input class="input-text regular-input" size="70" id="woo_social_discounts_facebook_app_id" name="woo_social_discounts[facebook_app_id]" value="<?php echo isset($settings["facebook_app_id"]) ? $settings["facebook_app_id"]: ''; ?>" type="text">
                            </p>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_network">Facebook App Secret</label></th>
                        <td>
                            <p>
                                <input class="input-text regular-input" size="70" id="woo_social_discounts_facebook_app_secret" name="woo_social_discounts[facebook_app_secret]" value="<?php echo isset($settings["facebook_app_secret"]) ? $settings["facebook_app_secret"]: ''; ?>" type="text">
                            </p>
                            <span>You can find your Facebook App ID & Secret at the <a href="https://developers.facebook.com/apps" target="_blank">App Dashboard</a>.</span>
                        </td>
                    </tr>                    
                    
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_coupon">Choose Coupon</label></th>
                        <td>
                            <p>
                               <select name="woo_social_discounts[coupon_code]" size="1">
                                   <?php 
                                   
                                        foreach ($coupon_objects_array as $coupon_object) {
                                            
                                            if($coupon_object->post_title == $settings['coupon_code']) {
                                                
                                            echo '<option selected="selected" value="' .$coupon_object->post_title. '">'.$coupon_object->post_title. '</p>';
                                                
                                            } else {
                                                
                                            echo '<option value="' .$coupon_object->post_title. '">'.$coupon_object->post_title. '</p>';
                                                
                                            }

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
</div>
