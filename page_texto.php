<?php 
/* Template Name: Página con Grid */
get_header(); 

$titulooculto = get_field('titulooculto');
?>

<main class="container">
    <div class="page-pred">
        <header class="row header-box d-none">
            <div class="col-12">
                <?php if($titulooculto): ?>
                <h1 class="text-center"><?php echo $titulooculto; ?></h1>
                <?php else: ?>
                <h1 class="title-blue"><?php the_title(); ?></h1>
                <?php endif; ?>
            </div>
        </header>
        <div class="row content-box">
            <div class="mx-auto content mt-5 mb-5">
                <h2 class="espaciado"><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</main>


<?php get_footer(); ?>
