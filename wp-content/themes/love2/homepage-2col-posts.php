<?php

$ci = 0;
    
foreach ($cat_arr as $c) {

    if ($ci%2 == 0) {
        echo '<div class="fl">';
    }
    
    wp_reset_query();
    query_posts(array('showposts' => '5', 'cat'    =>  $c));    
    
    if (have_posts()) { ?>
    <div class="two-col<?php echo ($ci % 2 == 1) ? ' even' : '' ?>">
<?php
    
    $i = 0;
    while (have_posts()) {
        
        $i++;
        the_post();
        if ($i == 1) { ?>
        <h2 class="section-title"><span><?php $cat = get_category($c); echo $cat->name ?></span><span class="stripe"></span></h2>
        <div class="wide-wrap">
    <?php 
        } elseif ($i == 2) {
    ?><div class="post-stack"><?php
        }

        ?><article><?php

        if ($i == 1 && has_post_thumbnail()) {
            //see if the cache image exists? should speed things up!
            echo '<div class="spacer"></div>';
            love_image_cache('two-col-post', 298, '', true, 'stack-a');
        } else {
            love_image_cache('small-thumb', 50, 's-tmb', true, 'stack-img', '', get_field('thumbnail'), true);
        }
        
        if ($i > 1) {
    ?>
        <div class="stack-meta">
        <?php
        }
        ?>    
        <h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
        <p class="meta"><strong>Posted on: </strong><a href="<?php the_permalink() ?>"><time class="date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M. jS, Y'); ?></time></a></p>
        <?php
        if ($i > 1) {
        //end stack meta wrap
        ?>
        </div>
    <?php
        } else {
            
            get_template_part('home-col-excerpt');
            
        }
    ?></article><?php 
        
    }
        if ($i > 2) {
            echo '</div>';
        }
    
    ?>
<?php 

    }

    echo '<nav class="home-pagination pagination"><a href="/category/' . $cat->slug . '">See all posts »</a></nav></div></div>';
    
    if ($ci%2 == 1) {

        echo '</div>';
    }
    $ci++;
}
    

    

    if ($ci % 2 == 1) {
     echo '</div>';   
    }
    
?>