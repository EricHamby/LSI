<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_framework_theme'),
		'two' => __('Two', 'options_framework_theme'),
		'three' => __('Three', 'options_framework_theme'),
		'four' => __('Four', 'options_framework_theme'),
		'five' => __('Five', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('Basic', 'options_framework_theme'),
		'type' => 'heading');


	$options[] = array(
		'name' => __('META Description', 'options_framework_theme'),
		'id' => 'eh_meta_description',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('META Keywords', 'options_framework_theme'),
		'id' => 'eh_meta_keywords',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('META Copyright', 'options_framework_theme'),
		'id' => 'eh_meta_copyright',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Social Buttons', 'options_framework_theme'),
		'desc' => __('Show social buttons in header', 'options_framework_theme'),
		'id' => 'social_buttons',
		'std' => '0',
		'type' => 'checkbox');		
		
	$options[] = array(
		'name' => __('Facebook Link', 'options_framework_theme'),
		'id' => 'eh_social_facebook',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Twitter Link', 'options_framework_theme'),
		'id' => 'eh_social_twitter',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Pinterest Link', 'options_framework_theme'),
		'id' => 'eh_social_pinterest',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Homepage', 'options_framework_theme'),
		'type' => 'heading');	
		
	$options[] = array(
		'name' => __('Sign Up Link Text', 'options_framework_theme'),
		'id' => 'eh_site_text',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Sign Up Link URL', 'options_framework_theme'),
		'id' => 'eh_site_url',
		'type' => 'text');
		
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 10,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('Site Information', 'options_framework_theme'),
		'id' => 'eh_site_info',
		'type' => 'editor',
		'settings' => $wp_editor_settings );	
		
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 10,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('Site Stats Sidebar', 'options_framework_theme'),
		'id' => 'eh_site_info_side',
		'type' => 'editor',
		'settings' => $wp_editor_settings );	
			
		
    $options[] = array(
		'name' => __('Footer', 'options_framework_theme'),
		'type' => 'heading');		
		
	$options[] = array(
		'name' => __('Footer Email Contact', 'options_framework_theme'),
		'id' => 'eh_site_email',
		'type' => 'text');
		
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('Footer Address Contact', 'options_framework_theme'),
		'id' => 'eh_site_address',
		'type' => 'editor',
		'settings' => $wp_editor_settings );								

			
		

	$options[] = array(
		'name' => __('Rotator', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Rotator #1', 'options_framework_theme'),
		'id' => 'eh_rotator_1',
		'type' => 'upload');		
	$options[] = array(
		'name' => __('Rotator #2', 'options_framework_theme'),
		'id' => 'eh_rotator_2',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Rotator #3', 'options_framework_theme'),
		'id' => 'eh_rotator_3',
		'type' => 'upload');		




	$options[] = array(
		'name' => __('Slider', 'options_framework_theme'),
		'type' => 'heading' );
		
	$options[] = array(
		'name' => __('Slider #1', 'options_framework_theme'),
		'id' => 'eh_slide_image_1',
		'type' => 'upload');
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #1 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_1',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
					
	$options[] = array(
		'name' => __('Slider #2', 'options_framework_theme'),
		'id' => 'eh_slide_image_2',
		'type' => 'upload');
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #2 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_2',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Slider #3', 'options_framework_theme'),
		'id' => 'eh_slide_image_3',
		'type' => 'upload');
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #3 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_3',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
		$options[] = array(
		'name' => __('Slider #4', 'options_framework_theme'),
		'id' => 'eh_slide_image_4',
		'type' => 'upload');	
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #4 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_4',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
			
	$options[] = array(
		'name' => __('Slider #5', 'options_framework_theme'),
		'id' => 'eh_slide_image_5',
		'type' => 'upload');
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #5 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_5',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Slider #6', 'options_framework_theme'),
		'id' => 'eh_slide_image_6',
		'type' => 'upload');
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #6 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_6',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
		
		$options[] = array(
		'name' => __('Slider #7', 'options_framework_theme'),
		'id' => 'eh_slide_image_7',
		'type' => 'upload');
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #7 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_7',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
				
	$options[] = array(
		'name' => __('Slider #8', 'options_framework_theme'),
		'id' => 'eh_slide_image_8',
		'type' => 'upload');
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' ) );	
	$options[] = array(
		'name' => __('Slider #8 Backside', 'options_framework_theme'),
		'id' => 'eh_slide_text_8',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

	return $options;
}