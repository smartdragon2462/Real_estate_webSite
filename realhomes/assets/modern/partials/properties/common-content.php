<?php
/**
 * Contains content part for multiple properties pages
 */

if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php if ( get_the_content() ) : ?>
			<div class="rh_content rh_page__content">
				<?php the_content(); ?>
			</div>
			<!-- /.rh_content -->
		<?php endif; ?>

	<?php endwhile; ?>
<?php endif; ?>

