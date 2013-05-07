<?php 
/** 
 * Image script by Eric Hamby
 * EricHamby.Com
 * Get an image from the current posts content and display it on the homepage
 *
 * @param int $width the width to display the image
 * @param int $height the height to display the image
 */
 define('BM_BLOGPATH', get_bloginfo('template_url'));
function eh_postImage($width = 0, $height = 0, $zc = '', $id = -1, $content = '', $title = '') {

	$theImageDetails = bm_getPostImage($id, $content, $title);
	$theImageSrc = $theImageDetails['src'];
	$theImageSrc = preg_replace ('#\?.*#', '', $theImageSrc);

	// if src found, then create a new img tag
	if (strlen($theImageSrc)) {
		
		$altText = '';
		
		if ($theImageDetails['alt'] != '') {
			$altText = $theImageDetails['alt'];
		}
		$imagePath = BM_BLOGPATH . '/inc/timthumb.php?src=' . $theImageSrc . '&w=' . $width . '&zc=' . $zc . '&h=' . $height;
		$theImage = '<img src="' . $imagePath . '" width="' . $width . '" height="' . $height . '" alt="' . $altText . '" />';
		
		$theImage = apply_filters('bm_theThumbnailImage', $theImage);
		
		return $theImage;
		
	}
	
	return FALSE;

}


/**
 * get the first image associated with a post
 */
function bm_getPostImage($id = -1, $content = '', $title = '') {

	if ($id < 0) {
		global $post;
		$id = $post->ID;
		$content = $post->post_content;
		$title = get_the_title();
	}
	
	$theImageSrc = '';
	
	$imageArray = array(
		'Image',
		'image'
	);

	// check for custom fields
	foreach ($imageArray as $image) {
		$values = get_post_custom_values($image, $id);
		if(isset($values[0]) && $values[0] != '') {
			$theImageSrc = $values[0];
			break;
		}
	}
	
	// regex on post content
	if ($theImageSrc == '') {
		if ($content != '') {
			// use regex to find the src of the image
			preg_match_all ('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches);
			
			$imageCount = count ($matches);
			
			if ($imageCount >= 1) {
				for ($i = 1; $i <= $imageCount; $i += 2) {
					if (isset($matches[$i][0])) {
						$theImageSrc = $matches[$i][0];
						break;
					}
				}
			}
		}
	}
	
	// post attachments
	if ($theImageSrc == '') {
		$values = get_children(array('post_parent' => $id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order'));
		if ($values) {
			foreach ($values as $childId => $attachment) {
				// add check for image post_mime_type (jpg, gif, png)
				$theImageSrc = wp_get_attachment_image_src($childId, 'full');
				$theImageSrc = $theImageSrc[0];
				break;
			}
		}
	}
	
	
	
	// return values
	$ret = array(
		'src' => $theImageSrc,
		'alt' => __('Thumbnail') . ' : ' . $title,
	);
	
	$ret = apply_filters('bm_getPostImage', $ret);
	
	return $ret;

}

/**
 * work out the path to the image if WordPress mu is used
 */
function get_image_path($theImageSrc) {
global $blog_id;
if(isset($blog_id) && $blog_id > 0) {
$imageParts = explode('/sites/' , $src);
if(isset($imageParts[1])) {
$theImageSrc = '/uploads/' . $blog_id . '/sites/' . $imageParts[1];
}
}
return $theImageSrc;
}

function get_image_url($theImageSrc) {
if($img_src!="") $theImageSrc = $img_src;
else $theImageSrc = strstr(wp_get_attachment_url(get_post_thumbnail_id($post_id)), "/wp-content");
global $blog_id;
if (isset($blog_id) && $blog_id > 0) {
    $imageParts = explode('/sites/', $theImageSrc);
    if (isset($imageParts[1])) {
        $theImageSrc = '/uploads/' . $blog_id . '/sites/' . $imageParts[1];
    }
}
echo $theImageSrc;
}

function get_image_stuff ($post_id = null) {
	if ($post_id == null) {
		global $post;
		$post_id = $post->ID;
	}
	$theImageSrc = get_post_meta($post_id, 'Image', true);
	global $blog_id;
	if (isset($blog_id) && $blog_id > 0) {
		$imageParts = explode('/sites/', $theImageSrc);
		if (isset($imageParts[1])) {
			$theImageSrc = '/uploads/' . $blog_id . '/sites/' . $imageParts[1];
		}
	}
	return $theImageSrc;
}

 ?>