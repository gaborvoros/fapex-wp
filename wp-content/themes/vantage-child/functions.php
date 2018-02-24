<?php
/**
 * Enqueue the parent theme stylesheet.
 */
function vantage_child_enqueue_parent_style() {
    wp_enqueue_style( 'vantage-parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'vantage_child_enqueue_parent_style', 8 );

add_action( 'widgets_init', 'parent_override', 11 );
function parent_override() {

    unregister_sidebar('sidebar-footer');
    /** I have looked for the ID of the sidebar by looking at
     *  the source code in the admin.. and saw the widget's id="sidebar-4"
     */

    register_sidebar(array(
        'name' => __( 'Footer', 'vantage' ),
        'id' => 'sidebar-footer',
        'description' => __( 'Fapex Cutom Footer', 'vantage' ),
        'before_widget' => '<div class="panel-grid-cell"><div class="so-panel widget widget_circleicon-widget panel-first-child panel-last-child">',
        'after_widget' => '</div></div>',
        'before_title' => '<h6 class="footer-widgets-item">',
        'after_title' => '</h6><hr>',
    ));
}

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

    $tabs['additional_information']['title'] = __( 'Specification' );	// Rename the additional information tab

    return $tabs;

}

/*add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {

    // Adds the new tab

    $tabs['test_tab'] = array(
        'title' 	=> __( 'New Product Tab', 'woocommerce' ),
        'priority' 	=> 50,
        'callback' 	=> 'woo_new_product_tab_content'
    );

    return $tabs;

}
function woo_new_product_tab_content() {

    // The new tab content

    echo '<h2>New Product Tab</h2>';
    echo '<p>Here\'s your new product tab.</p>';

}*/