<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php if ( siteorigin_page_setting( 'page_title' ) ) : ?>
				<h1 id="page-title"><?php printf( __( 'Search Results for: %s', 'vantage' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<?php endif; ?>
		</header><!-- .page-header -->

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content' ); ?>

		<?php endwhile; ?>

		<?php vantage_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'search' ); ?>

	<?php endif; ?>
		 <?php
       wp_reset_postdata();
		 ?>
		 <?php
		 $args = fapex_search_args(get_search_query());
      /* $args = array(
           'post_type'     => 'product',
           'meta_key'      => 'wpcf-instructions',
           'meta_value'        => 'Instructions',
           'meta_compare'  => 'LIKE' );*/

       // The Query
       $the_query = new WP_Query( $args );

       // The Loop
       if ( $the_query->have_posts() ) {

           while ( $the_query->have_posts() ) : $the_query->the_post();
           echo 'hejj';
               get_template_part( 'content' );
           endwhile;

       } else {
           echo 'hoo';
       }
       /* Restore original Post Data */
       wp_reset_postdata();

		 ?>

	</div><!-- #content .site-content -->
</section><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
