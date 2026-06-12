<?php
/**
 * Template part for displaying related posts (Also on CMI) grid items.
 */
?>

<div class="cmi-related-card">
	<a href="<?php the_permalink(); ?>" class="cmi-related-card-link">
		
		<div class="cmi-related-thumbnail">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'post-thumb' ); ?>
			<?php else : ?>
				<div class="cmi-related-thumbnail-placeholder">
					<!-- Geometric abstract block matching page 2's theme -->
					<div class="cmi-placeholder-pattern"></div>
				</div>
			<?php endif; ?>
		</div>
		
		<div class="cmi-related-meta">
			<span class="cmi-related-date"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ' . __( 'ago', 'fukasawa' ); ?></span>
			<span class="cmi-related-comments">
				&bull; 
				<?php comments_number( __( '0 comments', 'fukasawa' ), __( '1 comment', 'fukasawa' ), __( '% comments', 'fukasawa' ) ); ?>
			</span>
		</div>
		
		<h4 class="cmi-related-title"><?php the_title(); ?></h4>
		
	</a>
</div>
