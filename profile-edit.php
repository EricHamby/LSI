<?php get_header();
/**
 * Template Name: Edit Profile
 */
 ?>
<div id="main">
<?php
  if (current_user_can('photographer')) {
		 get_template_part( 'profile-edit-', 'photographer' ); } 
	  else if (current_user_can('subscriber')) { 
        get_template_part( 'profile-edit-', 'subscriber' ); } ?>
</div><!--/main-->
<?php get_footer(); ?>