<?php
/**
 * The template for displaying all single posts.
 */

get_header(); ?>

<div class="cmi-single-container">
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		$post_id     = get_the_ID();
		$author_id   = get_the_author_meta( 'ID' );
		$author_name = get_the_author();
		$author_bio  = get_the_author_meta( 'description', $author_id );
		$major       = get_the_author_meta( 'cmi_major', $author_id );
		$grad_year   = get_the_author_meta( 'cmi_grad_year', $author_id );
		
		if ( ! $major ) {
			$major = __( 'Student Blogger', 'fukasawa' );
		}
		if ( $grad_year ) {
			if ( strpos( $grad_year, "'" ) === false ) {
				if ( strlen( $grad_year ) == 2 ) {
					$grad_year = "'" . $grad_year;
				} elseif ( strlen( $grad_year ) == 4 ) {
					$grad_year = "'" . substr( $grad_year, 2 );
				}
			}
			$author_name_display = $author_name . ' ' . $grad_year;
		} else {
			$author_name_display = $author_name;
		}

		$avatar_url = get_the_author_meta( 'cmi_custom_avatar', $author_id );
		if ( ! $avatar_url ) {
			$avatar_url = get_avatar_url( $author_id, array( 'size' => 100 ) );
		}

		$post_url   = esc_url( get_permalink() );
		$post_title = esc_attr( get_the_title() );
		?>
		
		<!-- POST HEADER -->
		<header class="cmi-single-header">
			<h1 class="cmi-single-title"><?php the_title(); ?></h1>
			<p class="cmi-single-byline">
				<?php _e( 'by', 'fukasawa' ); ?> 
				<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="cmi-byline-author"><?php echo esc_html( $author_name_display ); ?></a> 
				&bull; <span class="cmi-single-date"><?php echo get_the_date(); ?></span>
			</p>
		</header>

		<!-- FEATURED IMAGE -->
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<div class="cmi-single-featured-image">
				<?php the_post_thumbnail( 'post-image' ); ?>
			</div>
		<?php endif; ?>

		<div class="cmi-single-layout">
			
			<!-- LEFT: MAIN POST CONTENT -->
			<div class="cmi-single-content-area">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'cmi-single-article' ); ?>>
					
					<div class="cmi-article-entry entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array(
							'before'      => '<p class="page-links"><span class="title">' . __( 'Pages:', 'fukasawa' ) . '</span>',
							'after'       => '</p>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) ); ?>
					</div>
					
					<!-- SHARE POST BAR -->
					<div class="cmi-share-bar">
						<span class="cmi-share-label"><?php _e( 'Share this post:', 'fukasawa' ); ?></span>
						<div class="cmi-share-links">
							<!-- Twitter / X -->
							<a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( $post_title ); ?>&url=<?php echo urlencode( $post_url ); ?>" target="_blank" rel="noopener noreferrer" class="cmi-share-link cmi-share-x" aria-label="Share on X">
								<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
							</a>
							<!-- Reddit -->
							<a href="https://reddit.com/submit?title=<?php echo urlencode( $post_title ); ?>&url=<?php echo urlencode( $post_url ); ?>" target="_blank" rel="noopener noreferrer" class="cmi-share-link cmi-share-reddit" aria-label="Share on Reddit">
								<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 11.5c0-1.65-1.35-3-3-3-.96 0-1.86.48-2.42 1.24-1.64-1-3.85-1.64-6.29-1.72l1.21-3.8 3.26.73c.03.96.82 1.74 1.8 1.74 1 0 1.8-.8 1.8-1.8s-.8-1.8-1.8-1.8c-.85 0-1.56.58-1.74 1.37l-3.51-.78c-.29-.07-.58.11-.66.4l-1.4 4.41c-2.52.06-4.8.7-6.48 1.73-.55-.73-1.42-1.19-2.41-1.19-1.65 0-3 1.35-3 3 0 1.09.58 2.04 1.46 2.57-.06.31-.09.64-.09.97 0 3.82 4.72 6.93 10.5 6.93s10.5-3.11 10.5-6.93c0-.33-.03-.66-.09-.97.89-.53 1.47-1.48 1.47-2.57zm-18 0c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zm11 4.5c-1.78 1.78-5.18 1.78-6.96 0-.2-.2-.2-.51 0-.71.2-.2.51-.2.71 0 1.39 1.39 4.16 1.39 5.55 0 .2-.2.51-.2.71 0 .2.2.2.51 0 .71zm-2.45-3c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5z"/></svg>
							</a>
							<!-- Facebook -->
							<a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode( $post_url ); ?>" target="_blank" rel="noopener noreferrer" class="cmi-share-link cmi-share-facebook" aria-label="Share on Facebook">
								<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
							</a>
							<!-- Telegram -->
							<a href="https://t.me/share/url?url=<?php echo urlencode( $post_url ); ?>&text=<?php echo urlencode( $post_title ); ?>" target="_blank" rel="noopener noreferrer" class="cmi-share-link cmi-share-telegram" aria-label="Share on Telegram">
								<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.11.02-1.93 1.23-5.46 3.62-.51.35-.98.53-1.39.52-.46-.01-1.33-.26-1.99-.47-.8-.26-1.45-.4-1.39-.85.03-.24.36-.48.99-.74 3.86-1.68 6.44-2.78 7.74-3.31 3.68-1.53 4.44-1.8 4.94-1.81.11 0 .35.03.5.16.13.11.17.26.19.37.02.13.02.27.01.41z"/></svg>
							</a>
						</div>
					</div>

				</article>

				<!-- RELATED POSTS GRID: ALSO ON CMI -->
				<div class="cmi-related-posts-section">
					<h3 class="cmi-related-title"><?php _e( 'Also on CMI Student Blogs', 'fukasawa' ); ?></h3>
					<div class="cmi-related-grid">
						<?php
						$related_args = array(
							'post_type'           => 'post',
							'posts_per_page'      => 4,
							'post__not_in'        => array( $post_id ),
							'ignore_sticky_posts' => 1,
						);
						
						$tags = wp_get_post_tags( $post_id );
						if ( $tags ) {
							$tag_ids = array();
							foreach ( $tags as $individual_tag ) {
								$tag_ids[] = $individual_tag->term_id;
							}
							$related_args['tag__in'] = $tag_ids;
						} else {
							$cats = wp_get_post_categories( $post_id );
							if ( $cats ) {
								$related_args['category__in'] = $cats;
							}
						}

						$related_query = new WP_Query( $related_args );
						
						// If less than 4 posts found, query latest to fill the grid
						$post_count = $related_query->post_count;
						if ( $post_count < 4 ) {
							$exclude = array( $post_id );
							if ( $post_count > 0 ) {
								foreach ( $related_query->posts as $p ) {
									$exclude[] = $p->ID;
								}
							}
							$fill_query = new WP_Query( array(
								'post_type'           => 'post',
								'posts_per_page'      => 4 - $post_count,
								'post__not_in'        => $exclude,
								'ignore_sticky_posts' => 1,
							) );
						}

						// Loop through related query posts
						if ( $related_query->have_posts() ) {
							while ( $related_query->have_posts() ) {
								$related_query->the_post();
								get_template_part( 'template-parts/cmi-related-card' );
							}
							wp_reset_postdata();
						}
						// Loop through fill query posts if needed
						if ( isset( $fill_query ) && $fill_query->have_posts() ) {
							while ( $fill_query->have_posts() ) {
								$fill_query->the_post();
								get_template_part( 'template-parts/cmi-related-card' );
							}
							wp_reset_postdata();
						}
						?>
					</div>
				</div>

				<!-- COMMENTS -->
				<?php 
				if ( comments_open() || get_comments_number() ) {
					comments_template( '', true );
				} 
				?>

			</div><!-- .cmi-single-content-area -->
			
			<!-- RIGHT: AUTHOR SIDEBAR -->
			<aside class="cmi-single-sidebar">
				
				<!-- ABOUT AUTHOR WIDGET -->
				<div class="cmi-sidebar-widget cmi-author-widget">
					<h3 class="cmi-widget-title"><?php echo sprintf( __( 'About %s', 'fukasawa' ), esc_html( $author_name ) ); ?></h3>
					<div class="cmi-author-widget-body">
						<div class="cmi-author-widget-header">
							<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
								<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="cmi-author-widget-avatar" />
							</a>
							<div class="cmi-author-widget-meta">
								<h4 class="cmi-author-widget-name"><a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php echo esc_html( $author_name ); ?></a></h4>
								<p class="cmi-author-widget-major"><?php echo esc_html( $major ); ?></p>
							</div>
						</div>
						
						<?php if ( $author_bio ) : ?>
							<p class="cmi-author-widget-bio"><?php echo esc_html( wp_trim_words( $author_bio, 28, '...' ) ); ?></p>
						<?php else : ?>
							<p class="cmi-author-widget-bio cmi-empty-bio"><?php _e( 'A student writer at Chennai Mathematical Institute contributing to CMI Student Blogs.', 'fukasawa' ); ?></p>
						<?php endif; ?>
						
						<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="cmi-author-widget-link">
							<?php _e( 'Keep Reading &rarr;', 'fukasawa' ); ?>
						</a>
					</div>
				</div>

				<!-- MORE FROM AUTHOR WIDGET -->
				<?php
				$more_from_author = new WP_Query( array(
					'author'         => $author_id,
					'post__not_in'   => array( $post_id ),
					'posts_per_page' => 4,
				) );

				if ( $more_from_author->have_posts() ) : ?>
					<div class="cmi-sidebar-widget cmi-more-posts-widget">
						<h3 class="cmi-widget-title"><?php echo sprintf( __( 'More from %s', 'fukasawa' ), esc_html( $author_name ) ); ?></h3>
						<ul class="cmi-more-posts-list">
							<?php while ( $more_from_author->have_posts() ) : $more_from_author->the_post(); ?>
								<li>
									<span class="cmi-more-post-date"><?php echo get_the_date(); ?></span>
									<a href="<?php the_permalink(); ?>" class="cmi-more-post-title"><?php the_title(); ?></a>
								</li>
							<?php endwhile; wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php endif; ?>

			</aside><!-- .cmi-single-sidebar -->

		</div><!-- .cmi-single-layout -->

	<?php endwhile; endif; ?>

</div><!-- .cmi-single-container -->

<?php get_footer(); ?>
