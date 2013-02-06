<section class="entry-meta">
<h4 class="section-title"><span>About <?php echo ucwords(get_the_author_meta('display_name')); ?></span><span class="stripe"></span></h4>
<div class="author-posted wide-wrap">

<p class="author-short-meta"><a href="<?php

echo get_author_posts_url( get_the_author_ID(), get_the_author_meta('user_nicename') )

?>"><?php
userphoto_the_author_thumbnail();
?></a><?php
    
    if (strlen(get_the_author_meta('description')) > 400) {
        echo nl2br(substr(get_the_author_meta('description'), 0, 400)) . '... <a href="' . get_author_posts_url( get_the_author_ID(), get_the_author_meta('user_nicename') ) . '">[read more]</a>';
    } else {
        echo nl2br(get_the_author_meta('description'));
    }
    ?><br/><br/></p>
<p class="author-links-wrap">
<span>Connect with the author:<br/></span>
<?php if (get_the_author_meta('url')) { ?>
<a href="<?php echo get_the_author_meta('url') ?>" class="author-links www"><?php echo get_the_author_meta('url') ?></a>
<?php } ?>
<?php if (get_the_author_meta('blog')) { ?>
<a href="<?php echo get_the_author_meta('blog') ?>" class="author-links author-blog"><?php echo get_the_author_meta( 'blog') ?></a>
<?php } ?>
<?php if (get_the_author_meta('twitter')) { ?>
<a href="<?php echo get_the_author_meta('twitter') ?>" class="author-links author-twitter"><?php echo get_the_author_meta( 'twitter') ?></a>
<?php } ?>
<?php if (get_the_author_meta('facebook')) { ?>
<a href="<?php echo get_the_author_meta('facebook') ?>" class="author-links author-facebook"><?php echo get_the_author_meta('facebook') ?></a>  
<?php } ?>
</p>
<div class="author-link">
<a href="<?php echo get_author_posts_url( get_the_author_ID(), get_the_author_meta('user_nicename') ); ?>" rel="author">View all posts by <?php echo get_the_author(); ?></a>
</div>
</div>
</section>