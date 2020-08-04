<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<div class="page-header">
                <h1><?php _e( 'Photos', 'html5blank' ); ?></h1>

                <p class="header-sub-title"><?php echo get_option('morii_index_title'); ?></p>
                <div>
                    <div class="toggle toggle--daynight">
                        <input type="checkbox" id="toggle--daynight" class="toggle--checkbox">
                        <label class="toggle--btn" for="toggle--daynight"><span class="toggle--feature"></span></label>
                    </div>
                </div>
            </div>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
