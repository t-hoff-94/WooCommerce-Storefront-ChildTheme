<div class="post-item" style="background-image:linear-gradient(to top, rgba(26,74,84,1) 0%, rgba(26,74,84,0.9) 22%,rgba(62,174,196,0.7) 100%), url(<?php the_post_thumbnail_url('blog_bg'); ?>);">
  <!-- <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="" /> -->
    <h2 class="headline headline--medium headline--gradient headline--post-title"><a class='c-grey' href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

  <div class="metabox">
    <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
  </div>

  <div class="generic-content">
    <?php
    if(has_excerpt()) {
      echo get_the_excerpt();
    } else { echo wp_trim_words(get_the_content(), 18); } ?>
    <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
  </div>
</div>
