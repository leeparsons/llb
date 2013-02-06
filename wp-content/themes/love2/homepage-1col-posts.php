<div class="wide-section one-col"><?php

foreach ($cat_arr as $ci => $c) {
    
    wp_reset_query();
    
    query_posts(array('showposts' => '5', 'cat'    =>  $c));    
    
    
    if (have_posts()) {
                
        $i = 0;
        while (have_posts()) {
            
            the_post();
            
            
            $i++;
            
            if ($i == 1) { ?>
                <h2 class="section-title"><span><?php $cat = get_category($c); echo $cat->name ?></span><span class="stripe"></span></h2>
                <div class="wide-wrap">
                <?php
            } elseif ($i == 2) { ?>
                <div class="post-stack">

<?php       }
            ?>
            <article><?php
            
            if ($i == 1 && has_post_thumbnail()) {
                //see if the cache image exists? should speed things up!
                echo '<div class="header fl">';
                love_image_cache('one-col-post', 300, '', true, 'headimg fl');
            } else {
                love_image_cache('small-thumb', 50, 's-tmb', true, 'stack-img', '', get_field('thumbnail'), true);
            }
            
            if ($i > 1) {
                ?>
                <div class="stack-meta">
                    <h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
                    <p class="meta"><strong>Posted on: </strong><a href="<?php the_permalink() ?>"><time class="date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M. jS, Y'); ?></time></a></p>
                </div>
                <?php
            } else {
                ?>
                <div class="fl">
                    <h4 class="fl"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
                    <p class="meta fl"><strong>Posted on: </strong><a href="<?php the_permalink() ?>"><time class="date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M. jS, Y'); ?></time></a></p>
                   <?php get_template_part('home-col-excerpt') ?>
                </div></div><?php
            }
            ?>
            </article>
            <?php
            
        }//end while
        
        if ($i > 2) {
            echo '</div>';
        }
                echo '<nav class="home-pagination pagination"><a href="/category/' . $cat->slug . '">See all posts »</a></nav>';

        ?></div><?php
    }
}
?></div>