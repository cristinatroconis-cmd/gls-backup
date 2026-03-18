<?php
if ($loop->have_posts()) :
    $class = ($background ? 'backed' : 'imaged');
    ?>    
    <div class="col-12">
        <div class="row">
            <ul id="sb-slider" class="sb-slider <?php echo $class; ?>">                
                <?php
                $count = 0;
                while ($loop->have_posts()) : $loop->the_post();
                    $id = get_the_ID();
                    while (have_rows('slide')) :
                        the_row();
                        $title = get_sub_field('slide_title', $id);
                        $subtitle = get_sub_field('slide_subtitle', $id);
                        $des = get_sub_field('slide_description', $id);
                        $img = get_sub_field('slide_img', $id);
                        $cta_title = get_sub_field('slide_cta_title', $id);
                        $cta_url = get_sub_field('slide_cta_url', $id);
                        ?>
                        <li id="slide_<?php echo $count + 1; ?>" class="slide_box">
                            <a href="<?php echo $cta_url; ?>" title="<?php echo $title; ?>" rel="nofollow">                                            
                                <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                            </a>

                            <div class="slide_text_box container">  
                                <div class="sb-description">
                                    <div class="slide_text">
                                        <h2 class="title"><?php echo $title; ?></h2>
                                        <?php if ($subtitle): ?>
                                            <h3 class="subtitle"><?php echo $subtitle; ?></h3>
                                            <?php
                                        endif;
                                        if ($des):
                                            ?>
                                            <div class="description"><?php echo $des; ?></div>
                                            <?php
                                        endif;
                                        if ($cta_title):
                                            ?>
                                            <a class="_cta btn btn-default" href="<?php echo $cta_url; ?>" title="<?php echo $title; ?>" rel="nofollow">
                                                <?php echo $cta_title; ?>
                                            </a>
                                        <?php endif
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endwhile;
                    ?>
                    <?php
                endwhile;
                $count++;
                wp_reset_postdata();
                ?>
            </ul>

            <div id="shadow" class="shadow"></div>

            <div id="nav-arrows" class="nav-arrows">
                <a href="#">Next</a>
                <a href="#">Previous</a>
            </div>

            <div id="nav-dots" class="nav-dots">
                <span class="nav-dot-current"></span>
                <?php
                for ($i = 0; $i < $count; $i++):
                    ?>
                    <span></span>
                    <?php
                endfor;
                ?>
            </div>
        </div>
    </div>
    <?php
    wp_enqueue_style('slicebox', get_template_directory_uri() . $_THEME_CONFIG['modules_path'] . "slider/css/lib/slicebox.css", array(), "1.0");
    wp_enqueue_style('cslicebox', get_template_directory_uri() . $_THEME_CONFIG["modules_path"] . "slider/css/slider_slicebox.css", array(), null);

    wp_register_script('cmodernizer', get_template_directory_uri() . $_THEME_CONFIG["modules_path"] . 'slider/js/lib/modernizr.custom.46884.js', array(), "1.0", true);
    wp_register_script('slicebox', get_template_directory_uri() . $_THEME_CONFIG["modules_path"] . 'slider/js/lib/jquery.slicebox.js', array('cmodernizer'), "1.0", true);
    wp_register_script('jslicebox', get_template_directory_uri() . $_THEME_CONFIG["modules_path"] . "slider/js/slider_slicebox.js", array('slicebox'), null, true);

    wp_enqueue_script('cmodernizer');
    wp_enqueue_script('slicebox');
    wp_enqueue_script('jslicebox');
 endif;