<?php get_header(); ?>
<?php $airport_iata_code = get_post_meta( get_the_ID(), 'airport_iata_code' , true); ?>

	<div class="row">
		<div class="col-sm-12">

			<?php 
				$args =  array( 
					'post_type' => 'airport',
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
				 $custom_query = new WP_Query( $args );
            while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

				<div class="blog-post airport-cpt">
					<h2 class="blog-post-title airport-cpt-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> (<?php echo $airport_iata_code ?>) </h2>
					<?php the_excerpt(); ?>
				</div>

				<?php endwhile; ?>
		</div> <!-- /.col -->
	</div> <!-- /.row -->

	<?php get_footer(); ?>