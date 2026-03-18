<div class="" id="box-social">
    <ul class="list-inline d-inline-block mb-0">    
        <?php if(get_option('options_twitter')): ?>
            <li><a rel="nofollow" href="<?php echo get_option('options_twitter'); ?>" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
        <?php endif; ?>
        
        <?php if(get_option('options_facebook')): ?>
            <li><a rel="nofollow" href="<?php echo get_option('options_facebook'); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/facebook.svg" alt="Facebook" title="Facebook"></a></li>
        <?php endif; ?>

        <?php if(get_option('options_linkedin')): ?>
            <li><a rel="nofollow" href="<?php echo get_option('options_linkedin'); ?>" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
        <?php endif; ?>

        <?php if(get_option('options_youtube')): ?>
            <li><a rel="nofollow" href="<?php echo get_option('options_youtube'); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/youtube.svg" alt="Youtube" title="Youtube"></a></li>
        <?php endif; ?>

        <?php if(get_option('options_instagram')):?>
            <li><a rel="nofollow" href="<?php echo get_option('options_instagram'); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/instagram.svg" alt="Instagram" title="Instagram"></a></li>
        <?php endif; ?>

        <?php if(get_option('options_pinterest')): ?>
            <li><a rel="nofollow" href="<?php echo get_option('options_pinterest'); ?>" target="_blank"><i class="fab fa-pinterest" aria-hidden=" true"></i></a></li>
        <?php endif; ?>
		
		<?php if(get_option('options_tiktok')): ?>
            <li><a rel="nofollow" href="<?php echo get_option('options_tiktok'); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/tiktok.svg" alt="Tiktok" title="Tiktok"></a></li>
        <?php endif; ?>
    </ul>
</div>