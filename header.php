<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="description" content="<?php echo eh_get_option('eh_meta_description'); ?>" />
<meta name="keywords" content="<?php echo eh_get_option('eh_meta_keywords'); ?>" />
<meta name="author" content="<?php echo eh_get_option('eh_meta_copyright'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!-- Include js files -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/js/jquery.flip.js"></script>
<script src="<?php echo get_bloginfo('template_directory'); ?>/js/jquery.bxslider.js"></script>
<!-- Include css sheets -->
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
<link href="<?php echo get_bloginfo('template_directory'); ?>/css/jquery.bxslider.css" rel="stylesheet" />
<link href="<?php echo get_bloginfo('template_directory'); ?>/css/jquery.flip.css" rel="stylesheet" />
<!-- Make things pretty with google fonts - Eric Hamby -->
<link href='http://fonts.googleapis.com/css?family=Allura|Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper"> 
<div id="header">
  <div id="navbar">
    <div id="navbar-container">       
      <!-- Logo -->
      <div class="nav-logo"> <a href="<?php bloginfo( 'url' ); ?>">Learn Shoot Inspire</a> </div>     
      <!-- Navigation -->     
      <div class="navigation">
     <?php if ( eh_get_option('social_buttons') ) { ?> 
        <div class="social-links"> 
         <a href="<?php echo eh_get_option('eh_social_facebook'); ?>" class="fb">Facebook</a> 
         <a href="<?php echo eh_get_option('eh_social_twitter'); ?>" class="tw">Twitter</a> 
         <a href="<?php echo eh_get_option('eh_social_pinterest'); ?>" class="pn">Pinterest</a> 
        </div><?php } ?>
        <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_class' => 'navigation', 'walker' => new My_Walker_Nav_Menu() ) ); ?>
      </div>
    </div>
  </div>
</div>