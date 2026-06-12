<?php
/**
 * Template part for CMI post card display on home page columns.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cmi-card' ); ?>>
	<div class="cmi-card-body">
		<a href="<?php the_permalink(); ?>" class="cmi-card-link-wrapper">
			<h3 class="cmi-card-title"><?php the_title(); ?></h3>
			<?php
			$excerpt = get_the_excerpt();
			if ( ! $excerpt ) {
				$excerpt = get_the_content();
			}
			$excerpt = wp_strip_all_tags( strip_shortcodes( $excerpt ) );
			$excerpt = mb_strimwidth( $excerpt, 0, 80, '...' );
			?>
			<p class="cmi-card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
		</a>
	</div>
	
	<div class="cmi-card-footer">
		<?php
		$author_id   = get_the_author_meta( 'ID' );
		$author_name = get_the_author();
		$grad_year   = get_the_author_meta( 'cmi_grad_year' );
		
		if ( $grad_year ) {
			if ( strpos( $grad_year, "'" ) === false ) {
				if ( strlen( $grad_year ) == 2 ) {
					$grad_year = "'" . $grad_year;
				} elseif ( strlen( $grad_year ) == 4 ) {
					$grad_year = "'" . substr( $grad_year, 2 );
				}
			}
			$author_name .= ' ' . $grad_year;
		}
		
		$avatar_url = get_the_author_meta( 'cmi_custom_avatar' );
		if ( ! $avatar_url ) {
			$avatar_url = get_avatar_url( $author_id, array( 'size' => 64 ) );
		}
		
		$author_link = get_author_posts_url( $author_id );
		?>
		<a href="<?php echo esc_url( $author_link ); ?>" class="cmi-card-author">
			<span class="cmi-author-name"><?php echo esc_html( $author_name ); ?></span>
			<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( get_the_author() ); ?>" class="cmi-author-avatar" />
		</a>
	</div>
</article>
