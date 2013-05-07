<div id="footer" class="col-full">
  <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_class' => 'footer-navigation', ) ); ?>
  <div class="clear"></div>
  <div class="contact-info">
    <p><?php echo eh_get_option('eh_site_address'); ?> <br/>
      <br/>
      <a href="mailto:<?php echo eh_get_option('eh_site_email'); ?>"><?php echo eh_get_option('eh_site_email'); ?></a> </p>
  </div>
</div>
</div>
<!--/wrapper-->
<?php wp_footer(); ?>
</body></html>