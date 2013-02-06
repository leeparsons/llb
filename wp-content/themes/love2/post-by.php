<div class="meta-wrap"><p class="meta">Posted by: <a href="<?php

$aUrl = get_author_posts_url( get_the_author_meta( 'ID' ) );
echo $aUrl;

?>"><?php echo ucwords(get_the_author()); ?></a> On: <a href="/<?php the_date('Y/m'); ?>/"><time class="date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M. jS, Y'); ?></time></a></p>
<?php
    
    $cats = get_the_category('');
    if (strtolower($cats[0]->name) != 'uncategorized' && strtolower($cats[0]->name) != '') {
        echo '<p class="meta">Posted in: <a href="/categories/' . $cats[0]->slug . '/"><span>' . $cats[0]->name . '</span></a></p>';
    }
    
    unset($cats);
    
?></div>