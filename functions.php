<?php 
if ( ! function_exists( 'invertment_setup' ) ) {

    function invertment_setup() {

        load_theme_textdomain( 'invertment', get_template_directory() . '/languages' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_editor_style();
        add_theme_support( 'post-thumbnails' );

        add_image_size( 'invertment_blog_thumbnail', 366, 244, true );
        add_image_size( 'invertment_blog_single_thumbnail', 1110, 740, true );

        register_nav_menus( [
            'primary' => esc_html__( 'Primary Menu', '' ),
            'footer_menu_one' => esc_html__( 'Footer Menu One', '' ),
            'footer_menu_two' => esc_html__( 'Footer Menu Two', '' ),
            'footer_menu_three' => esc_html__( 'Footer Menu Three', '' ),
        ] );

        add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption' ]);

        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'woocommerce' );

        if ( ! isset( $content_width ) ) $content_width = 900;

        $args = array(
            'default-image'      => '',
            'default-text-color' => '000',
            'width'              => 1000,
            'height'             => 250,
            'flex-width'         => true,
            'flex-height'        => true,
        );

        add_theme_support( 'custom-header', $args );
    }
}

add_action( 'after_setup_theme', 'invertment_setup' );


add_action( 'wp_enqueue_scripts', 'farid_frontend_scripts'  );

if( !function_exists('farid_frontend_scripts') ) {

    function farid_frontend_scripts() {
        wp_register_style( 'bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css' );
        wp_register_style( 'style', get_stylesheet_directory_uri() .'/css/style.css' );

        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( 'style' );

        wp_enqueue_script( 'jquery' );
        wp_register_script('bootstrap', get_template_directory_uri() .'/js/bootstrap.min.js', ['jquery'], false, true );
        wp_enqueue_script('bootstrap');

        wp_register_script('main', get_template_directory_uri() .'/js/main.js', ['jquery'], false, true );
        wp_enqueue_script('main');

        wp_localize_script( 'main', 'farid',
            array(
                'ajaxurl'        => admin_url( 'admin-ajax.php' ),
                'nonce'          => wp_create_nonce( "farid-nonce" )
            )
        );
    }
}


// class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  
//   public function start_lvl( &$output, $depth = 0, $args = null ) {
//     $indent = str_repeat("\t", $depth);
//     $output .= "\n$indent<div class=\"multistep-wrap\"><div class=\"container\"><ul class=\"multistep-menus row\">\n";
//   }

// }


// add_filter( 'wp_nav_menu_items', 'prefix_add_div', 10, 2 );

// function prefix_add_div( $items, $args ) {
//     $items = '<div></div>' . $items . '<div></div>';
//     return $items;
// }

function menu_item_desc( $item_id, $item ) {
    $menu_item_desc = get_post_meta( $item_id, '_menu_item_desc', true );
    ?>
    <div style="clear: both;">
        <span class="description"><?php _e( "Item Description", 'menu-item-desc' ); ?></span><br />
        <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
        <div class="logged-input-holder">
            <input type="text" name="menu_item_desc[<?php echo $item_id ;?>]" id="menu-item-desc-<?php echo $item_id ;?>" value="<?php echo esc_attr( $menu_item_desc ); ?>" />
        </div>
    </div>
    <?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'menu_item_desc', 10, 2 );


function save_menu_item_desc( $menu_id, $menu_item_db_id ) {
    if ( isset( $_POST['menu_item_desc'][$menu_item_db_id]  ) ) {
        $sanitized_data = sanitize_text_field( $_POST['menu_item_desc'][$menu_item_db_id] );
        update_post_meta( $menu_item_db_id, '_menu_item_desc', $sanitized_data );
    } else {
        delete_post_meta( $menu_item_db_id, '_menu_item_desc' );
    }
}
add_action( 'wp_update_nav_menu_item', 'save_menu_item_desc', 10, 2 );

add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart', 9999, 2 );
   
function bbloomer_only_one_in_cart( $passed, $added_product_id ) {
   wc_empty_cart();
   return $passed;
}

require_once 'inc/customizer.php';
require_once 'inc/checkout.php';
require_once 'inc/wc-functions.php';
require_once 'inc/class-wp-bootstrap-navwalker.php';