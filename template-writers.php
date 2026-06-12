<?php
/**
 * Template Name: Meet Our Writers
 * Description: A template to list and search all CMI bloggers.
 */

get_header(); ?>

<div class="cmi-writers-container">
	
	<header class="cmi-writers-header">
		<div class="cmi-writer-doodle-decoration">
			<svg class="cmi-header-doodle" viewBox="0 0 100 20" fill="none" stroke="#27187D" stroke-width="1.5">
				<path d="M10 10 C 30 -5, 70 25, 90 10" stroke-linecap="round"/>
			</svg>
		</div>
		<h1 class="cmi-writers-title"><?php _e( 'Meet Our Writers', 'fukasawa' ); ?></h1>
		<p class="cmi-writers-subtitle"><?php _e( 'A community of curious minds sharing ideas, stories, and perspectives from Chennai Mathematical Institute and beyond.', 'fukasawa' ); ?></p>
	</header>

	<div class="cmi-search-wrapper">
		<div class="cmi-search-box">
			<span class="cmi-search-icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<circle cx="11" cy="11" r="8"/>
					<line x1="21" y1="21" x2="16.65" y2="16.65"/>
				</svg>
			</span>
			<input type="text" id="cmi-writer-search" placeholder="<?php esc_attr_e( 'Search authors by name, major, or interest...', 'fukasawa' ); ?>" />
		</div>
	</div>

	<div class="cmi-writers-grid" id="cmi-writers-grid">
		<?php
		// Fetch all writers (users with author, editor, admin, or contributor roles)
		$authors = get_users( array(
			'role__in' => array( 'author', 'editor', 'administrator', 'contributor' ),
			'orderby'  => 'display_name',
			'order'    => 'ASC',
		) );

		if ( ! empty( $authors ) ) :
			foreach ( $authors as $author ) :
				$author_id   = $author->ID;
				$author_name = $author->display_name;
				$author_bio  = get_the_author_meta( 'description', $author_id );
				
				// Post count
				$post_count  = count_user_posts( $author_id );
				
				// Skip users with no bio and no posts to avoid dummy/admin users unless they have updated their meta
				$major       = get_the_author_meta( 'cmi_major', $author_id );
				$grad_year   = get_the_author_meta( 'cmi_grad_year', $author_id );
				
				if ( ! $author_bio && $post_count == 0 && ! $major ) {
					continue;
				}

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
					$major_display = esc_html( $major ) . ' ' . esc_html( $grad_year );
				} else {
					$major_display = esc_html( $major );
				}

				// Sum total views of all author posts
				$author_posts = get_posts( array(
					'author'         => $author_id,
					'posts_per_page' => -1,
					'post_type'      => 'post',
				) );
				
				$total_views = 0;
				foreach ( $author_posts as $p ) {
					$total_views += (int) get_post_meta( $p->ID, 'cmi_post_views', true );
				}

				// Format views
				if ( $total_views >= 1000 ) {
					$formatted_views = round( $total_views / 1000, 1 ) . 'K';
				} else {
					$formatted_views = $total_views;
				}

				// Avatar
				$avatar_url = get_the_author_meta( 'cmi_custom_avatar', $author_id );
				if ( ! $avatar_url ) {
					$avatar_url = get_avatar_url( $author_id, array( 'size' => 120 ) );
				}

				// Border style
				$border_colors = array( 'blue', 'orange', 'green', 'beige', 'purple', 'pink' );
				$border_style  = get_the_author_meta( 'cmi_border_style', $author_id );
				if ( ! $border_style ) {
					$border_style = $border_colors[ $author_id % count( $border_colors ) ];
				}

				// Card icon
				$doodle_icons = array( 'star', 'flower', 'leaf', 'sparkle', 'heart', 'wave' );
				$card_icon    = get_the_author_meta( 'cmi_card_icon', $author_id );
				if ( ! $card_icon ) {
					$card_icon = $doodle_icons[ $author_id % count( $doodle_icons ) ];
				}

				$author_url = get_author_posts_url( $author_id );
				?>
				
				<div class="cmi-writer-card cmi-card-style-<?php echo esc_attr( $border_style ); ?>" 
					 data-name="<?php echo esc_attr( $author_name ); ?>" 
					 data-major="<?php echo esc_attr( $major ); ?>" 
					 data-bio="<?php echo esc_attr( $author_bio ); ?>">
					
					<a href="<?php echo esc_url( $author_url ); ?>" class="cmi-writer-card-link">
						
						<!-- Doodle Decoration Overlay -->
						<div class="cmi-card-doodle-wrapper cmi-doodle-<?php echo esc_attr( $card_icon ); ?>">
							<?php if ( $card_icon === 'star' ) : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php elseif ( $card_icon === 'flower' ) : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M12 12C12 10 10 7 12 7C14 7 12 10 12 12ZM12 12C14 12 17 10 17 12C17 14 14 12 12 12ZM12 12C12 14 10 17 12 17C14 17 12 14 12 12ZM12 12C10 12 7 10 7 12C7 14 10 12 12 12Z" stroke-linecap="round" stroke-linejoin="round"/>
									<circle cx="12" cy="12" r="1.5" fill="currentColor"/>
								</svg>
							<?php elseif ( $card_icon === 'leaf' ) : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M2 22C2 22 6 18 12 17C18 16 22 10 22 2C22 2 14 2 8 8C4 12 2 22 2 22Z" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M12 17C12 17 10 13 6 12" stroke-linecap="round"/>
									<path d="M16 11C16 11 13 9 10 8" stroke-linecap="round"/>
								</svg>
							<?php elseif ( $card_icon === 'sparkle' ) : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M12 3V21M3 12H21M18.36 5.64L5.64 18.36M18.36 18.36L5.64 5.64" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php elseif ( $card_icon === 'heart' ) : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php elseif ( $card_icon === 'wave' ) : ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M2 12C5 8 7 8 10 12C13 16 15 16 18 12C20 9.3 22 10.3 22 10.3M2 17C5 13 7 13 10 17C13 21 15 21 18 17C20 14.3 22 15.3 22 15.3" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php endif; ?>
						</div>

						<div class="cmi-writer-card-inner">
							
							<div class="cmi-writer-avatar-wrapper">
								<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="cmi-writer-avatar" />
							</div>
							
							<div class="cmi-writer-info">
								<h2 class="cmi-writer-name"><?php echo esc_html( $author_name ); ?></h2>
								<div class="cmi-writer-major"><?php echo $major_display; ?></div>
								
								<?php if ( $author_bio ) : ?>
									<p class="cmi-writer-bio"><?php echo esc_html( $author_bio ); ?></p>
								<?php else : ?>
									<p class="cmi-writer-bio cmi-empty-bio"><?php _e( 'Writing mathematical proofs and student diaries at CMI.', 'fukasawa' ); ?></p>
								<?php endif; ?>
								
								<div class="cmi-writer-stats">
									<span class="cmi-stat-item">
										<svg class="cmi-stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
										</svg>
										<strong><?php echo esc_html( $post_count ); ?></strong> <?php _e( 'Posts', 'fukasawa' ); ?>
									</span>
									<span class="cmi-stat-item">
										<svg class="cmi-stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
											<circle cx="12" cy="12" r="3"/>
										</svg>
										<strong><?php echo esc_html( $formatted_views ); ?></strong> <?php _e( 'Reads', 'fukasawa' ); ?>
									</span>
								</div>
							</div>
							
						</div><!-- .cmi-writer-card-inner -->
						
					</a>
					
				</div><!-- .cmi-writer-card -->
				
			<?php
			endforeach;
		else :
			echo '<p class="cmi-no-writers">' . __( 'No writers found.', 'fukasawa' ) . '</p>';
		endif;
		?>
	</div><!-- .cmi-writers-grid -->

</div><!-- .cmi-writers-container -->

<script>
document.addEventListener('DOMContentLoaded', function() {
	const searchInput = document.getElementById('cmi-writer-search');
	const writerCards = document.querySelectorAll('.cmi-writer-card');
	
	if (searchInput) {
		searchInput.addEventListener('input', function(e) {
			const query = e.target.value.toLowerCase().trim();
			writerCards.forEach(card => {
				const name = card.getAttribute('data-name').toLowerCase();
				const major = card.getAttribute('data-major').toLowerCase();
				const bio = card.getAttribute('data-bio').toLowerCase();
				
				if (name.includes(query) || major.includes(query) || bio.includes(query)) {
					card.style.display = '';
				} else {
					card.style.display = 'none';
				}
			});
		});
	}
});
</script>

<?php get_footer(); ?>
