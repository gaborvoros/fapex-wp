<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<article id="post-0" class="post no-results not-found">
    <?php if ( siteorigin_page_setting( 'page_title' ) ) : ?>
		 <h2 class="entry-title"><?php _e( 'Nothing Found on Product Pages', 'vantage' ); ?></h2>
    <?php endif; ?>
	<header class="entry-header">

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'vantage' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms on our Product Pages. Take a look at our Content Pages or try again with some different keywords.', 'vantage' ); ?></p>
			<?php //get_search_form(); ?>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<form method="get" class="page-not-found__search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
						<div class="input-group">
							<input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search', 'vantage' ); ?>"/>
							<div class="input-group-btn">
								<button class="btn btn-default search-button" type="submit">
									<i class="vantage-icon-search"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'vantage' ); ?></p>
			<?php //get_search_form(); ?>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<form method="get" class="page-not-found__search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
						<div class="input-group">
							<input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search', 'vantage' ); ?>"/>
							<div class="input-group-btn">
								<button class="btn btn-default search-button" type="submit">
									<i class="vantage-icon-search"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 .post .no-results .not-found -->
