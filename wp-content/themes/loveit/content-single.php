<?php
    
    $aUrl = get_author_posts_url( get_the_author_meta( 'ID' ) );

    
    $show_twitter_comments = get_post_custom_values('show_comments_reel_in_excerpt', get_the_ID());


    
    
    ?><article id="post-<?php the_ID(); ?>"><header class="article-header"><?php

        get_template_part('content-post-header');

        ?></header>
    <?php edit_post_link(); ?>

    <p class="meta"><strong>Posted by:</strong> <a href="<?php echo $aUrl; ?>"><span><?php echo ucwords(get_the_author()); ?></span></a> <strong>On: </strong><a href="/<?php the_date('Y/m'); ?>/"><span class="date"><?php echo get_the_date('M. dS, Y'); ?></span></a></p>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
    <?php
        
        if ($show_twitter_comments === false) {
            get_template_part('social-links', true);
        } else {
            get_template_part('content-embed-comments');
        }
        
        ?>
    <section class="entry-meta">
        <div class="author-posted">
            <p class="t">This entry was posted by <a href="<?php

                echo $aUrl;


            ?>"><?php echo ucwords(get_the_author_meta('display_name')); ?></a></p>
            <p class="author-short-meta"><a href="<?php

                echo $aUrl;

                ?>"><?php
                userphoto_the_author_thumbnail();
                ?></a><?php
                    
                    if (strlen(get_the_author_meta('description')) > 400) {
                        echo nl2br(substr(get_the_author_meta('description'), 0, 400)) . '... <a href="' . $aUrl . '">[read more]</a>';
                    } else {
                        echo nl2br(get_the_author_meta('description'));
                    }
            ?></p>
            <div class="author-link" id="author-link">
					<a href="<?php echo $aUrl; ?>" rel="author">View all posts by <?php echo get_the_author(); ?></a>
		</div>
	</section>
</article>
