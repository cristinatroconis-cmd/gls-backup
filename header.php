<?php
/**
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title(''); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link href="//www.google-analytics.com" rel="dns-prefetch">
    
    <!-- Agregar el favicon si está configurado -->
    <?php if (get_option('options_favicon')): ?>
        <link href="<?php echo esc_url(wp_get_attachment_url(get_option('options_favicon'))); ?>" rel="shortcut icon">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url(wp_get_attachment_url(get_option('options_favicon'))); ?>">
    <?php endif; ?>

    <?php wp_head(); ?>

    <!-- Verificación Google -->
    <meta name="google-site-verification" content="V3pHUqJBabGjIhJzVduzq4PpwyDRSbtgqlaltPtVDGw" />
</head>

<body <?php body_class(); ?>>
    
    <div id="page" class="site">

        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_html(get_option('options_codigo_google_tag_manager')); ?>" 
                height="0" 
                width="0" 
                style="display:none;visibility:hidden">
            </iframe>
        </noscript>

        <!-- Header -->
        <header id="page-header" class="header header_fixed header_sticky" data-header-animation="" data-header-sticky-theme="bg-accent-primary-1" data-header-sticky-logo="header_logo-mini" data-header-logo="header_logo-mini">
    <div class="container-fluid header__controls header__container">
        <div class="row justify-content-between align-items-center">
            <!-- Logotipo personalizable -->
            <div class="col text-left header__col-left">
                <a class="logo" href="https://granadaluxurysuites.com/">
                    <div class="logo__wrapper-img logo__wrapper-img_no-margin">
                        <img class="logo__img-primary" src="https://granadaluxurysuites.com/wp-content/uploads/Logo-mini.svg" alt="Granada Luxury Suites">
                    </div>
                </a>
            </div>

            <!-- Menú Horizontal -->
            <div class="col-auto text-center d-none d-lg-block">
                <nav class="header-menu">
                    <ul class="horizontal-menu">
                        <li><a href="/apartamentos">Propiedades</a></li>
                        <li><a href="/experiencias">Experiencias</a></li>
                        <li><a href="/propietarios">Propietarios</a></li>
                    </ul>
				</nav>
            </div>

            <!-- Icono "Hamburguesa" -->
            <div class="col-auto text-center">
                <div id="js-burger" class="header__burger">
                    <div class="header__burger-line"></div>
                    <div class="header__burger-line"></div>
                </div>
            </div>
        </div>
        
        <!-- Menú Overlay Hambuguesa -->
        <div class="header__wrapper-overlay-menu">

 		 <button class="overlay-close" aria-label="Cerrar menú">
    	   <span></span>
           <span></span>
         </button>
		<!-- Contenido del Menú -->
  		<div class="header__wrapper-menu">
		  <?php
			wp_nav_menu([
			  'theme_location' => 'menu-overlay',
			  'menu_class'     => 'menu-overlay',
			  'container'      => false,
			  'fallback_cb'    => false,
		    ]);
		  ?>
		 </div>

		</div>

	</header>

        <div id="content"><!-- content -->
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16911769102">
        </script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'AW-16911769102');
        </script>