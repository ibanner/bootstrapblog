<div class="blog-post airport">
	<h2 class="blog-post-title airport-title"><?php the_title(); ?> (<?php echo get_post_meta( get_the_ID(), 'airport_iata_code' , true); ?>) </h2>
	<p class="blog-post-meta airport-meta"><?php the_date(); ?> by <a href="#"><?php the_author(); ?></a></p>

	<?php if ( has_post_thumbnail() ) {
	  the_post_thumbnail();
	} ?>
	<?php the_content(); ?>

</div><!-- /.blog-post /.airport -->