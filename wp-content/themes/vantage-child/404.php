<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<div id="primary" class="content-area page-not-found">
	<div id="content" class="site-content" role="main">

		<article id="post-0" class="post error404 not-found">

			<div class="entry-main">


				<?php do_action('vantage_entry_main_top') ?>


				<div class="entry-content">
                <?php

                if(pll_current_language() == 'en'){
                    $post = get_page_by_path( '404-page-not-found' );
                }else if (pll_current_language() == 'hu'){
                    $post = get_page_by_path( '404-oldal' );
					 }

                $content = apply_filters('the_content', $post->post_content);
                echo $content;
                ?>

					<div class="text-center">
						<h3><?php echo apply_filters( 'vantage_404_message', __( 'Maybe try the search', 'vantage' ) ); ?></h3>
					</div>

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


					<div class="text-center">
						<h3><?php echo apply_filters( 'vantage_404_message', __( 'Or click here to get back to the homepage', 'vantage' ) ); ?></h3>
						<p><a href="/index.php" class="button">Go Back To Home</a></p>
					</div>

				</div><!-- .entry-content -->

				<?php do_action('vantage_entry_main_bottom') ?>

			</div><!-- .entry-main -->

		</article><!-- #post-0 .post .error404 .not-found -->

	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>
