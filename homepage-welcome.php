<div class="invite-box">
  <div class="invite-welcome-text">
    <div class="info">
    <?php echo eh_get_option('eh_site_info'); ?>
    </div>
    <div class="start"><a href="<?php echo eh_get_option('eh_site_url'); ?>"><?php echo eh_get_option('eh_site_text'); ?></a></div>
  </div><?php get_template_part( 'homepage', 'rotator' ); ?>
</div>