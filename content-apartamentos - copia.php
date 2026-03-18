<?php
/**
 * Contenido de artículos tipo tarjeta Bootstrap para usar en queries
 */ 

$id = get_the_ID();
$personas = get_field('personas',$id);
$dormitorios = get_field('dormitorios',$id);
$banos = get_field('banos',$id);
$ubicarray = [];
$ubica=get_the_tags($id);
if ($ubica) {
  foreach($ubica as $tag) {
    array_push($ubicarray, $tag->name); 
  }
}
// Check rows existexists.
/*if( have_rows('ediciones',$id) ):
// Loop through rows.
while( have_rows('ediciones',$id) ) : the_row();
$ubica[] = get_sub_field('ubicacion',$id);

    // End loop.
    endwhile;

// No value.
else :
    // Do something...
endif;*/
$classes = [
    'card'
];

$classe = [
    'col-12',
    'col-md-6',
    'col-lg-4',
    'mb-4'
];
$resultado = array_merge($ubicarray, $classes);
$resultados = array_merge($ubicarray, $classe);
?>
<div <?php post_class($resultados); ?>>
	<article id="post-<?php the_ID(); ?>" <?php post_class($resultado); ?> >
		<?php if(the_post_thumbnail('card-thumbnail')): 
		the_post_thumbnail('card-thumbnail'); 
		endif; ?>
		<div class="card-body">
	        <div class="contenido-texto">
	            <h3 class="card-title"><a href="<?php the_permalink();?>" ><?php the_title(); ?></a></h3>
				<?php if(get_the_excerpt()): ?>
	            <div class="descriptor"><!-- d-none d-md-block -->
	                <?php echo the_excerpt(); ?>
	            </div>
				<?php endif; ?>
			
	             <div class="d-flex">
                            <div>
                                <img class="icono-img" src="/wp-content/uploads/personas.png" width="45px">
                            </div>
                            <div class="lista-inicio">
                                <p style="margin: 0px;"><?php echo $personas; ?> PERSONAS</p>
                               
                            </div>
                        </div>
                        <div class="d-flex">
                            <div>
                                <img class="icono-img" src="/wp-content/uploads/dormitorio.png" width="45px">
                            </div>
                            <div class="lista-inicio">
                                <p style="margin: 0px;"><?php echo $dormitorios; ?> DORMITORIOS</p>
                               
                            </div>
                        </div>
                        <div class="d-flex">
                            <div>
                                <img class="icono-img" src="/wp-content/uploads/bano.png" width="45px">
                            </div>
                            <div class="lista-inicio">
                                <p style="margin: 0px;"><?php echo $banos; ?> BAÑOS</p>
                               
                            </div>
                        </div>
			
	            <div class="centrar">
	            	<a href="<?php the_permalink();?>" class="cta-button">
	                <span>Descúbrelo</span><!-- d-md-block d-lg-none -->
	            </a>
	            </div>
	        </div>
	        
	    </div>
	</article>
</div>