=== Woo Social Discounts ===
Contributors: amir_canteetu
Tags: woocommerce, coupon, social coupon, discounts, social sharing
Requires at least: 3.0.1
Tested up to: 4.3.1
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=J78732V5VULA6
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Give users discounts for sharing your products on social media. Works with Woocommerce's coupon.

== Description ==

Give users discounts for sharing your products on social media, specifically Facebook and Twitter.

Admin can set discounts in the usual way by creating coupons, then using the same coupons for sharing discounts.

Sharing is enabled on product pages, so users can share the product's image and description, rather than just the website's
home page url, which may not have sufficient information on what your store has to offer.



== Installation ==


1. Upload `woo-social-discounts` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a coupon. Go to Woocommerce->coupons
4. Go to the plugin settings page: Woocommerce->Woo Social Discounts and set the share message, the social networks, and the coupon
 (which you created in step 4) to use. 

== Frequently Asked Questions ==

= How is the discount set? =

The plugin uses Woocommerce's native coupon functionality. You have to create a woocommerce coupon in the usual way then
apply it in this plugin's setting. NB*: Ensure that the coupon's Discount Type is set to "Product Discount," or else the sharing buttons won't be displayed.  

= To which social networks can products/items be shared? =

Facebook and Twitter. More networks to follow soon.



== Screenshots ==

1. Settings page.
2. Share icons
3. Share dialog

== Changelog ==

= 1.0.0 =

First release

= 1.0.1 =

* Minified javascript and css

* Added link to Settings on plugins page

* Added check for whether coupon is set before displaying social button on front-end

* Made social buttons narrower in css.


= 1.0.2 =

* Refactored code

