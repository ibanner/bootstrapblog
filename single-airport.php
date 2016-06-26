<?php get_header(); ?>
single-airport.php
	<div class="row">
		<div class="col-sm-12">

			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();
  	
					get_template_part( 'content-airport', get_post_format() );
  
				endwhile; endif; 
			?>

	</div> <!-- /.row -->

<?php get_footer(); ?>