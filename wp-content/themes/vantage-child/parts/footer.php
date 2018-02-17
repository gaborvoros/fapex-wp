<?php
/**
 * Part Name: Default Footer
 */
?>

<?php if (!siteorigin_page_setting('hide_footer_widgets', false)) : ?>
	 <div class="footer-widget__contact">
		 <div class="full-container">
           <div class="footer-widget__contact__items">
               <?php dynamic_sidebar('sidebar-footer') ?>
			  </div>
		 </div><!-- #footer-widgets -->
	 </div>

<?php endif; ?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <?php $site_info_text = apply_filters('vantage_site_info', siteorigin_setting('general_site_info_text'));
    if (!empty($site_info_text)) : ?>
		 <div id="site-info">
           <?php echo wp_kses_post($site_info_text) ?>
		 </div><!-- #site-info -->
    <?php endif; ?>

</footer><!-- #colophon .site-footer -->
