<div class="woo_social_discounts wsd-sharing-enabled">
    <div class="robots-nocontent wsd-block wsd-social wsd-social-icon wsd-sharing">
        <h3 class="wsd-title"><?php echo $settings['message']; ?></h3>
        <div class="wsd-content">
            <ul>
                
                <?php 
                
                foreach($settings['social_shares'] as $key => $value) {
                    
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