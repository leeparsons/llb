<article id="post-<?php the_ID(); ?>">
<?php
    
    get_template_part('content-excerpt-header');
        
        get_template_part('post-by', true);
        
        if (has_post_thumbnail()) {
            //see if the cache image exists? should speed things up!
            echo '<div class="spacer"></div>';
            love_image_cache();
            
            
        }

        
    

        if (get_post_custom_values('show_comments_reel_in_excerpt', get_the_ID())) {
            echo '<div class="entry-content live-broadcast-iframe">';
            the_excerpt();
            echo '<p><a href="#" class="fr popup-click" style="font-size:18px;">click to view in popup screen</a></p>';
            echo '</div>';
            get_template_part('content-embed-comments');
        } else {
            echo '<div class="entry-content">';
            the_excerpt();
            echo '</div>';
            get_template_part('content-excerpt-comments', get_post_format());
        }
        
        ?>
</article>