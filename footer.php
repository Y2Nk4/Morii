			<!-- footer -->
			<footer class="footer" role="contentinfo">

				<!-- copyright -->
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>, All rights reserved.
                    <br>
                    <?php echo stripslashes(get_option('morii_footer_title')); ?>
				</p>
				<!-- /copyright -->

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

        <?php echo stripslashes(get_option('morii_footer_js')); ?>

        <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/zooming@2.1.1/build/zooming.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/photo.js?ver=1.3"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.1.0/dist/lazyload.min.js"></script>

	</body>
</html>
