<?php
/**
 * Template Name: Submit Images
 */
 get_header(); ?>
<div id="main">
  <?php
      if (current_user_can('administrator')) {
          echo '<div class="box error-box">
	Im sorry, You are an Administrator. This page is for Photographers to submit thier great work.</div>';  
	  } 
	  else if (current_user_can('photographer')) { 
         echo do_shortcode('[feEditor]'); } 
	  else { 
	    echo '<div class="box error-box">
	Im sorry, You must be a pro user to submit images.</div>';  
	  }  ?>
</div>
<?php get_footer(); ?>
