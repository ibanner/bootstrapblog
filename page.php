<?php get_header(); ?>
page.php
	<div class="row">
		<div class="col-sm-12">

			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();
  	
					get_template_part( 'content', get_post_format() );
  
				endwhile; endif; 
			?>

		</div> <!-- /.col -->
	</div> <!-- /.row -->

<?php get_footer(); ?>