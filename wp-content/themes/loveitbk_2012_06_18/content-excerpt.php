<article id="post-<?php the_ID(); ?>">
<?php
    
    get_template_part('content-excerpt-header');
        
        get_template_part('post-by', true);
        
        if (has_post_thumbnail()) {
            //see if the cache image exists? should speed things up!
            echo '<div class="spacer"></div>';
            love_image_cache();
            
        }

        
        ?>
	<div class="entry-content">
<?php the_excerpt(); ?>
        
	</div>
    <?php
        
        get_template_part('content-excerpt-comments', get_post_format());
        
        ?>
</article>