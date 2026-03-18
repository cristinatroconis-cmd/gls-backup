<?php get_header(); 
$titulooculto = get_field('titulooculto');
?>

<main class="contenido">
    <div class="page-pred">
        <header class="row header-box invisible">
            <div class="col-12">
                <?php if($titulooculto): ?>
                <h1 class="text-center"><?php echo $titulooculto; ?></h1>
                <?php else: ?>
                <h1 class="title-blue"><?php the_title(); ?></h1>
                <?php endif; ?>
            </div>
        </header>
        <section class="cabecera ">
            <div class="container">
            	<div class="row">
            		<div class="col-12 col-lg-6">

                        <?php if($titulo): ?>
                    	<h2 class="h1"><?php echo $titulo; ?></h2>
                		<?php else: ?>
                        <h2 class="h1"><?php the_title(); ?></h2>
                        <?php endif; ?>
                        	
                    </div>

        		<?php if(has_post_thumbnail()): ?>
                    <div class="col-12 col-lg-6">
				        <div class="img"><?php the_post_thumbnail('full'); ?></div>
                    </div>
				<?php endif; ?>
            </div>
        </section>
    </div>
    <div class="container-fluid">
        <div class="row content-box">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>