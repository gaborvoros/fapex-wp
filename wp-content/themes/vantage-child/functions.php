<?php
/**
 * Enqueue the parent theme stylesheet and add custom js file
 */
function vantage_child_enqueue_parent_style()
{
    wp_enqueue_style('vantage-parent-style', get_template_directory_uri() . '/style.css', array(), '1.0.2', '');

}
add_action('wp_enqueue_scripts', 'vantage_child_enqueue_parent_style', 8);

function fapex_theme_js() {
    wp_register_style('theme-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('theme-css');
    wp_enqueue_style( 'vantage-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'vantage-parent-style' ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_script( 'theme_bootstrap_js', get_stylesheet_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'theme_custom_js', get_stylesheet_directory_uri() . '/js/vantage-child.js', array( 'jquery' ), '1.0', true );
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
        'name' => __('Footer', 'vantage-child'),
        'id' => 'sidebar-footer',
        'description' => __('Fapex Custom Footer', 'vantage-child'),
        'before_widget' => '<div class="panel-grid-cell"><div class="so-panel widget widget_circleicon-widget panel-first-child panel-last-child">',
        'after_widget' => '</div></div>',
        'before_title' => '<h6 class="footer-widgets-item">',
        'after_title' => '</h6><hr>',
    ));
}

function fapex_legal_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Legal Links', 'vantage-child' ),
            'id' => 'legal-side-bar',
            'description' => __( 'Legal Links', 'vantage-child' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'fapex_legal_sidebar', 12);

/************************/
/* Woocommerce override */
/************************/

//add contact link after short description
add_action('woocommerce_single_product_summary', 'woocommerce_template_add_contact_link', 25);
function woocommerce_template_add_contact_link()
{
    if(pll_current_language() == 'en'){
        echo '<a class="button short-description__contact-button" href="' . get_permalink( get_page_by_path( 'contact' ) ) . '">'.__( 'Contact', 'vantage-child' ).'</a>';
    }else if (pll_current_language() == 'hu'){
        echo '<a class="button short-description__contact-button" href="' . get_permalink( get_page_by_path( 'kapcsolat' ) ) . '">'.__( 'Contact', 'vantage-child' ).'</a>';
    }

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

    $productRange = get_post_meta($post_id, 'wpcf-product-range', true);
    if (!empty($productRange)) {
        $tabs['productRange_tab'] = array(
            'title' => __('Product Range', 'vantage-child'),
            'priority' => 5,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-product-range', $post_id)
        );
    }

    if (!empty($product->get_attributes()['specification'])) {
        $tabs['specification_tab'] = array(
            'title' => __('Specification', 'vantage-child'),
            'priority' => 51,
            'callback' => 'fapex_specification_tab_content'
        );
    }

    $uses = get_post_meta($post_id, 'wpcf-uses', true);
    if (!empty($uses)) {
        $tabs['uses_tab'] = array(
            'title' => __('Uses', 'vantage-child'),
            'priority' => 52,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-uses', $post_id)
        );
    }

    $instructions = get_post_meta($post_id, 'wpcf-instructions', true);
    if (!empty($instructions)) {
        $tabs['instructions_tab'] = array(
            'title' => __('Instructions', 'vantage-child'),
            'priority' => 53,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-instructions', $post_id)
        );
    }

    $productRange = get_post_meta($post_id, 'wpcf-benefits', true);
    if (!empty($productRange)) {
        $tabs['benefits_tab'] = array(
            'title' => __('Benefits', 'vantage-child'),
            'priority' => 54,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-benefits', $post_id)
        );
    }

    $productRange = get_post_meta($post_id, 'wpcf-technical-specification', true);
    if (!empty($productRange)) {
        $tabs['technicalSpecification_tab'] = array(
            'title' => __('Technical Specification', 'vantage-child'),
            'priority' => 55,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-technical-specification', $post_id)
        );
    }

    $faqs = get_post_meta($post_id, 'wpcf-faqs', true);
    if (!empty($faqs)) {
        $tabs['faqs_tab'] = array(
            'title' => __('FAQs', 'vantage-child'),
            'priority' => 56,
            'callback' => 'fapex_custom_tab_content',
            'callback_parameters' => array('wpcf-faqs', $post_id)
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

function fapex_search_args($query){
    $customFields = get_option('relevanssi_index_fields');
    $customFieldsArray = explode(', ', $customFields);

    $the_query = [];

    forEach($customFieldsArray as $customField){
        $the_query[] = array( 'key' => $customField, 'value' => $query, 'compare' => 'LIKE' );
    }

    $the_query['relation'] = 'OR';

    $args = array(
        'post_type' => 'product',
        'meta_query'    => $the_query
    );

    return $args;
}
add_action( 'after_setup_theme', 'my_theme_setup' );
function my_theme_setup(){
    load_theme_textdomain( 'vantage-child', get_template_directory() . '/languages' );
}

add_filter('woocommerce_related_products', 'get_custom_related_products');
function get_custom_related_products($related_products){
    global $product;

    $product_cats_ids = wc_get_product_term_ids( $product->get_id(), 'product_cat' );
    $product_cat_id = $product_cats_ids[0];

    $products = [];
    foreach ($related_products as $related_product){
        $term_list = wp_get_post_terms($related_product,'product_cat',array('fields'=>'ids'));
       if(in_array($product_cat_id, $term_list)){
           $products[] = $related_product;
       }
    }
    return $products;
}