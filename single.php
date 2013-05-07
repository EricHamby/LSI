<?php get_header(); ?>

<div id="main">
  <div class="content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php if(is_category('featured')): ?>class="featured-post"<?php endif; ?>>
      <h1>
        <?php the_title() ;?>
      </h1>
      <div class="the-content">
        <?php the_content(); ?>
        </div>
      <p class="meta"> Published on
        <?php the_time('M j, Y'); ?>
        | 
        by
        <?php the_author_link(); ?>
        |
        in
        <?php the_category(', '); ?>
        |
        <?php
$turl = getTinyUrl(get_permalink($post->ID));
$wpurl = wp_get_shortlink();
echo 'Tiny Url for this post: <a href="'.$turl.'">'.$turl.'</a> ';
echo 'or use: <a href="'.$wpurl.'">'.$wpurl.'</a> ';
?>  </p>
      <div class="prev-next-links">
        <ul>
          <li>
            <?php next_post_link(); ?>
          </li>
          <li>
            <?php previous_post_link(); ?>
          </li>
        </ul>
      </div>
      <?php comments_template(); ?>
    </article>
    <?php endwhile; else: ?>
    <p>Sorry, this post does not exist</p>
    <?php endif; ?>
  </div>
</div>
<?php get_footer(); ?>
