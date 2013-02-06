<article id="post-<?php the_ID(); ?>" class="search-result">
    <h2 class="search-entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2><?php
        
        
        get_template_part('post-by', true);
        
        ?>
		<div class="entry-summary">
            <?php
                
                love_image_cache('small-thumb', 140, 'tmb');
                
			the_excerpt();
                
                ?>
		</div>
</article>