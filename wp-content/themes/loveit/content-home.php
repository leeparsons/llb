<article id="post-<?php the_ID(); ?>" class="hero">
    <a href="<?php the_permalink(); ?>"><span class="r"><?php the_title(); ?></span></a>
    <?php the_post_thumbnail('full'); ?>
</article>