<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="article-header">
            <!-- post date -->
            <span class="date"><?php the_time('F j, Y'); ?></span>

            <!-- post title -->
            <h2 class="post-title">
                <!--<a href="<?php /*the_permalink(); */?>" title="<?php /*the_title(); */?>"></a>-->
                <?php the_title(); ?>
            </h2>
            <!-- /post title -->

            <span class="location"><?php echo get_post_meta(get_the_ID(), 'location', true); ?></span>
        </div>

		<!-- post details -->
        <?php the_content(); ?>
		<!-- /post details -->

		<?php edit_post_link(); ?>

        <hr class="article-split-line">
	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
