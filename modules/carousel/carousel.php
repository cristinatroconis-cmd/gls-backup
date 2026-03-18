<div class="carousel_box col-12">
    <div class="carousel flexslider">
        <ul class="slides">
            <?php 
            while( have_rows('carr_imgs') ): 
                the_row(); 
                $image = get_sub_field('car_img');
		      ?>
                <li data-thumb="<?php echo $image;?>">
                    <img src="<?php echo $image;?>" alt="<?php the_title();?>" />
                </li>
                <?php
            endwhile; ?>
        </ul>
    </div>
</div>