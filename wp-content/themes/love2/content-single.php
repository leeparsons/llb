<?php

    $aUrl = get_author_posts_url( get_the_author_meta( 'ID' ) );

    $author_url = get_the_author_meta('user_url');

    $show_twitter_comments = get_post_custom_values('show_comments_reel_in_excerpt', get_the_ID());


    
    
    ?><article>
    <?php edit_post_link(); ?>

	<div class="entry-content">
        <div style="margin:-17px -17px 20px -17px">
            <?php love_image_cache('single-featured', 660); ?>
        </div>
        <header>
            <h1 class="section-title"><span><?php the_title(); ?></span><span class="stripe"></span></h1>
            <?php get_template_part('content-author-meta-no-title') ?>
        </header>
       <?php the_content(); ?>
	</div>
    <?php get_template_part('content-author-meta') ?>
    <section class="social fl w100">
    <?php

    if ($show_twitter_comments === false || (is_array($show_twitter_comments) && $show_twitter_comments[0] == 0)) {
        ?><h4 class="section-title"><span>Share this</span><span class="stripe"></span></h4><div class="abs-soc"><?php
            
            get_template_part('social-links');
            
            
            ?></div><?php
            
    } else {
        
        get_template_part('content-embed-comments');
        
    }
    
    
    ?>
    </section>
</article>