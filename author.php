<?php
/**
 * The template for displaying Author Archive pages.
 */

get_header();

$author_id   = get_queried_object_id();
$author_name = get_the_author_meta( 'display_name', $author_id );
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
	$major_display = esc_html( $major ) . ' &bull; Class of ' . esc_html( str_replace( "'", '20', $grad_year ) );
} else {
	$major_display = esc_html( $major );
}

$avatar_url = get_the_author_meta( 'cmi_custom_avatar', $author_id );
if ( ! $avatar_url ) {
	$avatar_url = get_avatar_url( $author_id, array( 'size' => 200 ) );
}

// Calculate total views for this author
$author_posts = get_posts( array(
	'author'         => $author_id,
	'posts_per_page' => -1,
	'post_type'      => 'post',
) );
$total_views = 0;
foreach ( $author_posts as $p ) {
	$total_views += (int) get_post_meta( $p->ID, 'cmi_post_views', true );
}
$post_count = count( $author_posts );
?>

<div class="cmi-author-archive-container">
	
	<!-- AUTHOR PROFILE HEADER -->
	<header class="cmi-author-profile-block">
		<div class="cmi-author-profile-inner">
			
			<div class="cmi-author-profile-main">
				<div class="cmi-author-profile-avatar-box">
					<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="cmi-author-profile-avatar" />
				</div>
				<div class="cmi-author-profile-meta">
					<h1 class="cmi-author-profile-name"><?php echo esc_html( $author_name ); ?></h1>
					<p class="cmi-author-profile-major"><?php echo $major_display; ?></p>
					
					<div class="cmi-profile-stats">
						<span class="cmi-profile-stat">
							<strong><?php echo esc_html( $post_count ); ?></strong> <?php _e( 'posts', 'fukasawa' ); ?>
						</span>
						<span class="cmi-profile-stat">
							<strong><?php echo esc_html( $total_views ); ?></strong> <?php _e( 'reads', 'fukasawa' ); ?>
						</span>
					</div>
				</div>
			</div>
			
			<div class="cmi-author-profile-bio">
				<h2 class="cmi-bio-title"><?php _e( 'Biography', 'fukasawa' ); ?></h2>
				<?php if ( $author_bio ) : ?>
					<div class="cmi-bio-content"><?php echo wpautop( esc_html( $author_bio ) ); ?></div>
				<?php else : ?>
					<p class="cmi-bio-content cmi-empty-bio"><?php echo sprintf( __( '%s is a student at CMI and a blogger on the CMI Student Blogs.', 'fukasawa' ), esc_html( $author_name ) ); ?></p>
				<?php endif; ?>
			</div>
			
		</div>
	</header>

	<!-- RECENT POSTS LIST -->
	<div class="cmi-author-posts-section">
		<h2 class="cmi-section-title"><?php _e( 'Recent Posts', 'fukasawa' ); ?></h2>
		
		<?php if ( have_posts() ) : ?>
			<div class="cmi-author-posts-list">
				<?php while ( have_posts() ) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'cmi-author-post-item' ); ?>>
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="cmi-author-post-thumbnail">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'post-thumb' ); ?>
								</a>
							</div>
						<?php endif; ?>
						
						<div class="cmi-author-post-details">
							<h3 class="cmi-author-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							
							<div class="cmi-author-post-meta">
								<span class="cmi-author-post-date"><?php echo get_the_date(); ?></span>
								<span class="cmi-author-post-comments-count">
									&bull; 
									<?php comments_number( __( '0 comments', 'fukasawa' ), __( '1 comment', 'fukasawa' ), __( '% comments', 'fukasawa' ) ); ?>
								</span>
								<span class="cmi-author-post-views">
									&bull; 
									<?php echo sprintf( __( '%s reads', 'fukasawa' ), cmi_get_post_views( get_the_ID() ) ); ?>
								</span>
							</div>

							<?php
							$excerpt = get_the_excerpt();
							if ( ! $excerpt ) {
								$excerpt = get_the_content();
							}
							$excerpt = wp_strip_all_tags( strip_shortcodes( $excerpt ) );
							$excerpt = mb_strimwidth( $excerpt, 0, 180, '...' );
							?>
							<p class="cmi-author-post-excerpt"><?php echo esc_html( $excerpt ); ?></p>
							
							<a href="<?php the_permalink(); ?>" class="cmi-author-post-readmore"><?php _e( 'Read Post &rarr;', 'fukasawa' ); ?></a>
						</div>
						
					</article>
					
				<?php endwhile; ?>
			</div>
			
			<?php get_template_part( 'pagination' ); ?>
			
		<?php else : ?>
			<p class="cmi-no-posts"><?php _e( 'This author has not published any posts yet.', 'fukasawa' ); ?></p>
		<?php endif; ?>
	</div>

</div>

<?php get_footer(); ?>
