<article id="post-<?php the_ID(); ?>" class="hero">
    <a href="<?php the_permalink(); ?>"><span class="r"><?php the_title(); ?></span></a>

    <?php
        
        $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');

        ?><img src="<?php echo $img[0]; unset($img); ?>" width="1020" height="326"/>
</article>