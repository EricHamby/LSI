<?php
//EricHamby.Com
add_shortcode('feEditor', 'feEDoShortcode');
add_action('init', 'catch_save_form');
 
 
function catch_save_form()
{
  $errors = array();
  
  if('POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post")
  {
    // Do some minor form validation to make sure there is content
    if(isset ($_POST['title']))
      $title =  $_POST['title'];
    else
      $errors[] = 'Please enter the wine name';

    if(isset ($_POST['description']))
      $description = $_POST['description'];
    else
      $errors[] = 'Please enter some notes';

    $tags = $_POST['post_tags'];

    // ADD THE FORM INPUT TO $new_post ARRAY
    $new_post = array('post_title'      => stripslashes($title),
                      'post_content'    => stripslashes($description),
                      'tags_input'      => stripslashes($tags),
                      'post_status'     => 'publish', // Choose: publish, preview, future, draft, etc.
                      'post_type'       => 'my_gallery', //'post',page' or use a custom post type if you want to
					  'tax_input'    => array(
                        'photo_category'  => $_POST['photo_category']
    )
    );

    //SAVE THE POST
    $pid = wp_insert_post($new_post);
	if ($_FILES) {
	foreach ($_FILES as $file => $array) {
	$newupload = insert_attachment($file,$pid);
	// $newupload returns the attachment id of the file that
	// was just uploaded. Do whatever you want with that now.
	}}
    wp_set_object_terms( $pid, $_POST['photo_category'], 'photo_category' );

    //REDIRECT TO THE NEW POST ON SAVE
    $link = get_permalink( $pid );
    $_POST['form_errors'] = $errors;
    wp_redirect( $link );
    die(); 
  } // END THE IF STATEMENT
}

//WHERE ALL THE MAGIC HAPPENS
function feEDoShortcode()
{
  if(isset($_POST['form_errors']) && !empty($_POST['form_errors']))
    foreach($_POST['form_errors'] as $e)
      echo '<p class="form_error">ERROR: '.$e.'</p>';
  ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <h1 class="entry-title">Submit Your List!</h1>
  </header>
  <div class="entry-content">
    <form id="new_post" name="new_post" method="post" action="" class="wpcf7-form" enctype="multipart/form-data">
      <!-- post name -->
      <fieldset name="name">
        <input type="text" id="title" value="" tabindex="5" name="title" />
      </fieldset>
      
   
      <!-- list type -->
      <fieldset class="category">
   <?php erichamby_custom_taxonomy_dropdown( 'photo_category', 'date', 'DESC', '10', 'photo_category', '', '', 'Select Image Type' ); ?>
      </fieldset>
      
       <!-- list city -->
      <fieldset class="tags space">
        <label for="post_tags">Tag Your Photo</label>
        <input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
      </fieldset>
 
      <!-- image upload -->
      <fieldset class="image space">
       <label class="sizematters">Upload Image</label>
       <input type="file" name="bottle_rear" id="bottle_rear" size="50">
      </fieldset>
      
      <!-- post content -->
      <fieldset class="content space">
        <label for="description">Description and Notes:</label>
        <?php wp_editor("", 'description', array('media_buttons' => false, )); //change media_buttons to true to allow images/videos/music ?>
      </fieldset>
      
      <!-- submit -->
      <fieldset class="submit space">
        <input type="submit" value="Post Review" tabindex="40" id="submit" name="submit" />
      </fieldset>
      
      <input type="hidden" name="action" value="new_post" />
      <?php wp_nonce_field( 'new-post' ); ?>
    </form>
  </div><!-- .entry-content --> 
</article><!-- #post -->
<?php
}
function erichamby_custom_taxonomy_dropdown( $taxonomy, $orderby = 'date', $order = 'DESC', $limit = '-1', $name, $show_option_all = null, $show_option_none = null, $show_option_select = null ) {
	$args = array(
		'orderby' => $orderby,
		'order' => $order,
		'number' => $limit,
		'hide_empty' => 0,
	);
	$terms = get_terms( $taxonomy, $args );
	$name = ( $name ) ? $name : $taxonomy;
	if ( $terms ) {
		printf( '<select name="%s" class="postform">', $name );
		if ( $show_option_select ) {
			printf( '<option>%s</option>', $show_option_select );
		}
		if ( $show_option_all ) {
			printf( '<option value="0">%s</option>', $show_option_all );
		}
		if ( $show_option_none ) {
			printf( '<option value="-1">%s</option>', $show_option_none );
		}
		foreach ( $terms as $term ) {
			printf( '<option value="%s">%s</option>', $term->slug, $term->name );
		}
		print( '</select>' );
	}
}


function insert_attachment($file_handler,$post_id,$setthumb='false') {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

	if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
	return $attach_id;
}
//EricHamby.Com
?>