<?php if ($loop->have_posts()): ?>
<amp-carousel width="400"
  height="300"
  layout="responsive"
  type="slides">
  <amp-img src="/img/image1.jpg"
    width="400"
    height="300"
    layout="responsive"
    alt="a sample image"></amp-img>
  <amp-img src="/img/image2.jpg"
    width="400"
    height="300"
    layout="responsive"
    alt="another sample image"></amp-img>
  <amp-img src="/img/image3.jpg"
    width="400"
    height="300"
    layout="responsive"
    alt="and another sample image"></amp-img>
</amp-carousel>


<!--
    <div id="flex_slider" class="carousel slide slider_box" data-ride="carousel">
        <div class="carousel-inner">

            <?php while ($loop->have_posts()) : $loop->the_post(); $id = get_the_ID(); $cont = 0;
                while (have_rows('slide')) : the_row(); ?> 
                    <div id="slide-<?php echo $id; ?>" class="carousel-item <?php if($cont == 0){echo 'active';} ?>" style="background-image: url('<?php echo get_sub_field('slide_img', $id); ?>')">
                        <?php if(( !get_sub_field('slide_cta_title', $id) ) && ( get_sub_field('slide_cta_url', $id) )): ?><a class="full-anchor" href="<?php echo get_sub_field('slide_cta_url', $id); ?>"></a><?php endif; ?>
                        <div class="slider-overlay">
                            <div class="container d-flex align-items-center">
                                <div class="content-caption">
                                    <span class="pretitle"><?php echo get_sub_field('slide_subtitle', $id); ?></span>
                                    <span class="title h1"><?php echo get_sub_field('slide_title', $id); ?></span>
                                    <div class="description"><?php echo get_sub_field('slide_description', $id); ?></div>
                                    <a class="_cta btn btn-default" href="<?php echo get_sub_field('slide_cta_url', $id); ?>"><?php echo get_sub_field('slide_cta_title', $id); ?></a>
                                </div>
                            </div>
                        </div>
                    </div> 
                <?php $cont++; ?> <?php endwhile; ?> 
            <?php endwhile; wp_reset_postdata(); ?>
            
        </div>
        <a class="carousel-control-prev" href="#flex_slider" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></a>
        <a class="carousel-control-next" href="#flex_slider" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></a>
    </div> -->
<?php endif; ?>
