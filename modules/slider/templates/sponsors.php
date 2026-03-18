<?php
if (have_rows('sponsors', 'option')):
    echo "<script src='" . idento_get_module_file_uri('slider', "js/lib/multislider.js") . "'></script>";
    $numelg = get_field("numelg", 'option');
    $numemd = get_field("numemd", 'option');
    $numesm = get_field("numesm", 'option');
    $numexs = get_field("numexs", 'option');
    $numexxs = get_field("numexxs", 'option');
    $interval = get_field("interval", 'option');
    ?>
    <section id="sponsors" class="container-fluid">
        <div class="row">
            <div class="container">
                <h2 class="h2 title"><?php _e("Partners y certificaciones", "identofmk"); ?></h2>  

                <div class="multislider">
                    <?php
                    $count = 0;
                    while ($count < $numelg + 4):
                        while (have_rows('sponsors', 'option')): the_row();
                            $image = get_sub_field('sponsor_image');
                            ?>

                            <div class="item" style="position: absolute;top: 0;left: 0;opacity: 0;<?php echo ($count === 0 ? "position:inherit;" : ""); ?>">
                                <div class="box"> 
                                    <div class="sponsor">
                                        <img src="<?php echo $image["url"]; ?>" alt="<?php echo $image["alt"]; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                        endwhile;
                        reset_rows();
                    endwhile;
                    ?>
                    <div class="multislider-navigation">
                        <a class="navigation multi-prev"><i class="fa fa-angle-left"></i></a>
                        <a class="navigation multi-next"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var sponsors = new MultiSlider("sponsors",<?php echo $numelg . "," . $numemd . "," . $numesm . "," . $numexs . "," . $numexxs . "," . $interval ?>);
        setTimeout(function () {
            sponsors.start();
        }, 500);
        window.onresize = function () {
            setTimeout(function () {
                sponsors.restart();
            }, 500);
        };
    </script>
    <?php
    wp_enqueue_style('multislider', idento_get_module_file_uri('slider', "css/lib/multislider.css"), array(), null);
endif;
