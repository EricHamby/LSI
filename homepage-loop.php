<?php
/**
 * http://erichamby.com
 */
 global $more; $more = 0;
	?>    
    <h1>Recent Blog Posts</h1>
<?php if (have_posts()) : ?>
<?php query_posts("showposts=3"); // show one latest post only ?>
<?php while (have_posts()) : the_post(); ?>


<div class="post-index"> 
  
  <!-- Display the Title as a link to the Post's permalink. -->
  <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
    <?php the_title(); ?>
    </a></h2>
 <?php the_content_rss('', FALSE, '', 40); ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">Read More</a>
 
</div>
<!-- closes the first div box -->

<?php endwhile; ?>
<?php endif;  
?>
