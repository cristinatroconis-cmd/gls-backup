<script src="<?php echo get_stylesheet_directory_uri(); ?>/modules/mini-lightbox/mini-lightbox.min.js"></script>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/modules/mini-lightbox/mini-lightbox.css">

<style>
    div.ml_box {position: fixed;top: 0;bottom: 0;right: 0;left: 0;background: rgba(20, 45, 65, 0.9);text-align: center;}
    div.ml_box img {max-width: 90%; max-height: 90%; vertical-align: middle; margin: auto; position: absolute; top: 0; bottom: 0; left: 0; right: 0; cursor: zoom-out; cursor: -webkit-zoom-out; border-radius: 4px; }
    div.ml_box .animated,div.ml_box.animated { -webkit-animation-duration: 0.5s; animation-duration: 0.5s;}
    .container img { cursor: -webkit-zoom-in; cursor: zoom-in;}
    .animated { -webkit-animation-duration: 0.5s; animation-duration: 0.5s;}
</style>

<script type="text/javascript">
    MiniLightbox.customClose = function () {
        var self = this;
        self.img.classList.add("animated", "fadeOutDown");
        setTimeout(function () {
            self.box.classList.add("animated", "fadeOut");
            setTimeout(function () {
                self.box.classList.remove("animated", "fadeOut");
                self.img.classList.remove("animated", "fadeOutDown");
                self.box.style.display = "none";
            }, 400);
        }, 400);
        return false;
    };

    MiniLightbox.customOpen = function () {
        this.box.classList.add("animated", "fadeIn");
        this.img.classList.add("animated", "fadeInUp");
    };

    window.onload = function () {
        MiniLightbox(".lightbox-gallery img");
    };
</script>