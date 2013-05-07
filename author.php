<?php get_header(); 
$thisauthor = get_userdata(intval($author));
$author_user = $wp_query->get_queried_object();
?>
<div id="main">
<?php
  if (user_can($author_user, 'photographer')) { 
      get_template_part( 'author', 'photographer' ); }
  else if (user_can($author_user, 'subscriber')) { 
      get_template_part( 'author', 'subscriber' ); }
?>
</div><!--/main-->
<?php get_footer(); ?>