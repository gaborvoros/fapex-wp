<?php
/**
 * Enqueue the parent theme stylesheet and add custom js file
 */
function vantage_child_enqueue_parent_style()
{
    wp_enqueue_style('vantage-parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'vantage_child_enqueue_parent_style', 8);

function fapex_theme_js() {
    wp_register_style('theme-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('theme-css');
    wp_enqueue_script( 'theme_js', get_stylesheet_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'theme_js', get_stylesheet_directory_uri() . '/js/vantage-child.js', array( 'jquery' ), '1.0', true );
}
add_action('wp_enqueue_scripts', 'fapex_theme_js');


/*
 * override parents sidebar and add custom widget to footer
 */
add_action('widgets_init', 'parent_override', 11);
function parent_override()
{

    unregister_sidebar('sidebar-footer');

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

/************************/
/* Woocommerce override */
/************************/

//add contact link after short description
add_action('woocommerce_single_product_summary', 'woocommerce_template_add_contact_link', 25);
function woocommerce_template_add_contact_link()
{
    echo '<a href="' . get_permalink(4) . '">Contact</a>';
}


// Remove the additional information tab
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);
function woo_remove_product_tabs($tabs)
{
    unset($tabs['additional_information']);

    return $tabs;

}

//add custom tabs
add_filter('woocommerce_product_tabs', 'fapex_new_product_tabs');
function fapex_new_product_tabs($tabs)
{
    global $product;
    $post_id = get_the_ID();

    if (!empty($product->get_attributes()['specification'])) {
        $tabs['specification_tab'] = array(
            'title' => __('Specification', 'woocommerce'),
            'priority' => 50,
            'callback' => 'fapex_specification_tab_content'
        );
    }

    $uses = get_post_meta($post_id, 'wpcf-uses', true);
    if (!empty($uses)) {
        $tabs['uses_tab'] = array(
            'title' => __('Uses', 'woocommerce'),
            'priority' => 51,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-uses', $post_id)
        );
    }

    $instructions = get_post_meta($post_id, 'wpcf-instructions', true);
    if (!empty($instructions)) {
        $tabs['instructions_tab'] = array(
            'title' => __('Instructions', 'woocommerce'),
            'priority' => 52,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-instructions', $post_id)
        );
    }

    $faqs = get_post_meta($post_id, 'wpcf-faqs', true);
    if (!empty($faqs)) {
        $tabs['faqs_tab'] = array(
            'title' => __('FAQs', 'woocommerce'),
            'priority' => 53,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-faqs', $post_id)
        );
    }

    $productRange = get_post_meta($post_id, 'wpcf-product-range', true);
    if (!empty($productRange)) {
        $tabs['productRange_tab'] = array(
            'title' => __('Product Range', 'woocommerce'),
            'priority' => 54,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-product-range', $post_id)
        );
    }

    return $tabs;
}

function fapex_specification_tab_content(){
    global $product;
    do_action('fapex_product_specification', $product);
}

add_action('fapex_product_specification', 'fapex_display_specification', 10);
function fapex_display_specification($product){
    set_query_var('product', $product);
    set_query_var('attribute', $product->get_attributes()['specification']);
    get_template_part('templates/single-product/product-attributes');
}

function fapex_custom_tab_content($tab_name, $tab){
    $metaParam = $tab['callback_parameters'][0];
    $post_id = $tab['callback_parameters'][1];
    do_action('fapex_product_customtabs', $metaParam, $post_id);
}

add_action('fapex_product_customtabs', 'fapex_display_customtabs', 11, 2);
function fapex_display_customtabs($metaParam, $post_id){
    echo get_post_meta($post_id, $metaParam, true);
}
