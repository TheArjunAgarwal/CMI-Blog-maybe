<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">
		
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
		 
		<?php wp_head(); ?>
	
	</head>
	
	<body <?php body_class(); ?>>

		<?php 
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open(); 
		}
		?>

		<a class="skip-link button" href="#site-content"><?php _e( 'Skip to the content', 'fukasawa' ); ?></a>
	
		<header class="site-header">
			<div class="site-header-inner">
				
				<div class="site-branding">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo-link">
						<?php
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						if ( $custom_logo_id ) {
							$logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
							echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="cmi-logo-img" />';
						} else {
							// Sleek, premium CMI badge logo
							echo '<div class="cmi-logo-badge">CMI</div>';
						}
						?>
						<div class="site-title-group">
							<span class="site-title-main"><?php bloginfo( 'name' ); ?></span>
							<span class="site-title-sub"><?php _e( 'Student Blogs', 'fukasawa' ); ?></span>
						</div>
					</a>
				</div><!-- .site-branding -->

				<button type="button" class="nav-toggle" aria-label="Toggle navigation menu">
					<div class="bars">
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
					</div>
				</button>

				<nav class="main-navigation">
					<ul class="main-menu">
						<?php 
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array( 
								'container' 		=> '', 
								'echo'				=> true,
								'items_wrap' 		=> '%3$s',
								'theme_location' 	=> 'primary'
							) );
						} else {
							wp_list_pages( array(
								'container' => '',
								'title_li' 	=> ''
							) );
						} 
						?>
					</ul>
				</nav>

			</div><!-- .site-header-inner -->
		</header><!-- .site-header -->

		<div class="mobile-navigation">
			<ul class="mobile-menu">
				<?php 
				if ( has_nav_menu( 'primary' ) ) {
					$primary_nav = wp_nav_menu( array( 
						'container' 		=> '', 
						'echo'				=> false,
						'items_wrap' 		=> '%3$s',
						'theme_location' 	=> 'primary'
					) );
					echo $primary_nav;
				} else {
					$pages_list = wp_list_pages( array(
						'container' => '',
						'echo'		=> false,
						'title_li' 	=> ''
					) );
					echo $pages_list;
				} 
				?>
			 </ul>
		</div><!-- .mobile-navigation -->

		<main class="wrapper" id="site-content">