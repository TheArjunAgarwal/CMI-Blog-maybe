<?php
/**
 * The front page template file for CMI Student Blogs.
 * Sets up a 3-column layout (Selected, New, Most Read) with customized card displays.
 */

get_header(); ?>

<div class="cmi-home-container">
	
	<div class="cmi-columns-wrapper">
		
		<!-- COLUMN 1: SELECTED POSTS -->
		<div class="cmi-column cmi-selected-column">
			<h2 class="cmi-column-title"><?php _e( 'Selected Posts', 'fukasawa' ); ?></h2>
			<div class="cmi-column-posts">
				<?php
				// 1. Query Selected Posts (by category/tag slug 'selected' or 'featured', fallback to sticky posts, fallback to random)
				$selected_args = array(
					'post_type'           => 'post',
					'posts_per_page'      => 5,
					'ignore_sticky_posts' => 1,
					'tax_query'           => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'category',
							'field'    => 'slug',
							'terms'    => array( 'selected', 'featured' ),
						),
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'slug',
							'terms'    => array( 'selected', 'featured' ),
						),
					),
				);

				$selected_query = new WP_Query( $selected_args );

				// If no tag/category match, check for sticky posts
				if ( ! $selected_query->have_posts() ) {
					$sticky = get_option( 'sticky_posts' );
					if ( ! empty( $sticky ) ) {
						$selected_query = new WP_Query( array(
							'post_type'           => 'post',
							'post__in'            => $sticky,
							'posts_per_page'      => 5,
							'ignore_sticky_posts' => 1,
						) );
					}
				}

				// If still no posts, fallback to latest posts ordered by comment count or just latest
				if ( ! $selected_query->have_posts() ) {
					$selected_query = new WP_Query( array(
						'post_type'           => 'post',
						'posts_per_page'      => 5,
						'orderby'             => 'rand',
						'ignore_sticky_posts' => 1,
					) );
				}

				if ( $selected_query->have_posts() ) :
					while ( $selected_query->have_posts() ) : $selected_query->the_post();
						get_template_part( 'template-parts/cmi-card' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="cmi-no-posts">' . __( 'No selected posts found.', 'fukasawa' ) . '</p>';
				endif;
				?>
			</div>
		</div>

		<!-- COLUMN 2: NEW POSTS -->
		<div class="cmi-column cmi-new-column">
			<h2 class="cmi-column-title"><?php _e( 'New Posts', 'fukasawa' ); ?></h2>
			<div class="cmi-column-posts">
				<?php
				// 2. Query Latest Posts
				$new_query = new WP_Query( array(
					'post_type'           => 'post',
					'posts_per_page'      => 5,
					'ignore_sticky_posts' => 1,
				) );

				if ( $new_query->have_posts() ) :
					while ( $new_query->have_posts() ) : $new_query->the_post();
						get_template_part( 'template-parts/cmi-card' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="cmi-no-posts">' . __( 'No posts found.', 'fukasawa' ) . '</p>';
				endif;
				?>
			</div>
		</div>

		<!-- COLUMN 3: MOST READ POSTS -->
		<div class="cmi-column cmi-most-read-column">
			<h2 class="cmi-column-title"><?php _e( 'Most Read', 'fukasawa' ); ?></h2>
			<div class="cmi-column-posts">
				<?php
				// 3. Query Most Read Posts (based on our view tracking meta key, fallback to comments count if empty)
				$most_read_args = array(
					'post_type'           => 'post',
					'posts_per_page'      => 5,
					'ignore_sticky_posts' => 1,
				);

				$view_posts = get_posts( array(
					'post_type'      => 'post',
					'meta_key'       => 'cmi_post_views',
					'posts_per_page' => 1,
				) );

				if ( ! empty( $view_posts ) ) {
					$most_read_args['meta_key'] = 'cmi_post_views';
					$most_read_args['orderby']  = 'meta_value_num';
					$most_read_args['order']    = 'DESC';
				} else {
					$most_read_args['orderby']  = 'comment_count';
					$most_read_args['order']    = 'DESC';
				}

				$most_read_query = new WP_Query( $most_read_args );

				if ( $most_read_query->have_posts() ) :
					while ( $most_read_query->have_posts() ) : $most_read_query->the_post();
						get_template_part( 'template-parts/cmi-card' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="cmi-no-posts">' . __( 'No popular posts found.', 'fukasawa' ) . '</p>';
				endif;
				?>
			</div>
		</div>

	</div><!-- .cmi-columns-wrapper -->

</div><!-- .cmi-home-container -->

<?php get_footer(); ?>
