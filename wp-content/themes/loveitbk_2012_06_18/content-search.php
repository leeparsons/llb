<article id="post-<?php the_ID(); ?>" class="search-result"><?php
    
        get_template_part('content-excerpt-header');
        
        get_template_part('post-by', true);
        
        ?>
		<div class="entry-content">
            <?php
                
                
                
                love_image_cache();

			the_excerpt();
                
                ?>
		</div><?php
get_template_part('content-excerpt-comments', get_post_format());

?></article>