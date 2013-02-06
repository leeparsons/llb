<?php
/*
 *Template Name: About
 */
    
    
get_header(); 
    
    ?><section class="col1"><?php
        if (have_posts()) {
        while ( have_posts() ) {
    
            
            the_post();
            

            get_template_part( 'content', 'page' );


        }
        }
        
        $users = get_users();
        
        foreach ($users as $u) {

        ?><section class="entry-meta">
<h4 class="section-title"><span>About <?php echo ucwords(get_the_author_meta('display_name', $u->ID)); ?></span><span class="stripe"></span></h4>
<div class="author-posted wide-wrap">

<div class="author-short-meta"><a style="margin-top:10px;" class="fl" href="<?php

echo get_author_posts_url( $u->ID, get_the_author_meta('user_nicename', $u->ID) );

?>"><?php

userphoto_the_author_thumbnail('', '', array(), '', $u->ID);

?></a><p class="fl author-posted-meta" style="border-top:0;"><?php
    
    if (strlen(get_the_author_meta('description', $u->ID)) > 400) {
        echo nl2br(substr(get_the_author_meta('description', $u->ID), 0, 400)) . '... <a href="' . get_author_posts_url( $u->ID, get_the_author_meta('user_nicename', $u->ID) ) . '">[read more]</a>';
    } else {
        echo nl2br(get_the_author_meta('description', $u->ID));
    }
    ?><br/><br/></p></div>
<p class="author-links-wrap">
<span>Connect with the author:<br/></span>
<?php if (get_the_author_meta('url', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('url', $u->ID) ?>" class="author-links www"><?php echo get_the_author_meta('url', $u->ID) ?></a>
<?php } ?>
<?php if (get_the_author_meta('blog', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('blog', $u->ID) ?>" class="author-links author-blog"><?php echo get_the_author_meta( 'blog', $u->ID) ?></a>
<?php } ?>
<?php if (get_the_author_meta('twitter', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('twitter', $u->ID) ?>" class="author-links author-twitter"><?php echo get_the_author_meta( 'twitter', $u->ID) ?></a>
<?php } ?>
<?php if (get_the_author_meta('facebook', $u->ID)) { ?>
<a href="<?php echo get_the_author_meta('facebook', $u->ID) ?>" class="author-links author-facebook"><?php echo get_the_author_meta('facebook', $u->ID) ?></a>  
<?php } ?>
</p>
<div class="author-link">
<a href="<?php echo get_author_posts_url( $u->ID, get_the_author_meta('user_display_name', $u->ID) ); ?>" rel="author">View all posts by <?php echo $u->display_name; ?></a>
</div>
</div>
</section><?php            
        }

        
?></section><?php
    
    get_sidebar();
    
    get_footer();