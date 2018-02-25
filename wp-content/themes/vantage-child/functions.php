<?php
/**
 * Enqueue the parent theme stylesheet.
 */


function vantage_child_enqueue_parent_style()
{
    wp_enqueue_style('vantage-parent-style', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'vantage_child_enqueue_parent_style', 8);

add_action('widgets_init', 'parent_override', 11);
function parent_override()
{

    unregister_sidebar('sidebar-footer');
    /** I have looked for the ID of the sidebar by looking at
     *  the source code in the admin.. and saw the widget's id="sidebar-4"
     */

    register_sidebar(array(
        'name' => __('Footer', 'vantage'),
        'id' => 'sidebar-footer',
        'description' => __('Fapex Cutom Footer', 'vantage'),
        'before_widget' => '<div class="panel-grid-cell"><div class="so-panel widget widget_circleicon-widget panel-first-child panel-last-child">',
        'after_widget' => '</div></div>',
        'before_title' => '<h6 class="footer-widgets-item">',
        'after_title' => '</h6><hr>',
    ));
}


/* Woocommerce override*/

//add contact link after short description
add_action('woocommerce_single_product_summary', 'woocommerce_template_add_contact_link', 25);
function woocommerce_template_add_contact_link()
{
    echo '<a href="' . get_permalink(4) . '">Contact</a>';
}

/*add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);
function woo_rename_tabs($tabs)
{

    $tabs['additional_information']['title'] = __('Specification');    // Rename the additional information tab

    return $tabs;

}*/

// Remove the additional information tab
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);
function woo_remove_product_tabs($tabs)
{
    unset($tabs['additional_information']);

    return $tabs;

}

//remove h2 heading from tabs
//add_filter('woocommerce_product_description_heading', '__return_null');

//add new tabs
add_filter('woocommerce_product_tabs', 'woo_new_product_tab');
function woo_new_product_tab($tabs)
{
    // Adds the new tab
    global $product;

    if (!empty($product->get_attributes()['specification'])) {
        $tabs['specification_tab'] = array(
            'title' => __('Specification', 'woocommerce'),
            'priority' => 50,
            'callback' => 'woo_specification_tab_content'
        );
    }

    if (!empty($product->get_attributes()['video'])) {
        $tabs['video_tab'] = array(
            'title' => __('Video', 'woocommerce'),
            'priority' => 51,
            'callback' => 'woo_video_tab_content'
        );
    }
    return $tabs;
}

function woo_specification_tab_content()
{
    // The new tab content
    global $product;
    do_action('woocommerce_product_specification', $product);
}

function woo_video_tab_content()
{
    // The new tab content
    global $product;
    do_action('woocommerce_product_video', $product);
}

add_action('woocommerce_product_specification', 'wc_display_specification', 10);

function wc_display_specification($product)
{

    set_query_var('product', $product);
    set_query_var('attribute', $product->get_attributes()['specification']);
    get_template_part('templates/single-product/product-attributes');
}

add_action('woocommerce_product_video', 'wc_display_video', 11);

function wc_display_video($product)
{

    set_query_var('product', $product);
    set_query_var('attribute', $product->get_attributes()['video']);
    get_template_part('templates/single-product/product-attributes');
}
