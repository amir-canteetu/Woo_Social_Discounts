<div class="woo_social_discounts wsd-sharing-enabled">
    <div class="robots-nocontent wsd-block wsd-social wsd-social-icon wsd-sharing">
        <h3 class="wsd-title"><?php echo esc_html( $this->settings['message'] ); ?></h3>
        <div class="wsd-content">
            <ul>

                    <?php foreach( $this->settings['social_shares'] as $key => $value ):

                        if ( $value ): ?>

                                <li class="share-<?php echo esc_attr( $key ); ?>">
                                    <a rel="nofollow" class="share-<?php echo esc_attr( $key ); ?> wsd-button share-icon no-text" href="<?php echo esc_url( get_permalink( $post->ID ) . '?wsd_share=' . $key ); ?>" target="_blank" title="<?php echo esc_attr( 'Share on ' . ucfirst($key) ); ?>"">
                                        <span class="sharing-screen-reader-text"><?php echo esc_html( 'Share on ' . ucfirst($key) ); ?></span>
                                    </a>
                                </li>

                        <?php endif; ?>

                    <?php endforeach; ?>

                <li class="share-end"></li>
            </ul>
        </div>
    </div>
</div>