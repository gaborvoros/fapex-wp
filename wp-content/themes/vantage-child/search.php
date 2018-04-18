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
	<div id="content" class="site-content search-results" role="main">
		<div class="search-results__page">


          <?php if (have_posts()) : ?>

				 <h1><?php echo __('On Content Pages', 'vantage-child'); ?></h1>
				 <header class="page-header">
                 <?php if (siteorigin_page_setting('page_title')) : ?>
						  <h2 id="page-title"><?php printf(__('Search Results on Content Pages for: %s', 'vantage-child'), '<span>' . get_search_query() . '</span>'); ?></h2>
                 <?php endif; ?>
				 </header><!-- .page-header -->

              <?php /* Start the Loop */ ?>
              <?php while (have_posts()) : the_post(); ?>

                  <?php get_template_part('content'); ?>

              <?php endwhile; ?>

              <?php vantage_content_nav('nav-below'); ?>

          <?php else : ?>

              <?php get_template_part('templates/search/no-results', 'search'); ?>

          <?php endif; ?>

		</div>

		<div class="search-results__product">
          <?php wp_reset_postdata(); ?>
          <?php $args = fapex_search_args(get_search_query()); ?>
          <?php $the_query = new WP_Query($args); ?>

		</div>
       <?php if ($the_query->have_posts()) : ?>

			 <h1><?php echo __('On Product Pages', 'vantage-child'); ?></h1>
			 <header class="page-header">
              <?php if (siteorigin_page_setting('page_title')) : ?>
					  <h2 id="page-title"><?php printf(__('Search Results on Product Pages for: %s', 'vantage-child'), '<span>' . get_search_query() . '</span> '); ?></h2>
              <?php endif; ?>
			 </header><!-- .page-header -->

           <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

               <?php get_template_part('templates/search/search_content_product'); ?>

           <?php endwhile; ?>

       <?php else : ?>
           <?php get_template_part('templates/search/no-results_product', 'search'); ?>
       <?php endif; ?>

       <?php wp_reset_postdata(); ?>

	</div><!-- #content .site-content -->
</section><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
