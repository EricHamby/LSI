<?php get_header(); ?>
<?php get_template_part( 'homepage', 'welcome' ); ?>
<div id="main">
  <div class="portfolio-slider">
    <?php get_template_part( 'homepage', 'slider' ); ?>
  </div>
  <div class="index-block">
    <div class="blog-stats"> <?php echo eh_get_option('eh_site_info_side'); ?> </div>
    <div class="blog-list">
      <?php get_template_part( 'homepage', 'loop' ); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>