<script type="text/javascript">

    jQuery(document).ready(function($) {
        
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '<?php echo $this->settings['facebook_app_id']; ?>',
        xfbml      : false,
        version    : 'v2.8'
      });
      FB.AppEvents.logPageView();
      
      
    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));

     FB.ui({
    method: 'share_open_graph',
    action_type: 'og.likes',
    action_properties: JSON.stringify({
      object:'https://developers.facebook.com/docs/',
    })
      }, function(response){
        // Debug response (optional)
        console.log(response);
      });       
      
      
      
    };

    
      
    });


</script>


<div class="woo_social_discounts wsd-sharing-enabled">
    <div class="robots-nocontent wsd-block wsd-social wsd-social-icon wsd-sharing">
        <h3 class="wsd-title"><?php echo $this->settings['message']; ?></h3>
        <div class="wsd-content">
            <ul>
                <?php 
                
                foreach( $this->settings['social_shares'] as $key => $value ) {
                    
                    if($value == true) {
                        
                        ?>
                
                            <li class="share-<?php echo $key; ?>">
                                <a rel="nofollow" class="share-<?php echo $key; ?> wsd-button share-icon no-text" href="<?php echo get_permalink( $post->ID ) . '?wsd_share='.$key; ?>" target="_blank" title="Share on <?php echo $key; ?>">
                                    <span class="sharing-screen-reader-text">Share on <?php echo $key; ?></span>
                                </a>
                            </li>
                        
                        <?php
                        
                    }
                }
                
                ?>

                <li class="share-end"></li>
            </ul>
        </div>
    </div>
</div>