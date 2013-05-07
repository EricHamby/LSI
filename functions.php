<?php
// EricHamby.Com 2013
// Change the value of the author permalink base to whatever you want here
function wpa_author_rewrite_rules(){

    add_rewrite_rule(
        'subscriber/([^/]+)/?$',
        'index.php?author_name=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        'photographer/([^/]+)/?$',
        'index.php?author_name=$matches[1]',
        'top'
    );

}
add_action( 'init', 'wpa_author_rewrite_rules' );
function wpa_author_link( $link, $author_id, $author_nicename ){

    if( user_can( $author_id, 'subscriber' ) ){

        return home_url( 'subscriber/' . $author_nicename . '/' );

    } elseif( user_can( $author_id, 'photographer' ) ) {

        return home_url( 'photographer/' . $author_nicename . '/' );

    }

    return $link;

}

/* Flush rewrite rules for custom post types. */
add_action( 'after_switch_theme', 'bt_flush_rewrite_rules' );
/* Flush your rewrite rules */
function bt_flush_rewrite_rules() {
  flush_rewrite_rules($hard);
}

// Get functions for admin side options
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}

// Remove admin bar from front end
add_filter('show_admin_bar', '__return_false'); 

// Create menus for header and footer
function eh_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' )
    ));} add_action( 'init', 'eh_menus' );
	
// Create menu walker to let us change elements	
class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"children\">\n";
  }
}

// Lets add and remove some user roles
add_role('photographer', 'Photographer', array( 
   'read' => true, ));
remove_role( 'contributor' );
remove_role( 'author' );
remove_role( 'editor' );

// Lets add the custom post types
require_once('cpt/cpt_gallery.php');

// Lets add the posting forms
require_once('forms/gallery_form.php');
require_once('inc/image_grabber.php'); 

// Enable the use of featured thumbnails
add_theme_support('post-thumbnails');

// Create tiny links
function getTinyUrl($url) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
    return $tinyurl;
}
// Kill anyone trying to acess wp-admin
add_action('admin_init', 'no_eh_dashboard');
function no_eh_dashboard() {
  if (!current_user_can('manage_options') && $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
  wp_redirect(home_url()); exit;
  }
}
?>