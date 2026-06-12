		</main><!-- .wrapper -->

		<footer class="site-footer">
			<div class="site-footer-inner">
				<div class="footer-left">
					<p class="footer-disclaimer">
						<?php _e( 'Disclaimer: CMI Student Blogs is a student-run publication. The views and opinions expressed here are those of the individual student authors and do not necessarily reflect the official policy or position of the Chennai Mathematical Institute (CMI) or its administration.', 'fukasawa' ); ?>
					</p>
					<p class="footer-copyright">
						&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
					</p>
				</div>
				<div class="footer-right">
					<p class="footer-quote"><?php _e( 'For the Students, By The Students, Of the Students', 'fukasawa' ); ?></p>
				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>

	</body>
</html>