    jQuery(document).ready(function($) {

        WSDSharing = {

            total_counts: {

                "facebook": 0, "twitter": 0 
            },

            setCookie: function (name, value) {

                var cookie = name + "=" + encodeURIComponent(value);

                 document.cookie = cookie + "; path=/";

            },        

            facebook_compare_shares: function () {

                var location = window.location.href;

                var initial_count = WSDSharing.total_counts.facebook;

                jQuery.getJSON('https://graph.facebook.com/?id='+location+'&callback=?', function ( data ) {

                    if( data.share.share_count > initial_count ){

                        WSDSharing.setCookie('wsd_cookie', 'true', 0);

                        jQuery('.wsd-sharing').replaceWith("<div><p>Thanks for sharing! Your discount will be applied at checkout.</p></div>");

                        clearInterval(InIntervId);

                    }

                });
            },

            twitter_compare_shares: function () {

                var location = window.location.href;

                var initial_count = WSDSharing.total_counts.twitter;

                jQuery.getJSON('//cdn.api.twitter.com/1/urls/count.json?url='+location+'&callback=?', function (data) {


                    if(data.count > initial_count){

                         WSDSharing.setCookie('wsd_cookie', 'true', 0);

                        jQuery('.wsd-sharing').replaceWith("<div><p>Thanks for sharing! Your discount will be applied at checkout.</p></div>");

                        clearInterval(InIntervId);

                    }

                });
            }

        };

        jQuery.getJSON('https://graph.facebook.com/?id='+location+'&callback=?', function (data) {

            if( data.share.share_count && WSDSharing.total_counts ){

                WSDSharing.total_counts.facebook = data.share.share_count;
                
            } 

        });        


}); 