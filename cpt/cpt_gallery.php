<?php
// EricHamby.Com Development
add_action( 'init', 'my_gallery' );
add_action( 'admin_head', 'gallery_custom_help_tab'); // Add CPT help tab. WordPress 3.3.X+ only 
add_filter('manage_my_gallery_posts_columns', 'tcb_add_post_thumbnail_column');
add_filter('manage_my_gallery_pages_columns', 'tcb_add_post_thumbnail_column');
add_action('manage_my_gallery_posts_custom_column', 'tcb_display_post_thumbnail_column', 10, 2);
add_action('manage_my_gallery_pages_custom_column', 'tcb_display_post_thumbnail_column', 10, 2);

function my_gallery() {
  $labels = array(
    'name' => 'My Gallery',
    'singular_name' => 'My Gallery',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Photo',
    'edit_item' => 'Edit My Photo',
    'new_item' => 'New Photo',
    'all_items' => 'All Photos',
    'view_item' => 'View Photos',
    'search_items' => 'Search My Gallery',
    'not_found' =>  'No Photos found',
    'not_found_in_trash' => 'No Photos found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'My Gallery',
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gallery' ),
    'capability_type' => 'post',
    'has_archive' => true, 
	'menu_icon' => get_bloginfo('template_directory') . '/images/cpt-gallery.png',
    'hierarchical' => false,
    'menu_position' => null,
	'taxonomies' => array('post_tag', 'photo_category'),
    'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
  ); 

  register_post_type( 'my_gallery', $args );
  
  register_taxonomy("photo_category", array("my_gallery"), array("hierarchical" => true, "label" => "Photo Category", "singular_label" => "Photo Category", "rewrite" => true, 'show_admin_column' => true,)); 
 
}

// Chnage default title text
function change_default_title( $title ){
     $screen = get_current_screen();
     if  ( 'my_gallery' == $screen->post_type ) {
          $title = 'Enter Your Image Name';
     }
     return $title;
}
add_filter( 'enter_title_here', 'change_default_title' );

// Adds image columns to the admin post page
function tcb_add_post_thumbnail_column($cols){
  $cols['tcb_post_thumb'] = __('Image Preview');
  return $cols;
}
function tcb_display_post_thumbnail_column($col, $id){
  switch($col){  case 'tcb_post_thumb':
    $image = eh_postImage(100, 35, 1); echo $image;
      break;}
}

// Adds help tabs to top of page
function gallery_custom_help_tab() {
	global $post_ID;
	$screen = get_current_screen();

	if( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];
	else $post_type = get_post_type( $post_ID );

	if( $post_type == 'my_gallery' ) :

		$screen->add_help_tab( array(
			'id' => 'gallery_page_one', //unique id for the tab
			'title' => 'Information', //unique visible title for the tab
			'content' => '<h3>Information</h3><p>This is the custom post type for a users to upload thier gallery of images. Users will be able to "delete" the images from the fron end of the site but all images will be avalible to any admin till they decide to delete them for good.</p>',  //actual help text
		));
		
		$screen->add_help_tab( array(
			'id' => 'gallery_page_two', //unique id for the tab
			'title' => 'Help Me', //unique visible title for the tab
			'content' => '<h3>Help Me</h3><p>This is a simple page. The user will not see this page but the form on the front of the site to submit thier work.</p>',  //actual help text
		));

	endif;

}
?>