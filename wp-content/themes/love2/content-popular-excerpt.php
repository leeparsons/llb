<article><?php
    
    if (has_post_thumbnail()) {
        //see if the cache image exists? should speed things up!
        echo '<div class="spacer"></div>';
        love_image_cache('popular-post', 198, '', true, 'popular-post-a');
    }
    
    
    
    ?><h4 class="popular-title"><a href="<?php the_permalink() ?>"><? the_title() ?></a></h4>
  <p class="popular-meta meta"><a href="/<?php the_date('Y/m'); ?>/"><time class="date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M. jS, Y'); ?></time></a></p></article>