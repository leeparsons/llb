<p class="meta"><strong>Posted by:</strong> <span><a href="<?php

$aUrl = get_author_posts_url( get_the_author_meta( 'ID' ) );
echo $aUrl;

?>"><?php echo ucwords(get_the_author()); ?></a></span> <strong>On: </strong><a href="/<?php the_date('Y/m'); ?>/"><time class="date"><?php echo get_the_date('M. dS, Y'); ?></time></a></p>
<?php
    
    $cats = get_the_category('');
    if (strtolower($cats[0]->name) != 'uncategorized' && strtolower($cats[0]->name) != '') {
        
        echo '<p class="meta"><strong>Posted in: </strong><a href="/categories/' . $cats[0]->slug . '/"><span>' . $cats[0]->name . '</span></a></p>';
        
    }
    
    unset($cats);
    
